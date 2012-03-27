<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends Controller {

	function Contact()
	{
		parent::Controller();
		$this->login_model->check_login(array_keys($this->login_model->categories));
		$this->load->model('data_model');
		$this->load->helper('text');
	}
	
	function index()
	{
		$data['test_view_data'] = '';
		/*$query = $this->db->query("SELECT `id`, `title`, `content` FROM `wp_structure`, `wp_article` WHERE `id` = `link` AND `online` = 1 AND `parent` = '85' ORDER BY `position`");
		if ($query->num_rows() > 0) {
			$data['news_items'] = $query->result_array();
		}*/
		$query = $this->db->query("SELECT `id`, `title`, `content` FROM `wp_structure`, `wp_article` WHERE `id` = `link` AND `online` = 1 AND `id` = '94'");
		$result = $query->result_array();
		$data['content_title'] = $result[0]['title'];
		$data['content_data'] = '<div class="contact-page">' . $result[0]['content'] . '</div>';
		$this->load->view('common_view', $data);
	}
	
}
?>