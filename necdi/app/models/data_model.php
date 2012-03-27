<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_model extends Model {
	
    function Data_model()
	{    
        parent::Model();   
    }
    
    function get_data_set($ids = array(), $repeat = 0, $mode = 'id')
	{
		if (!is_array($ids) || count($ids) < 1) {
			return false;
		} else {
			$ids = implode(',', $ids);
		}
		$range = "'folder', 'range', 'model'";
        if ($repeat < 1) $range = "'range', 'model'";
		$sql = "SELECT `id`, `uri`, `title`, `type` FROM `wp_structure` WHERE `online` = 1 AND `type` IN ({$range}) AND `{$mode}` IN ({$ids}) ORDER BY `position`";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$results = $query->result_array();
			if ($repeat > 0) {
				foreach ($results as $key => $result) {
					$child = $this->get_data_set(array($result['id']), $repeat-1, 'parent');
					$data[$key] = $result;
					if (is_array($child) && count($child) > 0) {
						$data[$key]['child_set'] = $child;
					}
				}
				return $data;
			} else {
				return $results;
			}
		} else {
			return false;
		}
	}
    
    function get_data_set_m($ids = array(), $repeat = 0, $mode = 'id')
	{
		if (!is_array($ids) || count($ids) < 1) {
			return false;
		} else {
			$ids = implode(',', $ids);
		}
		$range = "'folder', 'range', 'model'";
		$sql = "SELECT `id`, `uri`, `title`, `type` FROM `wp_structure` WHERE `online` = 1 AND `type` IN ({$range}) AND `{$mode}` IN ({$ids}) ORDER BY `position`";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$results = $query->result_array();
			if ($repeat > 0) {
				foreach ($results as $key => $result) {
					$child = $this->get_data_set_m(array($result['id']), $repeat-1, 'parent');
					$data[$key] = $result;
					if (is_array($child) && count($child) > 0) {
						$data[$key]['child_set'] = $child;
					}
				}
				return $data;
			} else {
				return $results;
			}
		} else {
			return false;
		}
	}
    
    function get_article($id) {
        $d = $this->db->query("SELECT `id`, `title`, `content`, `uri`, `parent` FROM `wp_structure`, `wp_article` WHERE `id` = '{$id}' AND `id` = `link` ORDER BY `position`");
        if ($d->num_rows() > 0) {
            return $d->result_array();
        } else {
            return false;
        }
    }
    
    function get_file($id) {
        $d = $this->db->query("SELECT `id`, `title`, `extension` FROM `wp_structure`, `wp_file` WHERE `id` = '{$id}' AND `id` = `link` ORDER BY `position`");
        if ($d->num_rows() > 0) {
            return $d->result_array();
        } else {
            return false;
        }
    }
	
	function get_child_files($id) {
        $d = $this->db->query("SELECT * FROM `wp_structure`, `wp_file` WHERE `parent` = '{$id}' AND `id` = `link` ORDER BY `position`");
        if ($d->num_rows() > 0) {
            return $d->result_array();
        } else {
            return false;
        }
    }
    
    function get_children($id, $type = "'file'") {
        
        $d = $this->db->query("SELECT * FROM `wp_structure` WHERE `parent` = '{$id}' AND `online` = 1 AND `type` IN ({$type}) ORDER BY `position`");
        if ($d->num_rows() > 0) {
            return $d->result_array();
        } else {
            return false;
        }
        
    }
	
	function get_child_images($id) {
	
		$d = $this->db->query("SELECT `id`, `title`, `uri` FROM `wp_structure` WHERE `parent` = '{$id}' AND `type` = 'image' AND `online` = 1 ORDER BY `position`");
        if ($d->num_rows() > 0) {
            return $d->result_array();
        } else {
            return false;
        }
	
	}
	
	/**
	 * get all prizes on file
	 */
	function get_prizes($parent, $limit = 50, $offset = 0, $user_category = 0)
	{
		$where = " category_fk = '{$user_category}' AND ";
		if ($user_category == 181)
		{
			$where = '';
		}
		$d = $this->db->query("SELECT *
								FROM `wp_structure`, `wp_prize`
								WHERE online =1
								AND id = link
								AND parent = '{$parent}'
								ORDER BY `position` LIMIT {$offset}, {$limit}
							");
        if ($d->num_rows() > 0)
		{
			$this->prize_count = $d->num_rows();
			
			$return = array();
            $data = $d->result_array();
			
			foreach ($data as $row)
			{
				$return[] = array_merge($row, array('images' => $this->get_child_images($row['id'])));
			}
			
			return $return;
        }
        
		return FALSE;
	}
	
	/**
	 * count all prizes
	 */
	function count_prizes($parent, $user_category)
	{
		$where = " category_fk = '{$user_category}' AND ";
		if ($user_category == 181)
		{
			$where = '';
		}
		$d = $this->db->query("SELECT COUNT(*) AS `prize_count`
								FROM `wp_structure` s, `wp_prize` p
								WHERE s.online =1
								AND s.id = p.link
								AND s.parent = '{$parent}'
							");
        if ($d->num_rows() > 0)
		{
			$data = $d->row();
			return $data->prize_count;
		}
		
		return 0;
	}
	
	/**
	 * get a single promotion
	 */
	function get_single_prize($id)
	{
		$d = $this->db->query("SELECT * FROM `wp_structure`, `wp_prize` WHERE `id` = '{$id}' AND `id` = `link` AND `online` = 1 LIMIT 1");
        if ($d->num_rows() > 0)
		{
            $data = $d->row_array();
			
			$data = array_merge($data, array('images' => $this->get_child_images($data['id'])));
			
			return $data;
        }
        
		return false;
	}
    
}
?>
