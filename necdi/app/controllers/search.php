<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Controller {
	
	var $current_user = array();
	
	function Search() {
		
		parent::Controller();
		$this->current_user = $this->session->userdata('logged_in_user');
		if (!is_array($this->current_user) || count($this->current_user) < 1) {
			$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
			redirect('userlogin/');
			exit();
		} else if (!$this->acl_model->check_access(1465, $this->current_user['category_fk'])) {
			$this->session->set_flashdata('system_errors', array('RESTRICTED', 'Your access level does not provide access to this area!'));
			redirect('notallowed/');
			exit();
		}
		$this->load->model('data_model');
		$this->load->helper('text');
		
	}
	
	function index() {
		redirect('');
		exit();
	}
	
	function tech($str = '', $page_index = 0) {
		
		if ($this->input->post('tech_term')) {
			
			if (trim($this->input->post('tech_term')) == '') {
				
				$data['empty_search'] = true;
				$this->load->view('tech_search_view', $data);
				
			} else {
				redirect('search/tech/' . rawurlencode($this->input->post('tech_term')));
			}
			
		} else {
		
			$data['keyword'] = rawurldecode($str);
			$keyword = mysql_real_escape_string($data['keyword']);
			$chunks = explode(' ', $keyword);
			
			/*
			* check access for media library, the id is 88
			*/
			if (!$this->acl_model->check_access_tree(88, $this->current_user['category_fk'])) {
				$this->session->set_flashdata('system_errors', array('RESTRICTED', 'Your access level does not provide access to this area!'));
				redirect('notallowed/');
				exit();
			}
			
			$sql_select = $sql_where = '';
			foreach ($chunks as $chunk) {
				$sql_select .= "(CASE WHEN `model_number` LIKE '%{$chunk}%' THEN 1 ELSE 0 END) + (CASE WHEN `title` LIKE '%{$chunk}%' THEN 1 ELSE 0 END) + (CASE WHEN `content` LIKE '%{$chunk}%' THEN 1 ELSE 0 END) + ";
				$sql_where .= "( `model_number` LIKE '%{$chunk}%' OR `title` LIKE '%{$chunk}%' OR `content` LIKE '%{$chunk}%' ) AND ";
			}
			
			$sql_select = substr($sql_select, 0, -3);
			$sql_where = substr($sql_where, 0, -5);
			
			$rcq = $this->db->query("SELECT `id`, `title`, `model_number`, `content`, ( {$sql_select} ) AS `score`
										FROM `wp_model`, `wp_structure`
										WHERE 
										{$sql_where}
										AND `id` = `link`
										AND `online` = 1
										ORDER BY `score`");
				
			$row_count = $rcq->result_array();
			$row_count = count($row_count);
			
			$data['pagination'] = '';
			
			//print_r($row_count);
			
			if ($row_count > 0) {
				
				$this->load->library('pagination');
				$config['base_url'] = $this->config->item('base_url') . 'search/tech/' . $str;
				$config['total_rows'] = $row_count;
				$config['per_page'] = 6;
				$config['uri_segment'] = 4;
				$config['cur_tag_open'] = '<span class="flinks">';
				$config['cur_tag_close'] = '</span>';
				$config['first_tag_open'] = '<!-- ';
				$config['first_tag_close'] = ' -->';
				$config['last_tag_open'] = '<!-- ';
				$config['last_tag_close'] = ' -->';
				
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();
				
				$fcws = $this->db->query("SELECT `id`, `title`, `model_number`, `content`, ( {$sql_select} ) AS `score`
											FROM `wp_model`, `wp_structure`
											WHERE 
											{$sql_where}
											AND `id` = `link`
											AND `online` = 1
											ORDER BY `score`
											LIMIT {$page_index}, 6");
											
				//$data['the_last_query'] = $this->db->last_query();
				
				
				$results = array();
				
				$results['models'] = false;
				if ($fcws->num_rows() > 0) {
					
					$i = 0;
					foreach ($fcws->result_array() as $fc) {
						$images = $this->db->query("SELECT * FROM `wp_structure`
													WHERE `type` = 'image' AND `online` = 1 AND `parent` = '{$fc['id']}'
													ORDER BY `position` LIMIT 1");
						$results['models'][$i]['data'] = $fc;
						$results['models'][$i]['image'] = false;
						if ($images->num_rows() > 0) {
							$image = $images->result_array();
							$results['models'][$i]['image'] = $image[0];
						}
						$i++;
					}
					
				}
				
				$data['models'] = false;
				if (is_array($results['models'])) $data['models'] = $results['models'];
				
				$this->load->view('tech_search_view', $data);
				
				
			} else {
				
				// no results
				$data['no_results'] = true;
				$this->load->view('tech_search_view', $data);
				
			}
			
		}
		
	}
	
	function media($str = '', $page_index = 0) {
		
		if ($this->input->post('media_term')) {
			
			if (trim($this->input->post('media_term')) == '') {
				
				$data['empty_search'] = true;
				$this->load->view('media_search_view', $data);
				
			} else {
				redirect('search/media/' . rawurlencode($this->input->post('media_term')));
			}
			
		} else {
		
			$data['keyword'] = rawurldecode($str);
			$keyword = mysql_real_escape_string($data['keyword']);
			
			/*
			* check access for media library, the id is 88
			*/
			if (!$this->acl_model->check_access_tree(88, $this->current_user['category_fk'])) {
				$this->session->set_flashdata('system_errors', array('RESTRICTED', 'Your access level does not provide access to this area!'));
				redirect('notallowed/');
				exit();
			}
			
			/*
			$sub_items = $this->db->query("SELECT COUNT(DISTINCT `parent`) AS `id` 
												FROM `wp_structure`
												WHERE `type` = 'hi_res' AND `online` = 1
												AND `title` LIKE '%{$keyword}%'
												ORDER BY `position`"); */
			
			$rcq = $this->db->query("SELECT count(*) AS `total_rows` FROM `wp_structure`
											WHERE `online` = 1 
											AND 
											(
												(
												`title` LIKE '%{$keyword}%'
												AND 
												`parent` IN (SELECT `id`
																	FROM `wp_structure`
																	WHERE `online` = 1
																	AND `parent` = 88)
												)
											OR 
												`id` IN (SELECT DISTINCT `parent` 
															FROM `wp_structure`
															WHERE `type` = 'hi_res' AND `online` = 1
															AND `title` LIKE '%{$keyword}%')
											)
											ORDER BY `position`");
											
			
				
			$row_count = $rcq->result_array();
			$row_count = $row_count[0]['total_rows'];
			
			$data['pagination'] = '';
			
			//print_r($row_count);
			
			if ($row_count > 0) {
				
				$this->load->library('pagination');
				$config['base_url'] = $this->config->item('base_url') . 'search/media/' . $str;
				$config['total_rows'] = $row_count;
				$config['per_page'] = 6;
				$config['uri_segment'] = 4;
				$config['cur_tag_open'] = '<span class="flinks">';
				$config['cur_tag_close'] = '</span>';
				$config['first_tag_open'] = '<!-- ';
				$config['first_tag_close'] = ' -->';
				$config['last_tag_open'] = '<!-- ';
				$config['last_tag_close'] = ' -->';
				
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();
				
				$fcws = $this->db->query("SELECT * FROM `wp_structure`
											WHERE `online` = 1 
											AND 
											(
												(
												`title` LIKE '%{$keyword}%'
												AND 
												`parent` IN (SELECT `id`
																	FROM `wp_structure`
																	WHERE `online` = 1
																	AND `parent` = 88)
												)
											OR 
												`id` IN (SELECT DISTINCT `parent` 
															FROM `wp_structure`
															WHERE `type` = 'hi_res' AND `online` = 1
															AND `title` LIKE '%{$keyword}%')
											)
											ORDER BY `position` LIMIT {$page_index}, 6");
				
				
				$results = array();
				
				$results['models'] = false;
				if ($fcws->num_rows() > 0) {
					
					$i = 0;
					foreach ($fcws->result_array() as $fc) {
						$images = $this->db->query("SELECT * FROM `wp_structure`, `wp_hi_res`
													WHERE `link` = `id` AND `online` = 1 AND `parent` = '{$fc['id']}'
													ORDER BY `position`");
						if ($images->num_rows() > 0) {
							$results['models'][$i]['images'] = $images->result_array();
							$results['models'][$i]['data'] = $fc;
						}
						$i++;
					}
					
				}
				
				$data['models'] = false;
				if (is_array($results['models'])) $data['models'] = $results['models'];
				
				$this->load->view('media_search_view', $data);
				
				
			} else {
				
				// no results
				$data['no_results'] = true;
				$this->load->view('media_search_view', $data);
				
			}
			
		}
		
	}

}

?>