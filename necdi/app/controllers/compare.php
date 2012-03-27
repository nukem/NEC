<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Compare extends Controller {
	
	var $current_user = array();
	
	function Compare() {
		
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

	function products() {

		error_reporting(E_ALL);
		$products = $this->session->userdata('comparison_ids');
		$product_data = array();

		if(is_array($products) && count($products) > 0) {
			$product_ids = array_keys($products);
			$product_data = $this->data_model->get_data_set($product_ids);
		}

		foreach($product_data as $k => $p) {
			$articles = $this->data_model->get_children($p['id'], '"article"');
			foreach($articles as $art_key =>  $art_val) {
				if(stripos($art_val['title'], 'specifications') === false) {
					unset($articles[$art_key]);
				}
			}
			$specs = array_shift($articles);
			$specs_article = $this->data_model->get_article($specs['id']);
			$product_data[$k]['specs'] = array_shift($specs_article);

			$image = $this->data_model->get_child_images($p['id']);

			$product_data[$k]['image'] = array_shift($image);
		}

		$data['product_data'] = $product_data;

		$this->load->view('compare_list_view', $data);

	}


	function show_items() {

		$products = $this->session->userdata('comparison_ids');
		$count = count($products);
		if($count > 0) {
			$json['error'] = false;
			$json['message'] = '';
		} else {
			$json['error'] = true;
			$json['message'] = 'No products have been selected.';
		}
		$json['count'] = $count;
		$json['products'] = $products;

		if(isset($_POST['ajax']) && $_POST['ajax'] == true) {
			echo json_encode($json);
		} else {
			$this->products();
		}

	}

	function add_item($id) {

		$product_ids = $this->session->userdata('comparison_ids');
		$error = false;
		if(count($product_ids) >= 3) {
			$error = true;
			$message = 'Only 3 products can be compared at a time.';
		} else if(
			is_array($product_ids) 
			&& array_key_exists($id, $product_ids) === true
		) {
			$error = true;
			$message = '"' . $product_ids[$id] . '" has already been added to comparison list.';
		} else {
			$ids[] = $id;
			$product_data = array_shift(
				$this->data_model->get_data_set($ids)
			);
			$product_ids[$id] = $product_data['title'];
			$this->session->set_userdata('comparison_ids', $product_ids);
			$message = '"' . $product_data['title'] . '" added to comparison list.';
		}
		$json['error']    = $error;
		$json['message']  = $message;
		$json['result']   = 'add';
		$json['count']    = count($product_ids);
		$json['products'] = $product_ids;

		if(isset($_POST['ajax']) && $_POST['ajax'] == true) {
			echo json_encode($json);
		} else {
			$this->products();
		}

	}

	function remove_item($id) {
		$product_ids = $this->session->userdata('comparison_ids');
		$error = false;
		if(array_key_exists($id, $product_ids) === true) {
			$title = $product_ids[$id];
			unset($product_ids[$id]);
			$this->session->set_userdata('comparison_ids', $product_ids);
			$message = '"' . $title . '" removed from comparison list.';
		} else {
			$error = true;
			$message = 'Unable to remove product from comparison list.';
		}

		$json['error']    = $error;
		$json['message']  = $message;
		$json['result']   = 'remove';
		$json['count']    = count($product_ids);
		$json['products'] = $product_ids;

		if(isset($_POST['ajax']) && $_POST['ajax'] == true) {
			echo json_encode($json);
		} else {
			$this->products();
		}

	}

	/*
	function comparison_list() {
		$product_ids = $this->session->userdata('comparison_ids');

		$json['error']    = $error;
		$json['message']  = $message;
		$json['count']    = count($product_ids);
		$json['products'] = $product_ids;

		echo json_encode($json);
	}
	 */

}
