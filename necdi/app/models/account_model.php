<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends Model {
	
	var $user_table = 'nec_users';
    var $user_primary = 'userid';
	var $user_field = 'dealer_no';
	var $password_field = 'password';
	var $level_field = 'category';
	
    function Account_model()
	{    
        parent::Model();   
    }
    
    function insert_user($data)
	{
		if ( $this->db->insert($this->user_table, $data) ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}
    
    function update_user($id, $data)
	{
        $this->db->where($this->user_primary, $id);
        return $this->db->update($this->user_table, $data);
    }
	
	function get_user($field = '', $value = '')
	{
		$query = $this->db->get_where($this->user_table, array($field => $value));
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
 	}
	
	function get_user_mixed($data = array())
	{
		if (!is_array($data)) return false;
		
		$query = $this->db->get_where($this->user_table, $data);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
 	}
	
	function user_count() 
	{    
        return $count = $this->db->count_all($this->user_table);   
    }
	
	function user_list($search)
	{    
        $sql = "SELECT * FROM ".$this->user_table."
		LEFT JOIN nec_categories
		ON ".$this->user_table.".category_fk = nec_categories.category_id
		WHERE category_fk <> (
			SELECT `category_id` FROM `nec_categories`
			WHERE category_name = 'Administrators'
			LIMIT 1
		) ";
		if($search !== false){
			$search = urldecode($search);
			$sql .= " AND (`name` LIKE '%".$search."%' ";
			$sql .= " OR `company` LIKE '%".$search."%' ";
			$sql .= " OR `dealer_no` LIKE '%".$search."%') ";
		}		
		$sql .= " ORDER BY `name` ASC ";
		
		$accounts = $this->db->query($sql);
        $list = $accounts->result_array();
        return $list;
    }
    
    function delete_user($id)
	{   
        $this->db->where($this->user_primary, $id);
        return $this->db->delete($this->user_table);   
    }
    
}
?>