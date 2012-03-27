<?php

class Video extends Controller {

	function __construct() {
		parent::controller();
		$this->login_model->check_login(array_keys($this->login_model->categories));
		$this->current_user = $this->session->userdata('logged_in_user');
		$this->load->model('data_model');
		$this->load->model('news_model');
		$this->load->helper('text');
		
	}

	function index($video_id = null) {

		/*
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
		 */
		

		// Select the first video

		if(!isset($video_id) || $video_id == null) {
			$sql = 'SELECT id, title, content, created FROM wp_structure, wp_article WHERE id = link AND online = 1 AND parent = 3258 ORDER BY position LIMIT 1';
		} else {
			$video_id = mysql_real_escape_string($video_id);
			$sql = 'SELECT id, title, content, created FROM wp_structure, wp_article WHERE id = link AND online = 1 AND id = ' . $video_id;
		}

		$query = $this->db->query($sql);
		$data['video']['article'] = $query->row_array();

		$video_parent = $data['video']['article']['id'];

		$sql = 'SELECT id, title, extension  FROM wp_structure, wp_file WHERE id = link AND online = 1 AND parent = ' . $video_parent;
		$query = $this->db->query($sql);
		$data['video']['file'] = $query->row_array();
		

		$sql = 'SELECT title, id, created FROM wp_structure, wp_article WHERE id = link AND online = 1 AND parent = 3258';
		$query = $this->db->query($sql);
		$data['thumbs'] = $query->result_array();

		$count = count($data['thumbs']);
		for($i = 0; $i < $count; $i++) {
			$sql = 'SELECT id, title FROM wp_structure, wp_image WHERE id = link AND online = 1 AND parent = ' . $data['thumbs'][$i]['id'];
			$query = $this->db->query($sql);

			$data['thumbs'][$i]['image'] = $query->row_array();
		}

		$this->load->view('video_view', $data);

	}

}
