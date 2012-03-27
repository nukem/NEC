<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Userlogin extends Controller {
    
    function Userlogin() {
        
        parent::Controller();
        
    }
    
    function index() {
        
        if (isset($_POST['username']) && isset($_POST['password'])) {
            /*
            * if the login form is posted
            * process logon details
            */
            if ( $userdata = $this->login_model->process_login($this->input->post('username'),  sha1($this->input->post('password'))) ) {
                
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('logged_in_user', $userdata[0]);
				$this->session->set_userdata('permission_level', $userdata[0]['category_fk']);
                redirect($this->input->post('last_url'));
                exit();
                
            } else {
                
                $this->session->set_flashdata('system_errors', array('ACCESS DENIED', 'Invalid username and/or password. Please ensure you have an active account with us.'));
                redirect('userlogin/');
                exit();
            }
            
        } else {
            /*
            * destroy session
            * show login details
            */
            $this->session->set_userdata('logged_in', false);
            $this->session->set_userdata('logged_in_user', false);
            $this->load->view('login_view');
            
        }
        
        
    }
    
}

?>
