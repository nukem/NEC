<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usermgmt extends Controller {
    
    function Usermgmt()
    {
        parent::Controller();
        $this->login_model->check_login(array(1));
        $this->load->model('account_model');
		$this->load->library('validation');
    }
    
    function index($search = false)
	{
	
		if(isset($_REQUEST['search'])){
			$search = addslashes($_REQUEST['search']);
			redirect('usermgmt/search/'.$search);
		}
	
		$data['users'] = $this->account_model->user_list($search);
		$this->load->view('user_list_view', $data);
		
	}
	
	function search($criteria = false){
	
		if($criteria === false){
			redirect('usermgmt');
		}
	
		$data['users'] = $this->account_model->user_list($criteria);
		$this->load->view('user_list_view', $data);
	
	}
    
    
}

?>