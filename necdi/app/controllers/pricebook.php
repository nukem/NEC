<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pricebook extends Controller{
    
    private $projector = "Projector";
	private $whiteboard = "LCD Desktop Monitors";
	//private $display = "Commercial Flat Panel Display";
	private $display = "LCD Public Displays";
	private $lpd = "Ls";
	private $lcd = "LCD & Plasma Television";
	private $whitegoods = "Whitegoods";
    
    private $current_user = array();
    
    function Pricebook(){
        
        parent:: Controller();
		$this->load->helper('file');
        $this->current_user = $this->session->userdata('logged_in_user');
        $this->load->model('data_model');
        $this->load->model('pricebook_model');
        
    }
    
    function index(){
        if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
		}
        $data['news_items'] = $this->pricebook_model->getPriceBookMainArticle();
		$this->load->view('pricebook_cover',$data);
		//$this->load->view('service_unavailable');
    }
	
    function new_index(){
        if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
	}
		$this->load->model('news_model');
		$this->load->view('new_pricebook_cover');
		//$this->load->view('service_unavailable');
    }
    
    function update(){
	$this->load->view('pricebook_cover');
    }
    
    function instruction(){
    
	if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
	}
		
	$this->load->view('instruction_view.php');  
	
    }
    
    function displayPricebook(){
      
	if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
	}
	    
	    	    
	$pb_fk = $this->current_user['pricebook_fk'];
	$user_fk = $this->current_user['category_fk'];
	$pb_cate = $this->pricebook_model->get_dealer_cate($pb_fk);
	$data['dealer_type_name'] = $pb_cate[0]['dealer_type'];
	$data['user_fk'] = $user_fk;
	$data['dealer_type'] = $pb_fk;
	
	$query = $this->pricebook_model->get_pb_title();
	$title = $query[0]['title'];
	
	$this->load->view('whole_pricebook_view',$data);
    }
    
    function getpdf(){
	    
	if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
	}
	  
	$pb_fk = $this->current_user['pricebook_fk'];
	$user_fk = $this->current_user['category_fk'];
	$pb_cate = $this->pricebook_model->get_dealer_cate($pb_fk);
	$dealer_type_name = $pb_cate[0]['dealer_type'];
		
	$query = $this->pricebook_model->get_pb_title();
	$title = $query[0]['title'];
	
	$distributor = "DISTRIBUTOR";
	$key_partner = "KEY PARTNER";
	$pro_av = "PRO AV";
	$govt = "GOVT";
	$wholesale1 = "WHOLESALE1";
	$wholesale2 = "WHOLESALE2";
	$comm = "EDUCATION";
	$int_vision = "DEALER";
	$rrp = "RRP";
	
	$dealer_type_array = array("DISTRIBUTOR", "KEY PARTNER", "PRO AV", "GOVT", "WHOLESALE1", "WHOLESALE2", "EDUCATION", "DEALER");
	$view_all = ($user_fk == 181 || $user_fk == 1620);
	include('projector.inc');     
	
    }
    
    function getpdf2(){
	
	if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
	}
	  
	$pb_fk = $this->current_user['pricebook_fk'];
	$user_fk = $this->current_user['category_fk'];
	$pb_cate = $this->pricebook_model->get_dealer_cate($pb_fk);
	$dealer_type_name = $pb_cate[0]['dealer_type'];
		
	$query = $this->pricebook_model->get_pb_title();
	$title = $query[0]['title'];
	
	$distributor = "DISTRIBUTOR";
	$key_partner = "KEY PARTNER";
	$pro_av = "PRO AV";
	$govt = "GOVT";
	$wholesale1 = "WHOLESALE1";
	$wholesale2 = "WHOLESALE2";
	$comm = "EDUCATION";
	$int_vision = "DEALER";
	$rrp = "RRP";
	
	$dealer_type_array = array("DISTRIBUTOR", "KEY PARTNER", "PRO AV", "GOVT", "WHOLESALE1", "WHOLESALE2", "EDUCATION", "DEALER");
	$view_all = ($user_fk == 181 || $user_fk == 1620);
	include('whiteboard.inc');   
    }
    
    function getpdf3(){
      
	if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
	}
	  
	$pb_fk = $this->current_user['pricebook_fk'];
	$user_fk = $this->current_user['category_fk'];
	$pb_cate = $this->pricebook_model->get_dealer_cate($pb_fk);
	$dealer_type_name = $pb_cate[0]['dealer_type'];
		
	$query = $this->pricebook_model->get_pb_title();
	$title = $query[0]['title'];
	
	$distributor = "DISTRIBUTOR";
	$key_partner = "KEY PARTNER";
	$pro_av = "PRO AV";
	$govt = "GOVT";
	$wholesale1 = "WHOLESALE1";
	$wholesale2 = "WHOLESALE2";
	$comm = "EDUCATION";
	$int_vision = "DEALER";
	$rrp = "RRP";
	
	$dealer_type_array = array("DISTRIBUTOR", "KEY PARTNER", "PRO AV", "GOVT", "WHOLESALE1", "WHOLESALE2", "EDUCATION", "DEALER");
	$view_all = ($user_fk == 181 || $user_fk == 1620);
	include('display.inc');   
      
    }
    
    function getPricebook($id = ''){
	
	if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
	}
	
	$pb_fk = $this->current_user['pricebook_fk'];
	$user_fk = $this->current_user['category_fk'];
	$pb_cate = $this->pricebook_model->get_dealer_cate($pb_fk);
	//$type = $this->pricebook_model->getTypeName($type_id);
	$data['dealer_type_name'] = $pb_cate[0]['dealer_type'];
	$data['user_fk'] = $user_fk;
	$data['dealer_type'] = $pb_fk;
	
	$dealer_type_name = $data['dealer_type_name']; 
	$user_fk = $data['user_fk']; 
	$dealer_type = $data['dealer_type'];
		
	$distributor = "DISTRIBUTOR";
	$key_partner = "KEY PARTNER";
	$pro_av = "PRO AV";
	$govt = "GOVT";
	$wholesale1 = "WHOLESALE1";
	$wholesale2 = "WHOLESALE2";
	$comm = "EDUCATION";
	$int_vision = "DEALER";
	$rrp = "RRP";
	
	$query = $this->pricebook_model->get_pb_title();
	$title = $query[0]['title'];
	$filename = str_replace(" " , "_" , "NEC_complete_pricebook.csv");
	
	/*
	 ***************************************************************************************************************************************************
	 */
	$view_all = ($user_fk == 181 || $user_fk == 1620);
		
		$csv = "NEC ".$title." price book\n\n";
		
		
		$query2 = $this->pricebook_model->get_product_types();
		
		$type_size = count($query2);
				
		for($i=0; $i<$type_size; $i++){
		    
		    $type_id = $query2[$i]['id'];
		    $type = $query2[$i]['type_name'];
			
			// select categories based on type of product
							
		    $cates = $this->pricebook_model->get_categories($type);
			
			//end of select categories
			
		    if(is_array($cates) && count($cates) > 0){
			
			
		
			$csv .= "\n\nNEC ".$type." Price List\n\n";
			
			
			$csv .= "CAT.";
			$csv .= ",Status"; //check update
			$csv .= ",Code,";
			
			if($type == $this->projector || $type == $this->whiteboard){
		
			$csv .= "RES,";
			$csv .= "Chip set,";
		
			}
			else if($type == $this->display || $type == $this->lpd){
		
			$csv .= "Color,";
			$csv .= "SCR Size,";
		
			}
			else if ($type == $this->lcd){
		
			$csv .= "Notes,";
			$csv .= "SCR Size,";
		
			}
			else if ($type == $this->whitegoods){
			$csv .= ",,";
			}
		
			$csv .= "Product Description,";
			$csv .= "WTY,";
		
			if($dealer_type_name == $distributor || $view_all){
		
			$csv .= "DISTRIBUTOR,,";
		
			}
			if($dealer_type_name == $key_partner || $view_all){
		
			$csv .= "KEY PARTNER,,";
		
			}
			if($dealer_type_name == $pro_av || $view_all){
		
			$csv .= "PRO AV,,";
		
			}
			if($dealer_type_name == $govt || $view_all){
		
			$csv .= "GOVT,,";
		
			}
			if($dealer_type_name == $wholesale1 || $view_all){
		
			$csv .= "WHOLESALE 1,,";
		
			}
			if($dealer_type_name == $wholesale2 || $view_all){
		
			$csv .= "WHOLESALE 2,,";
		
			}
			if($dealer_type_name == $comm || $view_all){
		
			$csv .= "EDUCATION,,";
		
			}
			if($dealer_type_name == $int_vision || $view_all){
		
			$csv .= "DEALER,,";
		
			}
		
			$csv .= "RRP\n";
			$csv .= ",,,,,,,"; // added one ','   
		
			if($view_all){
			    for($a=0; $a<8; $a++){
				$csv .= "ex GST,";
				$csv .= "inc GST,";
			    }
			}
			else if($dealer_type_name != $rrp){
			    $csv .= "ex GST,";
			    $csv .= "inc GST,";
			}
							
		
			    $csv .= "incGST\n";
								
			//$type_id = $query2[$i]['id'];
			
			// select categories based on type of product
							
			//$cates = $this->pricebook_model->get_categories($type);
			
			//end of select categories
			
			//if(count($cates) > 0){
				
				for($j=0; $j<count($cates); $j++){
					
				    $cate_id = $cates[$j]['id'];
				    $products = array();
				    
				    // select products
				    $products = $this->pricebook_model->getProducts($type_id,$cate_id);						   
							    
				    if(is_array($products) && count($products) > 0){
					    
					    $p_size = count($products);
							    
					    //$csv .= $cates[$j]['cate_name'].",";
							    
					for($k=0; $k<$p_size; $k++){
																    
					    $product_id = $products[$k]['id'];
						    
	    
					    if($k == 0){
						    $csv .= $cates[$j]['cate_name'];
					    }
					    /*else{
						    $csv .= ",";
					    }*/
					    if($products[$k]['updated']!='')
						$csv .= ",".$products[$k]['updated'];
					    else
						$csv .= ",";
					    $csv .= ",".$products[$k]['code'].",";						      
	    
					    if($type == $this->projector || $type == $this->whiteboard){		    
						    $csv .= $products[$k]['res'].",";
						    $csv .= $products[$k]['chipset'].",";		    
					    }
					    else if ($type == $this->display || $type == $this->lpd){		    
						    $csv .= $products[$k]['color'].",";
						    $csv .= $products[$k]['scr'].",";		    
					    }
					    else if ($type == $this->lcd){		    
						    $csv .= $products[$k]['notes'].",";
						    $csv .= $products[$k]['scr'].",";		    
					    }
					    else if ($type == $this->whitegoods){
						    $csv .= ",,";
					    }
						    $csv .= "\"".str_ireplace("\"","''",$products[$k]['description'])."\",";
						    $csv .= $products[$k]['wty'].",";
							    
					    $price_list = $this->pricebook_model->getProductPriceList($cate_id,$type_id,$product_id);
						    
					    if($dealer_type_name == $distributor || $view_all){
						    $csv .= "\"".$price_list[0]['exGST']."\",";
						    $csv .= "\"".$price_list[0]['incGST']."\",";
					    }
					    if($dealer_type_name == $key_partner || $view_all){
						    $csv .= "\"".$price_list[1]['exGST']."\",";
						    $csv .= "\"".$price_list[1]['incGST']."\",";
					    }
					    if($dealer_type_name == $pro_av || $view_all){
						    $csv .= "\"".$price_list[2]['exGST']."\",";
						    $csv .= "\"".$price_list[2]['incGST']."\",";
					    }
					    if($dealer_type_name == $govt || $view_all){
						    $csv .= "\"".$price_list[3]['exGST']."\",";
						    $csv .= "\"".$price_list[3]['incGST']."\",";
					    }
					    if($dealer_type_name == $wholesale1 || $view_all){
						    $csv .= "\"".$price_list[4]['exGST']."\",";
						    $csv .= "\"".$price_list[4]['incGST']."\",";
					    }
					    if($dealer_type_name == $wholesale2 || $view_all){
						    $csv .= "\"".$price_list[5]['exGST']."\",";
						    $csv .= "\"".$price_list[5]['incGST']."\",";
					    }
					    if($dealer_type_name == $comm || $view_all){
						    $csv .= "\"".$price_list[6]['exGST']."\",";
						    $csv .= "\"".$price_list[6]['incGST']."\",";
					    }
					    if($dealer_type_name == $int_vision || $view_all){
						    $csv .= "\"".$price_list[7]['exGST']."\",";
						    $csv .= "\"".$price_list[7]['incGST']."\",";
					    }				       
						    $csv .= "\"".$price_list[8]['incGST']."\"\n";						 
	    
				    }//end of loop of products	
					
				}//end if count($products)>0
				
				// select accessories
				$query = $this->pricebook_model->getAccessorySize($type_id, $cate_id);	
								
				$a_size = $query;
				if($a_size > 0){
					
					//select accessories
					$accessories = $this->pricebook_model->getAccessories($type_id,$cate_id);				    
				      											
				    for($m=0; $m<$a_size; $m++){
						
					if($m == 0){
					    $csv .= "Accessories";
					}
											
					$access_id = $accessories[$m]['id'];		    
					
					if($accessories[$m]['updated']!='')
						$csv .= "," . $accessories[$m]['updated'];
					else
						$csv .= ",";
					if($type == $this->projector || $type == $this->whiteboard){
						$csv .= ",".$accessories[$m]['code'].",,,";
					}
					else if($type == $this->display || $type == $this->lpd){
					$csv .= ",".$accessories[$m]['code'].",";
					$csv .= $accessories[$m]['color'].",";
					$csv .= ",";
					}
					else if ($type == $this->lcd){		    
					$csv .= ",".$accessories[$m]['code'].",";
					$csv .= ",,";					      
					}
		
				$csv .= "\"".str_ireplace("\"","''",$accessories[$m]['description'])."\",,";
						
				$a_price_list = $this->pricebook_model->getAccessPriceList($cate_id,$type_id,$access_id);
				
					if($dealer_type_name == $distributor || $view_all){
					    $csv .= "\"".$a_price_list[0]['exGST']."\",";
					    $csv .= "\"".$a_price_list[0]['incGST']."\",";
					}
					if($dealer_type_name == $key_partner || $view_all){
					    $csv .= "\"".$a_price_list[1]['exGST']."\",";
					    $csv .= "\"".$a_price_list[1]['incGST']."\",";
					}
					if($dealer_type_name == $pro_av || $view_all){
					    $csv .= "\"".$a_price_list[2]['exGST']."\",";
					    $csv .= "\"".$a_price_list[2]['incGST']."\",";
					}
					if($dealer_type_name == $govt || $view_all){
					    $csv .= "\"".$a_price_list[3]['exGST']."\",";
					    $csv .= "\"".$a_price_list[3]['incGST']."\",";
					}
					if($dealer_type_name == $wholesale1 || $view_all){
					    $csv .= "\"".$a_price_list[4]['exGST']."\",";
					    $csv .= "\"".$a_price_list[4]['incGST']."\",";
					}
					if($dealer_type_name == $wholesale2 || $view_all){
					    $csv .= "\"".$a_price_list[5]['exGST']."\",";
					    $csv .= "\"".$a_price_list[5]['incGST']."\",";
					}
					if($dealer_type_name == $comm || $view_all){
					    $csv .= "\"".$a_price_list[6]['exGST']."\",";
					    $csv .= "\"".$a_price_list[6]['incGST']."\",";
					}
					if($dealer_type_name == $int_vision || $view_all){
					    $csv .= "\"".$a_price_list[7]['exGST']."\",";
					    $csv .= "\"".$a_price_list[7]['incGST']."\",";
					}				    
					    $csv .= "\"".$a_price_list[8]['incGST']."\"\n";
										    		
					}//end of loop accessories
					
				}//end if a_size >0
					
				}//end of for loop of count($cates)
				
			}// end of if(count($cates))
		
		}// end loop of product types

	    
	    $data['csv'] = $csv;
	    $this->load->helper('download');
	    
	    force_download($filename, $csv);
	/*
	 ***************************************************************************************************************************************************
	 */
	
    }
    
    
    function getTypePricebook($type_id){
	
	if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
	}
	
	$pb_fk = $this->current_user['pricebook_fk'];
	$user_fk = $this->current_user['category_fk'];
	$pb_cate = $this->pricebook_model->get_dealer_cate($pb_fk);
	$type = $this->pricebook_model->getTypeName($type_id);
	$data['dealer_type_name'] = $pb_cate[0]['dealer_type'];
	$data['user_fk'] = $user_fk;
	$data['dealer_type'] = $pb_fk;
	
	$dealer_type_name = $data['dealer_type_name']; 
	$user_fk = $data['user_fk']; 
	$dealer_type = $data['dealer_type'];
		
	$distributor = "DISTRIBUTOR";
	$key_partner = "KEY PARTNER";
	$pro_av = "PRO AV";
	$govt = "GOVT";
	$wholesale1 = "WHOLESALE1";
	$wholesale2 = "WHOLESALE2";
	$comm = "EDUCATION";
	$int_vision = "DEALER";
	$rrp = "RRP";
	
	$query = $this->pricebook_model->get_pb_title();
	$title = $query[0]['title'];
	$filename = str_replace(" " , "_" , "NEC_".$type."_pricebook.csv");
	
	$csv = "";
	
	/*
	 ***************************************************************************************************************************************************
	 */
	$view_all = ($user_fk == 181 || $user_fk == 1620);
		
		//$csv = "NEC ".$type." price book\n\n";
		
		
		//$query2 = $this->pricebook_model->get_product_types();
		
		//$type_size = count($query2); $csv .= $type_size;
				
		//for($i=0; $i<$type_size; $i++){
		    
		    //$type_id = $query2[$i]['id'];
		    //$type = $query2[$i]['type_name'];
			
			// select categories based on type of product
							
		    $cates = $this->pricebook_model->get_categories($type);
			
			//end of select categories
			
		    if(is_array($cates) && count($cates) > 0){
			
			
		
			$csv .= "\n\nNEC ".$type." Price List\n\n";
			
			
			$csv .= "CAT.";
			$csv .= ",Status";
			$csv .= ",Code,";
			
			if($type == $this->projector || $type == $this->whiteboard){
		
			$csv .= "RES,";
			$csv .= "Chip set,";
		
			}
			else if($type == $this->display || $type == $this->lpd){
		
			$csv .= "Color,";
			$csv .= "SCR Size,";
		
			}
			else if ($type == $this->lcd){
		
			$csv .= "Notes,";
			$csv .= "SCR Size,";
		
			}
			else if ($type == $this->whitegoods){
			$csv .= ",,";
			}
		
			$csv .= "Product Description,";
			$csv .= "WTY,";
		
			if($dealer_type_name == $distributor || $view_all){
		
			$csv .= "DISTRIBUTOR,,";
		
			}
			if($dealer_type_name == $key_partner || $view_all){
		
			$csv .= "KEY PARTNER,,";
		
			}
			if($dealer_type_name == $pro_av || $view_all){
		
			$csv .= "PRO AV,,";
		
			}
			if($dealer_type_name == $govt || $view_all){
		
			$csv .= "GOVT,,";
		
			}
			if($dealer_type_name == $wholesale1 || $view_all){
		
			$csv .= "WHOLESALE 1,,";
		
			}
			if($dealer_type_name == $wholesale2 || $view_all){
		
			$csv .= "WHOLESALE 2,,";
		
			}
			if($dealer_type_name == $comm || $view_all){
		
			$csv .= "EDUCATION,,";
		
			}
			if($dealer_type_name == $int_vision || $view_all){
		
			$csv .= "DEALER,,";
		
			}
		
			$csv .= "RRP\n";
			$csv .= ",,,,,,,";   
		
			if($view_all){
			    for($a=0; $a<8; $a++){
				$csv .= "ex GST,";
				$csv .= "inc GST,";
			    }
			}
			else if($dealer_type_name != $rrp){
			    $csv .= "ex GST,";
			    $csv .= "inc GST,";
			}
							
		
			    $csv .= "incGST\n";
								
			//$type_id = $query2[$i]['id'];
			
			// select categories based on type of product
							
			//$cates = $this->pricebook_model->get_categories($type);
			
			//end of select categories
			
			//if(count($cates) > 0){
				
				for($j=0; $j<count($cates); $j++){
					
				    $cate_id = $cates[$j]['id'];
				    $products = array();
				    
				    // select products
				    $products = $this->pricebook_model->getProducts($type_id,$cate_id);						   
							    
				    if(is_array($products) && count($products) > 0){
					    
					    $p_size = count($products);
							    
					    //$csv .= $cates[$j]['cate_name'].",";
							    
					for($k=0; $k<$p_size; $k++){
																    
					    $product_id = $products[$k]['id'];
						    
	    
					    if($k == 0){
						    $csv .= $cates[$j]['cate_name'];
					    }
					    /*else{
						    $csv .= ",";
					    }*/
					    if($products[$k]['updated'] != '')
						    $csv .= "," . $products[$k]['updated'];
					    else
						    $csv .= ",";
					    $csv .= ",".$products[$k]['code'].",";						      
	    
					    if($type == $this->projector || $type == $this->whiteboard){		    
						    $csv .= $products[$k]['res'].",";
						    $csv .= $products[$k]['chipset'].",";		    
					    }
					    else if ($type == $this->display || $type == $this->lpd){		    
						    $csv .= $products[$k]['color'].",";
						    $csv .= $products[$k]['scr'].",";		    
					    }
					    else if ($type == $this->lcd){		    
						    $csv .= $products[$k]['notes'].",";
						    $csv .= $products[$k]['scr'].",";		    
					    }
					    else if ($type == $this->whitegoods){
						    $csv .= ",,";
					    }
						    $csv .= "\"".str_ireplace("\"","''",$products[$k]['description'])."\",";
						    $csv .= $products[$k]['wty'].",";
							    
					    $price_list = $this->pricebook_model->getProductPriceList($cate_id,$type_id,$product_id);
						    
					    if($dealer_type_name == $distributor || $view_all){
						    $csv .= "\"".$price_list[0]['exGST']."\",";
						    $csv .= "\"".$price_list[0]['incGST']."\",";
					    }
					    if($dealer_type_name == $key_partner || $view_all){
						    $csv .= "\"".$price_list[1]['exGST']."\",";
						    $csv .= "\"".$price_list[1]['incGST']."\",";
					    }
					    if($dealer_type_name == $pro_av || $view_all){
						    $csv .= "\"".$price_list[2]['exGST']."\",";
						    $csv .= "\"".$price_list[2]['incGST']."\",";
					    }
					    if($dealer_type_name == $govt || $view_all){
						    $csv .= "\"".$price_list[3]['exGST']."\",";
						    $csv .= "\"".$price_list[3]['incGST']."\",";
					    }
					    if($dealer_type_name == $wholesale1 || $view_all){
						    $csv .= "\"".$price_list[4]['exGST']."\",";
						    $csv .= "\"".$price_list[4]['incGST']."\",";
					    }
					    if($dealer_type_name == $wholesale2 || $view_all){
						    $csv .= "\"".$price_list[5]['exGST']."\",";
						    $csv .= "\"".$price_list[5]['incGST']."\",";
					    }
					    if($dealer_type_name == $comm || $view_all){
						    $csv .= "\"".$price_list[6]['exGST']."\",";
						    $csv .= "\"".$price_list[6]['incGST']."\",";
					    }
					    if($dealer_type_name == $int_vision || $view_all){
						    $csv .= "\"".$price_list[7]['exGST']."\",";
						    $csv .= "\"".$price_list[7]['incGST']."\",";
					    }				       
						    $csv .= "\"".$price_list[8]['incGST']."\"\n";						 
	    
				    }//end of loop of products	
					
				}//end if count($products)>0
				
				// select accessories
				$query = $this->pricebook_model->getAccessorySize($type_id, $cate_id);	
								
				$a_size = $query;
				if($a_size > 0){
					
					//select accessories
					$accessories = $this->pricebook_model->getAccessories($type_id,$cate_id);				    
				      											
				    for($m=0; $m<$a_size; $m++){
						
					if($m == 0){
					    $csv .= "Accessories";
					}
											
					$access_id = $accessories[$m]['id'];		    
					
					if($accessories[$m]['updated'] != '')
						$csv .= "," . $accessories[$m]['updated'];
					else
						$csv .= ",";
					
					if($type == $this->projector || $type == $this->whiteboard){
						$csv .= ",".$accessories[$m]['code'].",,,";
					}
					else if($type == $this->display || $type == $this->lpd){
					$csv .= ",".$accessories[$m]['code'].",";
					$csv .= $accessories[$m]['color'].",";
					$csv .= ",";
					}
					else if ($type == $this->lcd){		    
					$csv .= ",".$accessories[$m]['code'].",";
					$csv .= ",,";					      
					}
		
				$csv .= "\"".str_ireplace("\"","''",$accessories[$m]['description'])."\",,";
						
				$a_price_list = $this->pricebook_model->getAccessPriceList($cate_id,$type_id,$access_id);
				
					if($dealer_type_name == $distributor || $view_all){
					    $csv .= "\"".$a_price_list[0]['exGST']."\",";
					    $csv .= "\"".$a_price_list[0]['incGST']."\",";
					}
					if($dealer_type_name == $key_partner || $view_all){
					    $csv .= "\"".$a_price_list[1]['exGST']."\",";
					    $csv .= "\"".$a_price_list[1]['incGST']."\",";
					}
					if($dealer_type_name == $pro_av || $view_all){
					    $csv .= "\"".$a_price_list[2]['exGST']."\",";
					    $csv .= "\"".$a_price_list[2]['incGST']."\",";
					}
					if($dealer_type_name == $govt || $view_all){
					    $csv .= "\"".$a_price_list[3]['exGST']."\",";
					    $csv .= "\"".$a_price_list[3]['incGST']."\",";
					}
					if($dealer_type_name == $wholesale1 || $view_all){
					    $csv .= "\"".$a_price_list[4]['exGST']."\",";
					    $csv .= "\"".$a_price_list[4]['incGST']."\",";
					}
					if($dealer_type_name == $wholesale2 || $view_all){
					    $csv .= "\"".$a_price_list[5]['exGST']."\",";
					    $csv .= "\"".$a_price_list[5]['incGST']."\",";
					}
					if($dealer_type_name == $comm || $view_all){
					    $csv .= "\"".$a_price_list[6]['exGST']."\",";
					    $csv .= "\"".$a_price_list[6]['incGST']."\",";
					}
					if($dealer_type_name == $int_vision || $view_all){
					    $csv .= "\"".$a_price_list[7]['exGST']."\",";
					    $csv .= "\"".$a_price_list[7]['incGST']."\",";
					}				    
					    $csv .= "\"".$a_price_list[8]['incGST']."\"\n";
										    		
					}//end of loop accessories
					
				}//end if a_size >0
					
				}//end of for loop of count($cates)
				
			}// end of if(count($cates))
		
		//}// end loop of product types

	    
	    $data['csv'] = $csv;
	    $this->load->helper('download');
	    
	    force_download($filename, $csv);
		
    }
    
    function menu(){
	    
	if (!is_array($this->current_user) || count($this->current_user) < 1) {
		$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
		redirect('userlogin/');
		exit();
	}
	
	$this->load->view('pricebook_menu');
    }
    
    
    function generateTable($var1, $var3, $pdf = FALSE){
        
        if (!is_array($this->current_user) || count($this->current_user) < 1) {
			$this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
			redirect('userlogin/');
			exit();
		}
        
		
        $type_fk = $this->uri->segment(3);
        $type_name = $this->pricebook_model->getTypeName($type_fk);
        $cate_fk = $this->uri->segment(4);
        $cate_names = $this->pricebook_model->get_categories($type_name);
        $cate_name = $cate_names[$cate_fk-1]['cate_name'];
        $access_size = $this->pricebook_model->getAccessorySize($type_fk, $cate_fk);
    
        $products = $this->pricebook_model->getProducts($type_fk,$cate_fk);
		
		#echo '<!-- ' . print_r($products, true) . ' -->';
		
        $data['p_num'] = count($products);// number of products
        $data['a_num'] = 0;//number of accessories
        $pb_fk = $this->current_user['pricebook_fk'];
        $user_fk = $this->current_user['category_fk'];
        $pb_cate = $this->pricebook_model->get_dealer_cate($pb_fk);
        $data['pricebook_cate'] = $pb_cate[0]['dealer_type'];
        $data['user_fk'] = $user_fk; //user category
		
		        
        $table = array();
        $accessory_table = array();
        $row = array();
        $access_row = array();
        $data['name'] = $type_name;
        $data['cate'] = $cate_name;
        
        /*
         *** generate product details
         */
        
        
        for($i=0; $i<count($products); $i++){
            $product_id = $products[$i]['id'];
            $row['code'] = $products[$i]['code'];
	    $row['updated'] = $products[$i]['updated'];
            
            if($type_name == trim($this->projector)||$type_name == trim($this->whiteboard)){
                $row['res'] = $products[$i]['res'];
                $row['chipset'] = $products[$i]['chipset'];
            }
            else if($type_name == trim($this->display) || $type_name == trim($this->lpd)){
                $row['color'] = $products[$i]['color'];
                $row['scr'] = $products[$i]['scr'];
            }
            else if($type_name == trim($this->lcd)){
                $row['notes'] = $products[$i]['notes'];
                $row['scr'] = $products[$i]['scr'];
            }
            $row['product_image'] = '';
            
            
            $row['description'] = $products[$i]['description'];
            $row['wty'] = $products[$i]['wty'];
            $row['id']='';
            
            //get product pictures
            
            $fcws = $this->db->query("SELECT `id` FROM `wp_structure`, `wp_model`
                                        WHERE `id` = `link` AND `online` = 1 AND `title` = '{$row['code']}'
                                        ORDER BY `position` LIMIT 1");
            
            if ($fcws->num_rows() > 0) {
                $result = $fcws->result_array();
                $product_img = $this->db->query("SELECT `id`, `title` FROM `wp_structure`
                                                    WHERE `type` = 'image' AND `online` = 1 AND `parent` = '{$result[0]['id']}'
                                                    ORDER BY `position` LIMIT 1");
                if ($product_img->num_rows() > 0) {
                    $product_images = $product_img->result_array();
                    $row['product_image'] = $product_images[0];
                }
                else{
					$row['product_image'] = 'None';
				}
                $row['id'] = $result[0]['id'];
            }
            
            //end of getting product pictures
            
            $price_list = $this->pricebook_model->getProductPriceList($cate_fk,$type_fk,$product_id);
			
			//echo '<!-- ' . $this->db->last_query() . ' -->';
			
            for($j=0; $j<count($price_list); $j++){
                
                $key1 = $j."_ex";
                $key2 = $j."_inc";
                $row[$key1] = $price_list[$j]['exGST'];
                $row[$key2] = $price_list[$j]['incGST'];
            }
            $table[] = $row;
        }
        if($access_size>0){
            $accessories = $this->pricebook_model->getAccessories($type_fk, $cate_fk);
            $data['a_num'] = count($accessories);
            for($i=0; $i<$access_size; $i++){
                $access_id = $accessories[$i]['id'];
                $access_row['code'] = $accessories[$i]['code'];
		$access_row['updated'] = $accessories[$i]['updated'];
                if($type_name == trim($this->display)){
                    $access_row['color'] = $accessories[$i]['color'];
                }
                $access_row['description'] = $accessories[$i]['description'];
            
                $price_list = $this->pricebook_model->getAccessPriceList($cate_fk,$type_fk,$access_id);
                for($j=0; $j<count($price_list); $j++){
                    $key1 = $j."_ex";
                    $key2 = $j."_inc";
                    $access_row[$key1] = $price_list[$j]['exGST'];
                    $access_row[$key2] = $price_list[$j]['incGST']; 
                }
                
                $accessory_table[] = $access_row;
            }
        }
     
        $data['table'] = $table;
		$data['access_table'] = $accessory_table;
				
	$filename = "NEC_pricebook-".$type_name."_".$cate_name.".csv";
	$filename = str_ireplace( " " , "_" , $filename );
	if ($pdf == FALSE)
	{
		$this->load->view('pricebook_view',$data);
	}
	else
	{
		//$this->load->library('parser');
		$this->load->helper('download');
		
		$html = $this->load->view('cate_pdf',$data, true);
		force_download($filename, $html);
	}
    
        
    }
	
    function getCategories($id){
	
	if (!is_array($this->current_user) || count($this->current_user) < 1) {
	    $this->session->set_flashdata('system_errors', array('PLEASE LOGIN', 'Your are required to be logged in to access this area!'));
	    redirect('userlogin/');
	    exit();
	}
	
	$type_id = $this->uri->segment(3);
	$data['id'] = $type_id;
	
	if($type_id == 1){
	    $data['name'] = $this->projector;  
	}
	else if($type_id == 2){
	    $data['name'] = $this->whiteboard;
	}
	else if($type_id == 3){
	    $data['name'] = $this->display;
	}
	else if($type_id == 4){
		$data['name'] = $this->lpd;
	    //$data['name'] = $this->lcd;
	}
	else if($type_id == 5){
	    $data['name'] = $this->whitegoods;
	}
	
	$this->load->view('pricebook_menu', $data);
    }
    
      
    
}



?>
