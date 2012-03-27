<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Myaccount extends Controller {

	var $cfg;

	function Myaccount()
	{
		parent::Controller();
		$this->load->library('validation');
		$this->load->model('account_model');
		$this->cfg = $this->config->item('nec');
	}
	
	function index() {
        
        $this->login_model->check_login();
        
        $rules['name'] = "trim|required|min_length[3]";
		$rules['company'] = "trim|required|min_length[2]";
        $rules['telephone'] = "trim|required|min_length[8]";
		$rules['dealer_no'] = "trim";
		$rules['email'] = "trim|required|valid_email";
        
        if ($this->input->post('update_password')) {
            $rules['password'] = "trim|required|callback_check_password";
            $rules['password_2'] = "trim|required|matches[password]";
        }
		
		$rules['state'] = "trim";
		$rules['position'] = "trim";
		$rules['address'] = "trim";
		
		$this->validation->set_rules($rules);
		
		$fields['name'] = "Full Name";
		$fields['company'] = "Company Name";
        $fields['telephone'] = "Contact Number";
        $fields['dealer_no'] = 'Dealer Number';
		$fields['email'] = "Email Address";
        
        if ($this->input->post('update_password')) {
            $fields['password'] = "Password";
            $fields['password_2'] = "Password Confirmation";
        }
		
		$fields['state'] = "State";
        $fields['position'] = "";
		$fields['address'] = "";
        
		$this->validation->set_fields($fields);
		
		$this->validation->set_error_delimiters('<p class="field-error">', '</p>');
		
        $data['test'] = '';
        $current_user =  $this->session->userdata('logged_in_user');
		
		$data['points'] = $this->get_points_history($current_user['userid'], TRUE);
        
		if ($this->validation->run() == false) {
            
            if (!isset($_POST['name'])) {
                $user_data = $this->account_model->get_user('userid', $current_user['userid']);
                if (is_array($user_data) && count($user_data) > 0) foreach ($user_data[0] as $udk => $udv) {
                    if (isset($this->validation->$udk)) {
                        $this->validation->$udk = $udv;
                    }
                }
            }
			$this->load->view('myaccount_view', $data);
            
		} else {
            
            foreach($rules as $key => $val) {
				$update_data[$key] = $this->input->post($key);
            }
            
			if ($this->input->post('update_password')) {
                $update_data['password'] = sha1($update_data['password']);
                unset($update_data['password_2']);
                unset($update_data['update_password']);
            }
            
			$update_data['modified'] = date('Y-m-d H:i:s');
            
            //update
            if ( $this->account_model->update_user($current_user['userid'], $update_data) ) {
                $data['update_status'] = true;
                if ($this->input->post('update_password')) {
                    $logged_in_user = $this->session->userdata('logged_in_user');
                    $logged_in_user['password'] = sha1($this->validation->password);
                    $this->session->set_userdata('logged_in_user', false);
                    $this->session->set_userdata('logged_in_user', $logged_in_user);
                }
            } else {
                $data['update_status'] = false;
            }
            
            $this->load->view('myaccount_view', $data);
            
        }
        
        
	}
    
    // function to check strong password
	function check_password($password) {
		if (!preg_match('/[0-9]+/i', $password) || !preg_match('/[a-z]+/i', $password) || strlen($password) < 6) {
            $this->validation->set_message('check_password', 'Password must, at least, be 6 long characters and must include both letters and numbers');
			return false;
        } else {
            return true;
        }
	}
    
	/**
	 * return the user points
	 */
	function get_user_points($userid = 0, $return = FALSE)
	{
		$sql = "SELECT SUM(`points`) AS `point_sum`
				FROM `nec_user_points`
				WHERE `userid_fk` = ?";
		$q = $this->db->query($sql, $userid);
		
		$json['balance'] = 0;
		
		if ($q->num_rows() > 0)
		{
			$data = $q->row();
			$json['balance'] = (int) $data->point_sum;
		}
		
		if ($return)
		{
			return $json['balance'];
		}
		
		$json['error'] = FALSE;
		echo json_encode($json);
	}
	
	/**
	 * add points to user
	 */
	function add_user_points()
	{
		$ins['userid_fk'] = $_POST['userid'];
		
		$ins['points'] = preg_replace('/[^0-9]/', '', $_POST['points']);
		
		if ( (int) $ins['points'] == 0)
		{
			$json['error'] = TRUE;
			$json['error_msg'] = 'Points should not be 0';
			
			echo json_encode($json);
			exit;
		}
		
		if ($_POST['tx_type'] == 2)
		{
			$ins['points'] = $ins['points'] * -1;
		}
		
		$ins['tx_reason'] = 0;
		$ins['comments'] = '';
		
		if (isset($_POST['point_comments']) && $_POST['point_comments'] != '' && $_POST['point_comments'] != 'Comments')
		{
			$ins['comments'] = $_POST['point_comments'];
		}
		
		if ($this->db->insert('nec_user_points', $ins))
		{
			$json['error'] = FALSE;
			$json['userid'] = $ins['userid_fk'];
		}
		else
		{
			$json['error'] = TRUE;
			$json['error_msg'] = 'Points insert failed!';
		}
		
		echo json_encode($json);
	}
	
	/**
	 * return table rows of point history
	 */
	function get_points_history($userid, $return = FALSE)
	{
		$json['balance'] = $this->get_user_points($userid, TRUE);
		
		$this->db->order_by('date_time', 'desc');
		$q = $this->db->get_where('nec_user_points', array('userid_fk' => $userid));
		
		$html = '';
		$data = $q->result();
		
		foreach ($data as $row)
		{
			$type = 'Credit';
			$debit_amount = $credit_amount = '';
			if ( (int) $row->points < 0)
			{
				$type = 'Debit';
				$debit_amount = $row->points * -1;
			}
			else
			{
				$credit_amount = $row->points;
			}
			
			$hidden_tr = '';
			if ($row->tx_reason == 1)
			{
				$type = 'Redemption (<a href="#" onclick="$(\'.tr-' . $row->point_id . '\').toggle(); return false;">View Details</a>)';
				$comments = json_decode($row->comments);
				$comments = nl2br($comments->html);
				$hidden_tr = <<< EOD
			<tr style="display:none;" class="tr-{$row->point_id}">
				<td colspan="5">
				{$comments}
				</td>
			</tr>
EOD;
			}
			
			$displayed_comments = ( ! preg_match('/^{"/', $row->comments)) ? $row->comments : '';
			
			$html .= <<< EOD
			<tr>
				<td>{$type}</td>
				<td align="center">{$debit_amount}</td>
				<td align="center">{$credit_amount}</td>
				<td>{$row->date_time}</td>
				<td>{$displayed_comments}</td>
			</tr>
			{$hidden_tr}
EOD;
		}
		
		$json['html'] = $html;
		$json['error'] = FALSE;
		
		if ($return)
		{
			return $json;
		}
		
		echo json_encode($json);
	}
	
	/**
	 * Facilitate point redemption
	 */
	function redeem_points($promotion = 0, $list = FALSE)
	{
		$this->login_model->check_login();
		
		$this->load->model('data_model');
		$this->load->helper('text');
		
		$data = array();
		
		$data['promotions_cart'] = $this->session->userdata('promotions_cart');
		$data['promotions_count'] = $this->session->userdata('promotions_count');
		
		if ($promotion > 0 && $promo = $this->data_model->get_single_prize($promotion))
		{
			if ( ! is_array($data['promotions_cart']))
			{
				$data['promotions_cart'] = array();
			}
			
			if ( ! is_array($data['promotions_count']))
			{
				$data['promotions_count'] = array();
			}
			
			$data['promotions_cart'][$promotion] = $promo;
			if ( ! isset($data['promotions_count'][$promotion]))
			{
				$data['promotions_count'][$promotion] = 1;
			}
			
			$this->session->set_userdata('promotions_cart', $data['promotions_cart']);
			$this->session->set_userdata('promotions_count', $data['promotions_count']);
		}
		
		$logged_in_user = $this->session->userdata('logged_in_user');
		
		$data['point_balance'] = $this->get_user_points($logged_in_user['userid'], TRUE);
		
		$data['user_company'] = $logged_in_user['company'];
		
		if ($list == 'success')
		{
			$data['complete'] = TRUE;
		}
		
		$data['redemption_form_error'] = '';
		
		if ($redemption_form_error = $this->session->userdata('redemption_form_error'))
		{
			$this->session->set_userdata('redemption_form_error', NULL);
			$data['redemption_form_error'] = $redemption_form_error;
		}
		
		if ($this->input->post('contact_name'))
		{
			/**
			 * Validate the form first
			 * */
			$form_errors = array();
			
			if ( ! preg_match('/[a-z]+/i', trim($_POST['contact_name'])))
			{
				$form_errors[] = 'Invalid Contact Name';
			}
			
			if ( ! preg_match('/[0-9]+/i', trim($_POST['contact_number'])))
			{
				$form_errors[] = 'Invalid Contact Number';
			}
			
			if ( ! filter_var(trim($_POST['contact_email']), FILTER_VALIDATE_EMAIL))
			{
				$form_errors[] = 'Invalid Contact Email';
			}
			
			if (count($form_errors))
			{
				# uh oh, we have errors bloke!
				$this->session->set_userdata('redemption_form_error', implode('<br />', $form_errors));
				redirect('myaccount/redeem_points?form_error=1');
				exit;
			}
			
			$point_total = 0;
			$part_message = '';
			$data['processed'] = array();
			foreach ($data['promotions_cart'] as $item)
			{
				$point_total += ($item['points'] * $data['promotions_count'][$item['id']]);
				$part_message .= "
Promotion: " . htmlentities($item['title'], ENT_QUOTES) . " X " . $data['promotions_count'][$item['id']] . "
Points: " . ($item['points'] * $data['promotions_count'][$item['id']]) . "
URL: ". base_url() . "promotions/prizes/" . $item['id'] . "

";
				$data['processed'][] = $item['id'];
			}
			
			if ($point_total > $data['point_balance'])
			{
				# not cool - shouldn't happen anyway
				redirect('myaccount/redeem_points?notenough_points=1');
				exit;
			}
			
			$ins['userid_fk'] = $logged_in_user['userid'];
			$ins['points'] = (int) $point_total * -1;
			$ins['tx_reason'] = 1;
			$ins['comments'] = json_encode(array('html' => $part_message, 'id_set' => $data['processed']));
			
			$this->db->insert('nec_user_points', $ins);
			
			$data['new_point_balance'] = $this->get_user_points($logged_in_user['userid'], TRUE);
			
			$subject = 'NEC - Dealer Intranet - Reward Redemption';
			
			$admin_message = 'Dear Administrator,

The following user have submitted a redemption request.
Details about their prize selections are listed below:

PLEASE NOTE: '. $point_total . ' Points have been deducted from this user account.

User: ' . $logged_in_user['name'] . '
Dealer No: ' . $logged_in_user['dealer_no'] . '
Company: ' . $logged_in_user['company'] . '
Email: ' . $logged_in_user['email'] . '

REDEMPTION FORM
Contact Name: ' . trim($_POST['contact_name']) . '
Contact Number: ' . trim($_POST['contact_number']) . '
Contact Email: ' . trim($_POST['contact_email']) . '

' . $part_message . '

Thank you
NEC National Dealer Intranet
';
			$user_message = 'Hi ' . $logged_in_user['name'] . ',

You have successfully submitted a prize redemption request.
Details about your prize selections are listed below:

PLEASE NOTE: '. $point_total . ' Points have been deducted from your user account.

REDEMPTION FORM
Contact Name: ' . trim($_POST['contact_name']) . '
Contact Number: ' . trim($_POST['contact_number']) . '
Contact Email: ' . trim($_POST['contact_email']) . '

' . $part_message . '

Please contact the site administrator, if you have any further questions about this program.

Thank you
NEC National Dealer Intranet
';
			$admin_email = $this->config->item('nec');
			
			mail($admin_email['admin_email'], $subject, $admin_message, "From:{$admin_email['admin_email']}");
			mail(trim($_POST['contact_email']), $subject, $user_message, "From:{$admin_email['admin_email']}");
			
			$this->session->unset_userdata('promotions_cart');
			redirect('myaccount/redeem_points/0/success');
			
		}
		
		$this->load->view('promotion_redeem_view', $data);
	}
	
	/**
	 * Remvoe a promotion from the redemption list
	 */
	function remove_promotion($promotion = 0)
	{
		$promotions_cart = $this->session->userdata('promotions_cart');
		
		if (isset($promotions_cart[$promotion]))
		{
			unset($promotions_cart[$promotion]);
			
			$this->session->set_userdata('promotions_cart', $promotions_cart);
		}
		
		redirect('myaccount/redeem_points');
		exit;
	}
	
	/**
	 * Facilitate quantity update
	 */
	function redemption_update()
	{
		if (isset($_POST))
		{
			$data['promotions_count'] = array();
			
			foreach ($_POST as $k => $v)
			{
				$count = (int) $v;
				if (preg_match('/^updatepromo_/', $k) && $count > 0)
				{
					$parts = explode('_', $k);
					$data['promotions_count'][$parts[1]] = $count;
				}
			}
			
			$this->session->set_userdata('promotions_count', $data['promotions_count']);
		}
		
		redirect('myaccount/redeem_points');
	}
}
