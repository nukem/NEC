<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Promotion_model extends Model {
	
	# deprecated !!
	
	var $current_user = array();
	
    function Promotion_model()
	{    
        parent::Model();  
		$this->current_user = $this->session->userdata('logged_in_user');
    }
	
	function get_promotion_folder($id)
	{
		$sql = "SELECT *
				FROM `wp_structure`, `wp_folder`
				WHERE `link` = `id`
				AND `online` = 1 AND `parent` = 637
				AND `id` = ?";
		$q = $this->db->query($sql, array($id));
		
		if ($q->num_rows() > 0)
		{
			return $q->row_array();
		}
		
		return FALSE;
	}
	
}
