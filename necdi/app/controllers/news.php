<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class News extends Controller {
	
	var $current_user = array();
	
	function News() {
	
		parent::Controller();
		$this->current_user = $this->session->userdata('logged_in_user');
		
		if (!is_array($this->current_user) || count($this->current_user) < 1) {
			$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
			redirect('userlogin/');
			exit();
		}
		
		$this->load->model('news_model');
		$this->load->model('data_model');
		
	}
	
	/**
	* loads all the available news items
	* for the category
	*/
	function index() {
		
		$this->load->helper('text');
		
		$data['news_items'] = $this->news_model->get_news_articles(629, $this->current_user['category_fk']);
		
		$this->load->view('news_view', $data);
		
	}
	
	/*
	* Load the individual news item per id
	*/
	function item($id) {
		
		$data['single_item'] = true;
		$news_item = $this->news_model->get_article_details($id);
		
		if (!count($news_item)) {
			$data['news_item'] = array('title' => 'Invalid news ID presented', 'content' => '');
		} else {
			$data['news_item'] = $news_item;
		}
		
		$this->load->view('news_view', $data);
		
	}
	
}
?>