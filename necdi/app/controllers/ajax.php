<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Controller {

	function Account()
	{
		parent::Controller();
		$this->load->library('validation');
		$this->load->model('account_model');
	}
	
	function index()
	{
		
	}
	
	function register($id = false)
	{
		$admin = $this->login_model->check_login(array(1), true);
        
        if ($admin && preg_match('/^[0-9]+$/', $id) && isset($_POST['delete_user'])) {
            
            $this->account_model->delete_user($id);
            $this->session->set_flashdata('confirm', array('User Account Deleted!'));
            redirect('usermgmt/', 'refresh');
            
        }
        
        $rules['name'] = "trim|required|min_length[3]";
		$rules['company'] = "trim|required|min_length[2]";
        $rules['telephone'] = "trim|required|min_length[8]";
		$rules['dealer_no'] = "trim|required|callback_is_unique_dealer";
		$rules['email'] = "trim|required|valid_email";
		$rules['password'] = "trim|callback_check_password";
		$rules['password_2'] = "trim|matches[password]";
		$rules['state'] = "callback_state_check";
		$rules['position'] = "trim";
		$rules['address'] = "trim";
        if ($admin) {
            $rules['category_fk'] = "callback_category_check";
        }
		
		$this->validation->set_rules($rules);
		
		$fields['name'] = "Full Name";
		$fields['company'] = "Company Name";
        $fields['telephone'] = "Contact Number";
        $fields['dealer_no'] = 'Dealer Number';
		$fields['email'] = "Email Address";
		$fields['password'] = "Password";
		$fields['password_2'] = "Password Confirmation";
		$fields['state'] = "State";
        $fields['position'] = "";
		$fields['address'] = "";
        if ($admin) {
            $fields['category_fk'] = "User Category";
        }
        
		$this->validation->set_fields($fields);
		
		$this->validation->set_error_delimiters('<p class="field-error">', '</p>');
		
		if ($this->validation->run() == false) {
            
            $data['test'] = '';
            if ($admin && preg_match('/^[0-9]+$/', $id) && !$this->input->post('name')) {
                $user_data = $this->account_model->get_user('userid', $id);
                if (is_array($user_data) && count($user_data) > 0) foreach ($user_data[0] as $udk => $udv) {
                    if (isset($this->validation->$udk)) {
                        $this->validation->$udk = $udv;
                        $data['test'][] = $udv;
                    }
                }
            }
			$this->load->view('ac_register_view', $data);
            
		} else {
			// good to go
			// process data
            $data['test'] = '';
            
			foreach($rules as $key => $val) {
				$update_data[$key] = $this->input->post($key);
            }
			$update_data['password'] = sha1($update_data['password']);
			$update_data['created'] = $update_data['modified'] = date('Y-m-d H:i:s');
			unset($update_data['password_2']);
            unset($update_data['update_password']);
            if (!$this->input->post('update_password') && preg_match('/^[0-9]+$/', $id)) {
                unset($update_data['password']);
            }
			
            if ($admin && preg_match('/^[0-9]+$/', $id)) {
                
                //update
                if ( $this->account_model->update_user($id, $update_data) ) {
                    $data['update_status'] = true;
                    $logged_in_user = $this->session->userdata('logged_in_user');
                    if ($this->input->post('update_password') && preg_match('/^[0-9]+$/', $id) && $admin && $id == $logged_in_user['userid']) {
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
                } else {
                    $data['submit_status'] = false;
                }
                
            }
			$this->load->view('ac_register_view', $data);
		}
	}
	
	// function to check if the dealer exists
	function is_unique_dealer($number) {
		if ( $this->login_model->check_login(array(1), true) && preg_match('/^[0-9]+$/', $this->uri->segment(3)) ) return true;
		if ($this->account_model->get_user('dealer_no', $number) == false) {
            return true;
        } else {
            $this->validation->set_message('is_unique_dealer', 'This Dealer Number is already registered. Please contact the administrator.');
			return false;
        }
		
	}
	
	// function to check strong password
	function check_password($password) {
        if ( $this->login_model->check_login(array(1), true) && !$this->input->post('update_password') ) return true;
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
		
	}
}
?>