<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Controller {
	
	var $current_user = array();
	
	function Welcome()
	{
		parent::Controller();
		$this->login_model->check_login(array_keys($this->login_model->categories));
		$this->current_user = $this->session->userdata('logged_in_user');
		$this->load->model('data_model');
		$this->load->model('news_model');
		$this->load->helper('text');
	}
	
	function index()
	{
		$data['test_view_data'] = '';
		
		$data['news_items'] = $this->news_model->get_news_articles(629, $this->current_user['category_fk']);
		
		
		$filter = '';
		if ($this->current_user['category_fk'] != 181) {
			$filter = "AND `category_fk` = {$this->current_user['category_fk']}";
		}
				
		// get all articles within permitted folders
		$query = $this->db->query("SELECT `id`, `title`, `content` 
									FROM `wp_structure`, `wp_article` 
									WHERE `id` = `link` 
									AND `online` = 1 
									AND `parent` IN (
										SELECT DISTINCT(`id`) 
										FROM `wp_structure`, `nec_permissions` 
										WHERE `online` = 1 
										AND `link` = `id` 
										AND `parent` = '82' {$filter} 
										ORDER BY `position`
									)
									ORDER BY `position`");
		
		$data['home_content'] = $query->result_array();
		
		$this->load->view('welcome_view', $data);
		
	}

	function quotes() {	

		$query = $this->db->query("SELECT *
									FROM `wp_structure`, `wp_dyk` 
									WHERE `id` = `link` 
									AND `online` = 1 
									AND `parent` = 3029
									ORDER BY `position`");
		
		$xml_quotes = $query->result_array();

		header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="iso-8859-1"?>';

		echo '<quotes>';

		foreach($xml_quotes as $q) {

			//echo '<quote><![CDATA[ ' . str_replace(array('<br>', '<br />', '<br/>', '<p>', '</p>'), array("\n", "\n", "\n", "", "\n\n"), strip_tags($q['content'], '<br><br /><br/><p></p>')) . ' ]]></quote>';
			echo '<quote><![CDATA[ ' . strip_tags($q['dyk_title']) . '<br /><br /><font size="15">' . strip_tags($q['dyk_copy']) . '</font> ]]></quote>';

		}

		echo '</quotes>';
	
	}
	
}
?>
