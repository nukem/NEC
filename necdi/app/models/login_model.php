<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends Model {
    
	var $user_table = 'nec_users';
	var $user_field = 'dealer_no';
	var $password_field = 'password';
	var $level_field = 'category_fk';
	
	var $categories;
	
    function Login_model() {
        
        parent::Model();
		$cats = $this->db->query("SELECT `id`, `title` FROM `wp_structure` WHERE `parent` = 124");
		$cats = $cats->result_array();
		if (is_array($cats)) foreach ($cats as $cat) {
			$this->categories[$cat['id']] = $cat['title'];
		}
		
    }
    
    function check_login($level = false, $status_only = false) {
        
        if ($this->session->userdata('logged_in') === true) {
			
			$data = $this->session->userdata('logged_in_user');
			$query = $this->process_login($data[$this->user_field], $data[$this->password_field]);
            
			if ($query == false) {
				
				if ($status_only == true) {
					return false;
				} else {
					$this->session->set_flashdata('system_errors', array('Security Violation - User Signed Out!'));
					redirect('userlogin/');
					exit();
				}
				
			} else if (is_array($level)) {
                
                if (!in_array($query[0][$this->level_field], $level)) {
                    
                    if ($status_only == true) {
						return false;
					} else {
						$this->session->set_flashdata('system_errors', array('Your access level does not allow access to this area!'));
						redirect('notallowed/');
						exit();
					}
                    
                } else {
					$this->session->set_userdata('logged_in_user', false);
					$this->session->set_userdata('logged_in_user', $query[0]);
					if ($status_only == true) return true;
				}
                
            } else {
				$this->session->set_userdata('logged_in_user', false);
				$this->session->set_userdata('logged_in_user', $query[0]);
				if ($status_only == true) return true;
			}
			
		} else {
			
			if ($status_only == true) {
				return false;
			} else if ( !in_array($this->uri->segment(1), array('userlogin', 'account')) ) {
				
				$this->session->set_flashdata('system_messages', array('PROVIDE DETAILS', 'You are required to be logged in to access this area.'));
				$this->session->set_flashdata('last_url', preg_replace('@^/@', '', $this->uri->uri_string()));
				redirect('userlogin/');
				exit();
				
			}
		}
        
    }
    
    function process_login($email, $password) {
        
        $sql = "SELECT * FROM `{$this->user_table}` WHERE `{$this->user_field}` = ? AND `{$this->password_field}` = ? AND `approved` = '1' LIMIT 1";
        $user = $this->db->query($sql, array($email, $password));
        error_reporting (E_ALL);
        if ($user->num_rows() > 0) {

			//print_r($user->result_array());die();
			$data = $user->result_array();
			$userid = $data[0]['userid'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$datetime = date('Y-m-d H:i:s');
			$area = 1;
			$sql = "UPDATE `{$this->user_table}` 
				SET login_count = login_count + 1,
				last_ip_access = '{$ip}',
				last_login = '{$datetime}',
				last_login_area = $area 
				WHERE userid={$userid}";
			$this->db->query($sql);

            return $user->result_array();
        } else {
            return false;
        }
        
    }
    
}
?>