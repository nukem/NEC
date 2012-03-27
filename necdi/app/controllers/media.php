<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Media extends Controller {
	
	var $current_user = array();
	
	function Media() {
		
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
		
		$data['common'] = false;
		
		$type = false;
		
		# get the listed articles under a folder - that is not a press release
		if ($product['type'] == 'folder' && $product['parent'] != 89) {
			
			$type = 'article';
		
		# get the press releases	
		} else if ($product['type'] == 'folder' && $product['parent'] == 89) {
		
			$type = 'press';
		
		# we have a press release to display
		} else if ($product['type'] == 'press') {
			
			$pr = $this->db->query("SELECT * 
									FROM `wp_structure`, `wp_press`
									WHERE `link` = `id` AND `online` = 1 AND `id` = {$id}");
									
			if ($pr->num_rows() > 0) {
				
				$prdata = $pr->result_array();
				$data['pr'] = $prdata[0];
				
				$files = $this->db->query("SELECT * 
											FROM `wp_structure`, `wp_file`
											WHERE `link` = `id` AND `online` = 1 AND `parent` = {$data['pr']['id']}");
											
				if ($files->num_rows() > 0) {
					
					$data['pr']['file_data'] = $files->result_array();
					
				}
				
				$this->load->view('press_detail_view', $data);
			}
			
		}
		
		# if we are not displaying a press release
		if ($type) {
		
			$rcq = $this->db->query("SELECT count(*) AS `total_rows` FROM `wp_structure`, `wp_{$type}`
											WHERE `id` = `link` AND `online` = 1 AND `parent` = '{$id}'
											ORDER BY `position`");
				
			$row_count = $rcq->result_array();
			$row_count = $row_count[0];
			
			$data['pagination'] = '';
			
			//print_r($row_count);
			
			if ($row_count['total_rows'] > 0) {
				
				$this->load->library('pagination');
				$config['base_url'] = $this->config->item('base_url') . 'media/detail/' . $id;
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
				
				//no data
				
			}
			
			$order_by = ($type == 'article') ? '`position`' : '`press_date` DESC';
			
			$results = array();
			// articles under this id
			$fcws = $this->db->query("SELECT * FROM `wp_structure`, `wp_{$type}`
										WHERE `id` = `link` AND `online` = 1 AND `parent` = '{$id}'
										ORDER BY {$order_by} LIMIT {$page_index}, 6");
			
			# generate the list view of hi-res images					
			if ($type == 'article') {
			
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
				
				$data['current'] = $product;
				
				$data['models'] = false;
				if (is_array($results['models'])) $data['models'] = $results['models'];
				
				$this->load->view('media_list_view', $data);
			
			# list the press releases	
			} else if ($type == 'press') {
			
				$this->load->helper('text');
				$data['current'] = $product;
				
				$data['press'] = false;
				if ($fcws->num_rows() > 0) $data['press'] = $fcws->result_array();
				
				$this->load->view('press_list_view', $data);
				
			}
		
		} // end if ($type)
        
    }
	
	
    
}