<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends Model {
	
	var $current_user = array();
	
    function News_model()
	{    
        parent::Model();  
		$this->current_user = $this->session->userdata('logged_in_user');
    }
	
	/*
	* Get all news articles
	*/
	function get_news_articles($parent = 629, $user_category = 0) {
		
		$filter = '';
		if ($this->current_user['category_fk'] != 181) {
			$filter = "AND `category_fk` = {$user_category}";
		}
		
		$news_items = array();
		
		// get all permitted folders
		$query = $this->db->query("SELECT DISTINCT(`id`) FROM `wp_structure`, `nec_permissions` WHERE `online` = 1 AND `link` = `id` AND `parent` = '{$parent}' {$filter} ORDER BY `position`");
		
		$i = 0;
		if ($query->num_rows() > 0) foreach ($query->result_array() as $ids) {
			
			// get all child articles
			$nq = $this->db->query("SELECT `id` FROM `wp_structure` WHERE `online` = 1 AND `type` = 'article' AND `parent` = '{$ids['id']}' ORDER BY `position`");
			
			if ($nq->num_rows() > 0) foreach ($nq->result_array() as $row) {
				
				$news_items[$i] = $this->get_article_details($row['id']);
				
				$i++;
				
			}
			
		}
		
		return $news_items;
		
	}
	
	
	/*
	* Single news article detail
	*/
	function get_article_details($id) {
		
		$nq = $this->db->query("SELECT `id`, `title`, `content` FROM `wp_structure`, `wp_article` WHERE `online` = 1 AND `link` = `id` AND `id` = '{$id}' ORDER BY `position`");
		
		$news_item = array();
		
		if ($nq->num_rows() > 0) foreach ($nq->result_array() as $row) {
			
			$news_item = $row;
			
			$iq = $this->db->query("SELECT `id`, `title` FROM `wp_structure` WHERE `online` = 1 AND `type` = 'image' AND `parent` = '{$row['id']}' ORDER BY `position`");
			
			if ($iq->num_rows() > 0) {
				$news_item['images'] = $iq->result_array();
			}
			
			$fq = $this->db->query("SELECT `id`, `title`, `uri`, `extension` FROM `wp_structure`, `wp_file` WHERE `online` = 1 AND `link` = `id` AND `parent` = '{$row['id']}' ORDER BY `position`");
			
			if ($fq->num_rows() > 0) {
				$news_item['files'] = $fq->result_array();
			}
			
		}
		
		return $news_item;
		
	}

}