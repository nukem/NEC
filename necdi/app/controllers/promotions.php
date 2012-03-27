<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Promotions extends Controller {
	
	var $current_user = array();
	
	function Promotions() {
		
		parent::Controller();
		
		$this->login_model->check_login();
		
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
		
		// init view data array
		$data = array();
		
		$data['common'] = false;
		
		$article = $this->db->query("SELECT `id`, `type` FROM `wp_structure` WHERE `type` = 'article' AND `online` = 1 AND `parent` = {$product['id']} ORDER BY `position` LIMIT 1");
		
		if ($article->num_rows() > 0) {
			$art = $article->result_array();
			$this->show_other_detail($art[0]['id'], 'article');
		}
		
	}
	
	
	function show_other_detail($id, $type) {
		
		if  ($type == 'folder') {
			
			$data['downloads'] = false;
			$data['images'] = false;
			$data['current']['title'] = 'Folder empty!';
			$data['current']['content'] = '<p>This folder appears to be empty.</p>';
			
			if ($d = $this->data_model->get_children($id, "'article'")) {
				
			}
			
		} else if ($type == 'article') {
			
			$data['downloads'] = false;
			$data['images'] = false;
			$data['current']['title'] = 'Article not found!';
			$data['current']['content'] = '<p>This article cannot be found</p>';
			
			if ($d = $this->data_model->get_article($id)) {
				if (count($d)) {
					$dl = $this->db->query("SELECT * FROM `wp_structure`, `wp_file` WHERE `link` = `id` AND `online` = 1 AND `parent` = '{$d[0]['id']}' ORDER BY `position`");
					if ($dl->num_rows() > 0) {
						$data['downloads'] = $dl->result_array();
					}
					$pi = $this->db->query("SELECT * FROM `wp_structure` WHERE `type` = 'image' AND `online` = 1 AND `parent` = '{$d[0]['id']}' ORDER BY `position`");
					if ($pi->num_rows() > 0) {
						$data['images'] = $pi->result_array();
					}
					$tabs = $this->db->query("SELECT * FROM `wp_structure`, `wp_article` WHERE `link` = `id` AND `online` = 1 AND `parent` = '{$d[0]['parent']}' ORDER BY `position` LIMIT 1, 10");
					if ($tabs->num_rows() > 0) {
						$data['tabs'] = $tabs->result_array();
					}
					
					//$data['downloads'] = $this->data_model->get_children(, "'file'");
					$data['current']['title'] = $d[0]['title'];
					$data['current']['content'] = $d[0]['content'];
				}
			}
			
			$this->load->view('promotion_view', $data);
			
		} else if ($type = 'file') {
			
			
			
		}
		
	}
	
	/**
	 * Prize redemptions
	 * List and Detail View
	 * @author Asanka Dewage
	 * @access public
	 * @param int $id prize id
	 */
	function prizes($parent = 3943, $id = 0, $page = 0)
	{
		$this->load->model('data_model');
		$this->load->library('pagination');
		
		$data['pagination'] = '';
		
		$data['parent_folder'] = $parent;
		
		if ($id > 0 && $data['prize'] = $this->data_model->get_single_prize($id))
		{
			# load single prize
			$this->load->view('prize_detail_view', $data);
		}
		else
		{
			$data['prizes'] = $this->data_model->get_prizes($parent, 5, $page, $this->current_user['category_fk']);
			
			$config['base_url'] = base_url() . 'promotions/prizes/' . $parent . '/0/';
			$config['total_rows'] = $this->data_model->count_prizes($parent, $this->current_user['category_fk']);
			$config['per_page'] = 5;
			$config['uri_segment'] = 5;
			$config['num_links'] = 5;
			$config['cur_tag_open'] = '<span>';
			$config['cur_tag_close'] = '</span>';
			
			$intro_text = $this->data_model->get_article(3958);
			
			if (is_array($intro_text) && count($intro_text))
			{
				$data['prize_intro'] = $intro_text[0];
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			$this->load->view('prize_list_view', $data);
		}
	}
	
	function user_data()
	{
		echo '<pre>', print_r($this->current_user, TRUE), '</pre>';
	}

}

?>
