<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Controller {
	
	var $current_user = array();
	
	function Products() {
		
		parent::Controller();
		$this->current_user = $this->session->userdata('logged_in_user');
		$this->load->model('data_model');
		$this->load->helper('text');
		
	}
	
	function index() {
		if (!is_array($this->current_user) || count($this->current_user) < 1) {
			$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
			redirect('userlogin/');
			exit();
		} else {
			redirect('');
			exit();
		}
	}

	function detail($id, $page_index = 0) {
		
		if ($id == 2258)
		{
				header('Location:http://www.nec-cds.com.au/pricebook');
				exit();
		}

		if ($id == 3258)
		{
				header('Location:http://www.nec-cds.com.au/video');
				exit();
		}
		
		
		if (!is_array($this->current_user) || count($this->current_user) < 1) {
			$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
			redirect('userlogin/');
			exit();
		}
		
		if (!$this->acl_model->check_access_tree($id, $this->current_user['category_fk'])) {
			$this->session->set_flashdata('system_errors', array('RESTRICTED', 'Your access level does not provide access to this area!'));
			redirect('notallowed/');
			exit();
		}
		
		$pq = $this->db->query("SELECT * FROM `wp_structure` WHERE `id` = '{$id}'");
		if ($pq->num_rows() < 1) {
			$this->session->set_flashdata('system_errors', array('DOES NOT EXIST', 'Reqested item does not exist!'));
			redirect('notallowed/');
			exit();
		}
		
		$product = $pq->result_array();
		$product = $product[0];
		
		// init view data array
		$data = array();
		
		$data['common'] = false;
		
		// if this is a range of models
		if ($product['type'] == 'range') {
			
			$rcq = $this->db->query("SELECT count(*) AS `total_rows` FROM `wp_structure`, `wp_model`
										WHERE `id` = `link` AND `online` = 1 AND `parent` = '{$id}'
										ORDER BY `position`");
			
			$row_count = $rcq->result_array();
			$row_count = $row_count[0];
			
			$data['pagination'] = '';
			
			//print_r($row_count);
			
			if ($row_count['total_rows'] > 0) {
				
				$this->load->library('pagination');
				$config['base_url'] = $this->config->item('base_url') . 'products/detail/' . $id;
				$config['total_rows'] = $row_count['total_rows'];
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
				
			} else {
				
				/*
				* No data
				* Check if you have some content to display
				* If so we set that content to be the page content
				*/
				$jcq = $this->db->query("SELECT `content`
											FROM `wp_structure`, `wp_range`
											WHERE `link` = `id`
											AND `online` = 1
											AND `id` = {$id}");
				if ($jcq->num_rows() > 0) {
					$jcq_data = $jcq->result_array();
					if (trim($jcq_data[0]['content']) != '') {
						$data['just_content'] =  $jcq_data[0]['content'];
					}
				}
				 
				
			}
			
			$results = array();
			// models under this id
			$fcws = $this->db->query("SELECT * FROM `wp_structure`, `wp_model`
										WHERE `id` = `link` AND `online` = 1 AND `parent` = '{$id}'
										ORDER BY `position` LIMIT {$page_index}, 6");
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
			
			$data['current'] = $product;
			
			$data['models'] = false;
			if (is_array($results['models'])) $data['models'] = $results['models'];
			
			// get folders and articles
			$data['common'] = $this->get_common_range_details($id, true);
			
			$this->load->view('product_category_view', $data);
			
		} else if ($product['type'] == 'model') { // single model
			
			$results = array();
			// models under this id
			$fcws = $this->db->query("SELECT * FROM `wp_structure`, `wp_model`
										WHERE `id` = `link` AND `online` = 1 AND `id` = '{$id}'
										ORDER BY `position`");
			
			$results['model'] = false;
			
			if ($fcws->num_rows() > 0) {
				$x = $fcws->result_array();
				$results['model']['data'] = $x[0];
				
				$children = $this->db->query("SELECT `id`, `title`, `type` FROM `wp_structure`
											WHERE `online` = 1 AND `parent` = '{$x[0]['id']}'
											ORDER BY `position`");
				
				$results['model']['images'] = false;
				$results['model']['articles'] = array();
				$results['model']['downloads'] = array();
				
				$i = 0;
				if ($children->num_rows() > 0) foreach ($children->result_array() as $child) {
					
					if ($child['type'] == 'image') { // images can be added with just id
						$results['model']['images'][$i] = array('id' => $child['id'], 'title' => $child['title']);
					}
					
					if ($child['type'] == 'article') { // tab data
						//echo "SELECT * FROM `wp_structure`, `wp_article` WHERE `link` = `id` AND `id` = {$child['id']}";
						$art = $this->db->query("SELECT * FROM `wp_structure`, `wp_article` WHERE `link` = `id` AND `id` = {$child['id']}");
						$xa = $art->result_array();
						$results['model']['articles'][$i] = $xa[0];
					}
					
					if ($child['type'] == 'download') { // tab data
						$down = $this->db->query("SELECT * FROM `wp_structure`, `wp_download` WHERE `link` = `id` AND `parent` = {$child['id']}");
						$n = 0;
						if ($down->num_rows()) foreach ($down->result_array() as $dl) {
							$results['model']['downloads'][$i][$n]['id'] = $dl['id'];
							$results['model']['downloads'][$i][$n]['title'] = $dl['title'];
							$results['model']['downloads'][$i][$n]['file_name'] = $dl['file_name'];
							$results['model']['downloads'][$i][$n]['file_type'] = $dl['file_type'];
							$results['model']['downloads'][$i][$n]['extension'] = $dl['extension'];
							$n++;
						}
						
					}
					
					$i++;
				}
				
			}
			
			$data['model'] = false;
			if (is_array($results['model'])) $data['model'] = $results['model'];
			
			// get folders and articles
			$data['common'] = $this->get_common_range_details($product['parent']);
			
			$this->load->view('product_model_view', $data);
			
		} else if ($product['type'] == 'article' || $product['type'] == 'folder') {
			
			$this->show_other_detail($id, $product['type']);
			
		}
		
	}
	
	function get_common_range_details($id) {
		
		/*
		 * If this is a projector
		 * We ar gathering from the first category only
		 * All the projector categories are the same
		 */
		$i = $id;
		$path = array();
		
		while ($i != 0) {
			$db = $this->db->query("SELECT id, parent FROM wp_structure WHERE id = $i");
			$x = $db->result_array();
			$i = $x[0]['parent'];
			$path[] = $x[0]['id'];
		}
		$path = array_reverse($path);
		
		/*
		 * It is projectors
		 * So change the parent ID
		 */
		if (isset($path[1]) && $path[1] == 73) {
			$id = 1562;
		}
		
		//echo '<!-- ' . print_r($path, true) .  "\n $id \n" . ' -->';
		
		$result = array();
		
		// get folders case studies and white papers
		$fcws = $this->db->query("SELECT * FROM `wp_structure`, `wp_folder`
									WHERE `id` = `link` AND `online` = 1 AND `parent` = '{$id}'
									ORDER BY `position`");
		if ($fcws->num_rows() > 0) {
			$result['folders'] = $fcws->result_array();
		} else {
			$result['folders'] = false;
		}
		
		// get articles FAQ's and Warranty
		$fcws = $this->db->query("SELECT * FROM `wp_structure`, `wp_article`
									WHERE `id` = `link` AND `online` = 1 AND `parent` = '{$id}'
									ORDER BY `position`");
		if ($fcws->num_rows() > 0) {
			$result['articles'] = $fcws->result_array();
		} else {
			$result['articles'] = false;
		}
		
		if ($result['articles'] == false && $result['folders'] == false) {
			return false;
		} else {
			return $result;
		}
		
	}
	
	function show_other_detail($id, $type) {
		
		if  ($type == 'folder') {
			
			$data['downloads'] = false;
			$data['current']['title'] = 'Folder empty!';
			$data['current']['content'] = '<p>This folder appears to be empty.</p>';
			/*
			if ($d = $this->data_model->get_children($id, "'article'")) {
				
			}*/
			
		} else if ($type == 'article') {
			
			$data['downloads'] = false;
			$data['images'] = false;
			$data['current']['title'] = 'Article not found!';
			$data['current']['content'] = '<p>This article cannot be found</p>';
			
			if ($d = $this->data_model->get_article($id)) {
				if (count($d)) {
					$data['downloads'] = $this->data_model->get_child_files($d[0]['id']);
					$data['images'] = $this->data_model->get_child_images($d[0]['id']);
					$data['current']['title'] = $d[0]['title'];
					$data['current']['content'] = $d[0]['content'];
				}
			}
			
			$this->load->view('common_detail_view', $data);
			
		}
		
	}

}

?>
