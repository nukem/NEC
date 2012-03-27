<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notallowed extends Controller {
    
    function Notallowed() {
        
        parent::Controller();
        
    }
    
    function index() {
        
        $data['notallowed'] = true;
        $this->load->view('not_allowed', $data);
        
    }
    
}

?>