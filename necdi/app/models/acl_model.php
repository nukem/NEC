<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acl_model extends Model {
	
	var $current_user = array();
	
    function Acl_model() {    
        
		parent::Model();
		$this->current_user = $this->session->userdata('logged_in_user'); 
		  
    }
    
    function check_access_tree($id, $category) {
		
		if (!preg_match('/^[0-9]+$/', $id)) {
			return false;
		}
		
		$acl = array();
		if ($category == 181) {
		   $acl_q = $this->db->query("SELECT `id` AS `link`
									  FROM `wp_structure`");
		} else {
		   $acl_q = $this->db->query("SELECT `link`
									  FROM `nec_permissions`
									  WHERE `category_fk` = '{$this->current_user['category_fk']}'");
		}
		
		if ($acl_q->num_rows() > 0) {
		   foreach($acl_q->result_array() as $acl_row) {
			  $acl[] = $acl_row['link'];
		   }
		}
		
		$i = $id;
		$path = array();
		
		while ($i != 0) {
			$db = $this->db->query("SELECT id, parent FROM wp_structure WHERE id = $i");
			$x = $db->result_array();
			$i = $x[0]['parent'];
			$path[] = $x[0]['id'];
		}
		$path = array_reverse($path);
		
		$access = true;
		
		if (!in_array($path[1], $acl)) {
			$access = false;
		}
		
		if (!in_array($path[0], $acl)) {
			$access = false;
		}
		
		return $access;
		
	}
	
	function check_access($id, $category) {
	
		if (!preg_match('/^[0-9]+$/', $id)) {
			return false;
		}
		
		
		if ($category == 181) {
		   
		   return true;
		   
		} else {
		
			$acl = array();
			$acl_q = $this->db->query("SELECT `link`
									  FROM `nec_permissions`
									  WHERE `category_fk` = '{$this->current_user['category_fk']}'");
									  
			if ($acl_q->num_rows() > 0) {
				foreach($acl_q->result_array() as $acl_row) {
				  $acl[] = $acl_row['link'];
				}
			}
			
			return (in_array($id, $acl)) ? true : false;
			
		}
	
	}
    
}