<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Controller {

	var $cfg;

	function Account()
	{
		parent::Controller();
		$this->load->library('validation');
		$this->load->model('account_model');
		$this->cfg = $this->config->item('nec');
	}
	
	function index()
	{
		echo 'test';
	}
	
	function register($id = false)//function register($id = false, $dev = false)
	{
        
        if (preg_match('/^[0-9]+$/', $id) && isset($_POST['delete_user'])) {
            
            $this->account_model->delete_user($id);
            $this->session->set_flashdata('confirm', array('User Account Deleted!'));
            redirect('usermgmt/', 'refresh');
            
        }
        $rules['ac_confirm'] ="required";
        $rules['name'] = "trim|required|min_length[3]";
		$rules['company'] = "trim|required|min_length[2]";
        $rules['telephone'] = "trim|required|min_length[8]";
		$rules['email'] = "trim|required|valid_email";
		$rules['state'] = "callback_state_check";
        $rules['postcode'] = "trim|required|numeric|exact_length[4]";
		$rules['position'] = "trim";
		$rules['address'] = "trim";
		
	if(isset($_POST['ac_confirm'])){
		
		if($_POST['ac_confirm'] == 'y'){
			$rules['dealer_no'] = "trim|required|callback_is_unique_dealer";
			$rules['password'] = "trim|required|callback_check_password";
			$rules['password_2'] = "trim|required|matches[password]";
		}
		else if($_POST['ac_confirm'] == 'n') {
			$rules['relationship'] = "trim|required";
			$rules['reason'] = "trim|required";
			$rules['referee'] = "trim|required";
			$rules['username'] = "trim|required|callback_is_unique_username";
			$rules['password_3'] = "trim|required|callback_check_password";
			$rules['password_4'] = "trim|required|matches[password_3]";
		}
	}
		
	$this->validation->set_rules($rules);
	
	$fields['ac_confirm'] = "Your account type";	
	$fields['name'] = "Full Name";
	$fields['company'] = "Company Name";
        $fields['telephone'] = "Contact Number";
       	$fields['email'] = "Email Address";
	$fields['state'] = "State";
        $fields['postcode'] = "Postcode";
        $fields['position'] = "";
	$fields['address'] = "";

	$fields['dealer_no'] = 'Dealer Number';
	$fields['password'] = "Password";
	$fields['password_2'] = "Password Confirmation";

	$fields['relationship'] = "Relationship with NEC";
	$fields['reason'] = "Reason for access";
	$fields['referee'] = "Who referred you to this site";
	$fields['username'] = "user name";
	$fields['password_3'] = "password";
	$fields['password_4'] = "password confirmation";

        
		$this->validation->set_fields($fields);
		
		$this->validation->set_error_delimiters('<p class="field-error">', '</p>');
		
		if ($this->validation->run() == false) {
            
            /*
             
            if (preg_match('/^[0-9]+$/', $id) && !$this->input->post('name')) {
                $user_data = $this->account_model->get_user('userid', $id);
                if (is_array($user_data) && count($user_data) > 0) foreach ($user_data[0] as $udk => $udv) {
                    if (isset($this->validation->$udk)) {
                        $this->validation->$udk = $udv;
                        $data['test'][] = $udv;
                    }
                }
            }
            */
			$data['test'] = '';
			$this->load->view('ac_register_view', $data);
			/*if ($dev == true)
			{
				$this->load->view('ac_register_view', $data);
			}
			else
			{
				$this->load->view('service_unavailable');
			}*/
		} else {
			// good to go
			// process data
			$data['test'] = '';
            
			foreach($rules as $key => $val) {
				$update_data[$key] = $this->input->post($key);
			}
			unset($update_data['ac_confirm']);
			if (isset($update_data['password']))
			{
				$my_password = $update_data['password'];
				$update_data['password'] = sha1($update_data['password']);
			}
			else if (isset($update_data['password_3']))
			{
				$my_password = $update_data['password_3'];
				$update_data['password'] = sha1($update_data['password_3']);
				$update_data['dealer_no'] = $update_data['username'];
				unset($update_data['password_3'],$update_data['username']);
			}
			
			if (isset($update_data['relationship']))
			{
				$update_data['comments'] =
"Relationship with NEC: {$update_data['relationship']}

Reason for access: {$update_data['reason']}

Who referred you to this site: {$update_data['referee']}";

			}
			unset($update_data['relationship'],$update_data['reason'],$update_data['referee']);
			$update_data['created'] = $update_data['modified'] = date('Y-m-d H:i:s');
			
			unset($update_data['password_2'], $update_data['update_password'], $update_data['password_4']);
			
			if (!$this->input->post('update_password') && preg_match('/^[0-9]+$/', $id)) {
			    unset($update_data['password']);
			}
				    
			if (preg_match('/^[0-9]+$/', $id)) {
			    
			    //update
			    if ( $this->account_model->update_user($id, $update_data) ) {
				$data['update_status'] = true;
				$logged_in_user = $this->session->userdata('logged_in_user');
				if ($this->input->post('update_password') && preg_match('/^[0-9]+$/', $id) && $id == $logged_in_user['userid']) {
				    $logged_in_user['password'] = sha1($this->validation->password);
				    $this->session->set_userdata('logged_in_user', false);
				    $this->session->set_userdata('logged_in_user', $logged_in_user);
				}
			    } else {
				$data['update_status'] = false;
			    }
			    
			    
			} else {
			    
			    // insert
			    if ($this->account_model->insert_user($update_data)) {
				$data['submit_status'] = true;
				$msg = "Hi There,
	    
Thank you for registering your interest for the NEC Dealer Intranet.

Your details will be reviewed and you will be notified of the decision via email.
If your account is approved, please use the following details to login.

Login : {$update_data['dealer_no']}
Password : {$my_password}

Please keep this email with you until you are notified regarding status of the account.

- Administrator
- NEC Dealer Intranet";
                             
				mail($this->validation->email, 'NEC Dealer Intranet - Registration', $msg, "From:{$this->cfg['admin_email']}\r\nCc:{$this->cfg['admin_email']}");
			    } else {
					$data['submit_status'] = false;
			    }
			    
			}
			
			$this->load->view('ac_register_view', $data);
			/*if ($dev == true)
			{
				$this->load->view('ac_register_view', $data);
			}
			else
			{
				$this->load->view('service_unavailable');
			}*/
			
		}
	}
    
	
	// function to check if the dealer exists
	function is_unique_dealer($number) {
		if ($this->account_model->get_user('dealer_no', $number) == false) {
			return true;
		} else {
			$this->validation->set_message('is_unique_dealer', 'This Dealer Number is already registered. Please contact the administrator.');
			return false;
		}
		
	}
	
	// function to check if the username exists
	function is_unique_username($number) {
		
		if(!preg_match('/[A-Za-z0-9]+/i',$number)){
				$this->validation->set_message('is_unique_username', 'Username must only include numbers and letters but no other characters');
				return false;
		}
		
		if ($this->account_model->get_user('dealer_no', $number) == false) {
			return true;
		} else {
			$this->validation->set_message('is_unique_username', 'This Username is already in use, please try with a different Username.');
			return false;
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
	
	function state_check($state) {
		if (!in_array($state, array("NSW", "VIC", "QLD", "ACT", "WA", "SA", "NT", "TAS"))) {
			$this->validation->set_message('state_check', 'Please select your state');
			return false;
        } else {
            return true;
        }
	}
    
    function category_check($cat) {
        if ($cat == 0) {
            $this->validation->set_message('category_check', 'You must select a category');
			return false;
        } else {
            return true;
        }
    }
	
	function forgot_password()
	{
		
		$rules['dealer_no'] = "trim|required|callback_dealer_num_check";
		
		$this->validation->set_rules($rules);
		
		$fields['dealer_no'] = "NEC Account Number";
        
		$this->validation->set_fields($fields);
		
		$this->validation->set_error_delimiters('<p class="field-error">', '</p>');
		
		if ($this->validation->run() == false) {
			
			$this->load->view('ac_forgot_view');
			
		} else {
			
			$user = $this->account_model->get_user('dealer_no', $this->validation->dealer_no);
			$user = $user[0];
			$msg = "To the administrator,

The following user requested a password re-set via the 'Recover Password' page on the Dealer Intranet.
Please re-assign a new password for this user by editig their details through WebPublisher.

NEC Account No : {$user['dealer_no']}
Company : {$user['company']}
Name : {$user['name']}
Email : {$user['email']}
State : {$user['state']}

Please disregard this email if you have not made this request. 

- Administrator
- NEC Dealer Intranet";
            mail($this->cfg['admin_email'], 'NEC Dealer Intranet - Password Recovery', $msg, "From:{$this->cfg['admin_email']}");
			$data['submit_status'] = true;
			$this->load->view('ac_forgot_view', $data);
			
		}
		
	}
	
	function dealer_num_check($dealer_no) {
		
		if ($this->account_model->get_user('dealer_no', $dealer_no)) {
			return true;
		} else {
			$this->validation->set_message('dealer_num_check', 'This NEC Account Number does not exist in our database');
			return false;
		}
		
	}
    
    function ajax_get_user($id) {
        $data = $this->account_model->get_user('userid', $id);
        if (is_array($data) && count($data) > 0) {
            $out = $data[0];
			$out['error'] = false;
			if(!empty($data[0]['last_login']) && ($data[0]['last_login'] != '0000-00-00 00:00:00'))
			{
				$out['last_login'] = date('j/M/Y', strtotime($data[0]['last_login']));
			} else {
				$out['last_login'] = '';
			}
			echo json_encode($out);
        } else {
            echo '{error:true, errorMsg:"Failed to obtain database details!"}';
        }
    }
    
    //function ajax_approve_user($id, $category = 0, $dealer_no, $pb_category) {
	function ajax_approve_user() {
		
		$id = $this->input->post('id');
		$category = $this->input->post('cate');
		$dealer_no = $this->input->post('dealer_no');
		$pb_category = $this->input->post('pb_cate');
		
        if ($category == 0) {
            echo '{error:true, errorMsg:"No category specified!"}';
            return false;
        }
		if ($pb_category == 0) {
		    echo '{error:true, errorMsg:"No pricebook category specified!"}';
			return false;
		}
		if ($this->account_model->get_user_mixed(array('dealer_no' => $dealer_no, 'approved' => 1)) != false) {
			echo '{error:true, errorMsg:"This Login Name has already been used previously for an approved user!"}';
			return false;
		}
		if ($this->account_model->update_user($id, array('approved' => 1, 'category_fk' => $category, 'dealer_no' => $dealer_no, 'pricebook_fk'=>$pb_category))) {
			$user_data = $this->account_model->get_user('userid', $id);
			$msg = "Hi There,
			
Your registration for the NEC Dealer Intranet has been successful.

You can log in to the site by pointing your browser to the following address.

http://www.nec-cds.com.au/

Your Login : {$user_data[0]['dealer_no']}
Your Password : Your selected password

Please refer to the original email you received upon registration for your password. 

- Administrator
- NEC Dealer Intranet";
			mail($user_data[0]['email'], 'NEC Dealer Intranet - Registration Complete', $msg, "From:{$this->cfg['admin_email']}");
			echo "{error:false}";
		} else {
			echo '{error:true, errorMsg:"Failed to update user permissions!"}';
		}
    }
    
    function ajax_delete_user() {
        $id = $this->input->post('id');
        if ($id && preg_match('/^[0-9]+$/', $id) && $this->input->post('email')) {
            if ($user_data = $this->account_model->get_user('userid', $id)) {
                if ($this->account_model->delete_user($id)) {
                    mail($user_data[0]['email'], 'Your account application for NEC dealer Intranet has been rejected', $this->input->post('email'), "From:{$this->cfg['admin_email']}");
                    echo "{error:false}";
                } else {
                    echo '{error:true, errorMsg:"Failed to delete this user! Database error!"}';
                }
            } else {
                echo '{error:true, errorMsg:"This user does not seem to have the correct ID associated!"}';
            }
        } else {
			echo '{error:true, errorMsg:"Invalid data supplied for this request!"}';
		}
    }
    
    function ajax_user_del($id, $inform = 'no') {
        if ($this->account_model->delete_user($id)) {
            if ($inform == 'yes') {
                // inform the user
            }
            echo "{error:false}";
        } else {
            echo "{error:true, errormsg:'DB Error, deletion failed!'}";
        }
    }
    
    function ajax_add_edit_user() {
        
        $rules['name'] = "trim|required|min_length[3]";
		$rules['company'] = "trim|required|min_length[2]";
        $rules['telephone'] = "trim|required|min_length[8]";
        
        if (
				$this->input->post('new_user')
				||
				( ! $this->input->post('new_user') && $this->input->post('existing_dealer_no') != $this->input->post('dealer_no'))
			)
		{
            $rules['dealer_no'] = "trim|required|callback_is_unique_dealer";
        } else {
            $rules['dealer_no'] = "trim|required";
        }
		
		$rules['email'] = "trim|required|valid_email";
		
		if ($this->input->post('update_user_password')) {
			$rules['password'] = "trim|required|callback_check_password";
		} else {
			$rules['password'] = "trim";
		}
		$rules['pricebook_fk'] = "trim|required";//must choose one pricebook type
		$rules['state'] = "callback_state_check";
        $rules['postcode'] = "trim|required|numeric|exact_length[4]";
		$rules['position'] = "trim";
		$rules['address'] = "trim";
		
		$this->validation->set_rules($rules);
		
		$fields['name'] = "Full Name";
		$fields['company'] = "Company Name";
        $fields['telephone'] = "Contact Number";
        $fields['dealer_no'] = 'Dealer Number';
		$fields['email'] = "Email Address";
		$fields['password'] = "Password";
		$fields['state'] = "State";
        $fields['postcode'] = "Postcode";
        $fields['position'] = "";
		$fields['address'] = "";
        $fields['category_fk'] = '';
		$fields['pricebook_fk'] = "Pricebook Category";//price book category type
        
		$this->validation->set_fields($fields);
		
		$this->validation->set_error_delimiters('', '<br />');
        
        if ($this->validation->run() == false) {
            
            $json['error'] = true;
            $json['errormsg'] = $this->validation->error_string;
            
        } else {
            
            $capture = array();
            foreach ($fields as $k => $v) {
                if ($this->input->post($k)) $capture[$k] = $this->input->post($k);
            }
            
            if ($this->input->post('new_user')) { // insert
                
                $capture['approved'] = 1; // admin inserts this record, user automatically approved
                $capture['password'] = sha1($capture['password']); // encrypt password
				
                if ($this->account_model->insert_user($capture)) {
                    
                    $json['error'] = false;
                    $json['msg'] = 'User Successfully Inserted!';
                    if ($this->input->post('new_user_email')) {
                        $msg = "Hi There,

Your account for the NEC Dealer Intranet has been successfully created.

You can log in to the site by pointing your browser to the following address.

http://www.nec-cds.com.au/

Your Login : {$this->validation->dealer_no}
Your Password : {$this->validation->password}

- Administrator
- NEC Dealer Intranet";
                        mail($this->validation->email, 'NEC Dealer Intranet - Registration Complete', $msg, "From:{$this->cfg['admin_email']}");
                    }
                    
                } else {
                    $json['error'] = true;
                    $json['errormsg'] = 'Error inserting the user!';
                }
                
            } else { // update
				
				
				if ($this->input->post('update_user_password')) {
					$capture['password'] = sha1($capture['password']);
					$password_updated = true;
				} else {
					unset($capture['password']);
					$password_updated = false;
				}
                
                if ($this->account_model->update_user($this->input->post('userid'), $capture)) {
                    
                    $json['error'] = false;
                    $json['msg'] = 'User Successfully Updated!';
					$pass_text = ($password_updated == true) ? "Your Password : {$this->validation->password}" : 'Your Password : Your current password';
                    if ($this->input->post('new_user_email') || $password_updated == true) {
                        $msg = "Hi There,

Your account for the NEC Dealer Intranet has been updated.

Following are your latest login details.

http://www.nec-cds.com.au/

Your Login : {$this->validation->dealer_no}
{$pass_text}

- Administrator
- NEC Dealer Intranet";
                        mail($this->validation->email, 'NEC Dealer Intranet - User account updated', $msg, "From:{$this->cfg['admin_email']}");
                    }
                    
                } else {
                    $json['error'] = true;
                    $json['errormsg'] = 'Error updating the user!';
                }
                
            }
            
        }
        
        echo json_encode($json);
        
    }
    
}
?>