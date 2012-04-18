<?php

	require_once("fpdf_table/Table/class.fpdf_table.php");
	require_once("fpdf_table/Table/header_footer.inc");
	require_once("fpdf_table/Table/table_def.inc");
	
	$pdf = new pdf_usage();		
	$pdf->Open();
	
	$pdf->AddPage('L','a4');
	$pdf->Image('NEC-pricebook-pdf-bg.jpg',0,0);

	$pdf->SetTextColor(255,255,255);
	$pdf->SetFont('Helvetica','',18);
	$pdf->Write(0,'NEC Australia Pty Ltd');
	$pdf->ln();
	
	$pdf->SetFont('Helvetica','',48);
	$pdf->SetTextColor(255,255,255);
	$pdf->Write(24,'PRICE BOOK');
	$pdf->ln();
	
	$pdf->SetFont('Helvetica','',18);
	$pdf->SetTextColor(255,255,255);
	$pdf->Write(15,'Effective: '.$title);
	$pdf->ln();
	
	$pdf->SetFont('Helvetica','',19);
	$pdf->SetTextColor(235,235,235);
	$pdf->Write(8,'LCD Public Displays');
	$pdf->ln();
	
	$pdf->SetFont('Helvetica','',19);
	$pdf->SetTextColor(235,235,235);
	$pdf->Write(8,' ');
	$pdf->ln();
	
	$pdf->SetFont('Helvetica','',19);
	$pdf->SetTextColor(235,235,235);
	$pdf->Write(8,' ');
	$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();
	
	$pdf->SetFont('Helvetica','',18);
	$pdf->SetTextColor(235,235,235);
	$pdf->SetMargins(0,100,0);
	$pdf->Write(14,'Call 131 632 or visit ');
	
	$pdf->SetFont('Helvetica','',18);
	$pdf->SetTextColor(255,255,255);
	$pdf->Write(14,'www.nec-cds.com.au','http://www.nec-cds.com.au');
	$pdf->ln();
	
	$pdf->SetFont('Helvetica','',11);
	$pdf->SetTextColor(235,235,235);
	$pdf->Write(5,'         *Price List is private and confidential and subject to NEC Australia Standard Terms and Conditions. Prices and specifications may be subject to change');
	$pdf->ln();
	
	$pdf->SetFont('Helvetica','',11);
	$pdf->SetTextColor(235,235,235);
	$pdf->Write(5,'         without notice.E&OE.');
	
	$pdf->SetAutoPageBreak(true, 20);
	$pdf->SetMargins(20, 20, 20);
	$pdf->AddPage('L','a4');
	$pdf->AliasNbPages();
	
	$pdf->SetTextColor(0, 119, 220);

	$pdf->MultiCellTag(100, 4, "<s1>NEC Commercial Flat Panel Display Price List</s1>", 0);
	$pdf->Ln(4);
	$pdf->MultiCellTag(100, 4, "<head2>" . $title . "</head2>");
	$pdf->Ln(5);
	
	$columns = 8;
    $header_projector = array();
	$header_common = array();
        
	if($view_all)
	    $columns = $columns + 17; // print all columns
	else if($dealer_type_name == "RRP")
	    $columns = $columns + 1;
	else
	    $columns = $columns + 3;  //print one category
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);

	
	//Table Header
	for($i=0; $i<$columns; $i++){
	   $header_projector[$i] = $table_default_header_type;  
	   $header_common[$i] = $table_default_header_type;
	}
	
	for($i=0; $i<$columns; $i++){
            $header_projector[$i] = $table_default_header_type;
	    $header_common[$i] = $table_default_header_type;
	    if($view_all){
		$header_projector[$i]['WIDTH'] = 10;
		$header_common[$i]['WIDTH'] = 10;
		$header_projector[6]['WIDTH'] = 27;
		$header_projector[0]['WIDTH'] = 13;
		$header_projector[2]['WIDTH'] = 13;
		$header_projector[4]['WIDTH'] = 10;
		$header_projector[5]['WIDTH'] = 8;
	    }
	    else if($dealer_type_name == "RRP"){
		$header_projector[$i]['WIDTH'] = 20;
		$header_common[$i]['WIDTH'] = 20;
		$header_projector[6]['WIDTH'] = 100;
		
	    }
	    else{
		$header_projector[$i]['WIDTH'] = 20;
		$header_common[$i]['WIDTH'] = 20;
		$header_projector[6]['WIDTH'] = 60;
	    }
        }
	
	
        
	for($index=0; $index<8; $index++){
	  $header_projector[$index]['ROWSPAN'] = 2;
	}
    
	$header_projector[0]['TEXT'] = $fields[0]['title'];//CAT
	$header_projector[1]['TEXT'] = $fields[1]['title']; //Status
        $header_projector[2]['TEXT'] = $fields[2]['title'];//Code 
        $header_projector[3]['TEXT'] = "Link";
        $header_projector[4]['TEXT'] = $fields[17]['title'];//COLOR
        $header_projector[5]['TEXT'] = $fields[19]['title'];//SCREEN Size
        $header_projector[6]['TEXT'] = $fields[6]['title'];//product description
        $header_projector[7]['TEXT'] = $fields[7]['title'];//wty
        
        if($view_all){
            for($j = 0; $j < count($dealer_type_array); $j++){
                $header_projector[ 8 + 2 * $j ]['TEXT'] = $dealer_type_array[$j];
                $header_projector[ 8 + 2 * $j ]['COLSPAN'] = 2;
		$header_projector[ 8 + 2 * $j ]['WIDTH'] = 9;
		
		$header_common[ 8 + 2 * $j ]['TEXT'] = "exGST";
		$header_common[ 8 + 2 * $j + 1 ]['TEXT'] = "incGST";
		$header_common[ 8 + 2 * $j ]['WIDTH'] = 9;
		$header_common[ 8 + 2 * $j + 1 ]['WIDTH'] = 9;
            }
            $header_projector[24]['TEXT'] = $fields[16]['title'];//rrp
            $header_projector[24]['COLSPAN'] = 2;
	    
	    $header_common[24]['TEXT'] = "incGST";
            
        }
	else if($dealer_type_name=="RRP"){
	    $header_projector[8]['TEXT'] = $fields[16]['title'];//rrp
	    $header_common[8]['TEXT'] = "incGST";
	}
        else{
            for($i=0; $i<count($dealer_type_array); $i++){
                if($dealer_type_name == $dealer_type_array[$i]){
                    $header_projector[8]['TEXT'] = $dealer_type_array[$i];
                    $header_projector[8]['COLSPAN'] = 2;
		    
		    $header_common[8]['TEXT'] = "exGST";
                    $header_common[9]['TEXT'] = "incGST";
                }
            }
            $header_projector[10]['TEXT'] = $fields[16]['title'];//rrp
            $header_projector[10]['COLSPAN'] = 2;
	    
            $header_common[10]['TEXT'] = "incGST";
        }
	
        
        $header_array = array($header_projector,$header_common);
        
        //set the Table Header
        $pdf->tbSetHeaderType($header_array, true);
	
	//Draw the Header
	$pdf->tbDrawHeader();
                
        $data = Array();//reset the array
	$data2 = Array();
	for ($i=0; $i<$columns; $i++){
            $data[$i] = $table_default_data_type;
        }
	
	$cates = $this->pricebook_model->get_categories($this->display);
        if(is_array($cates) && count($cates) > 0){
	    for($j=0; $j<count($cates); $j++){
		$cate_id = $cates[$j]['id'];
		$products = array();
		
		// select products
		$products = $this->pricebook_model->getProducts(3,$cate_id);						   
					
		if(is_array($products) && count($products) > 0){
			
		    $p_size = count($products);
		    for($k=0; $k < $p_size; $k++){
		        
			$product_id = $products[$k]['id'];
			if($k == 0){
			      $data[0]['TEXT'] = $cates[$j]['cate_name'];
			      $data[0]['ROWSPAN'] = $p_size;
			}
			
			if($products[$k]['updated'] != '')
			      $data[1]['TEXT'] = $products[$k]['updated'];
			else
			      $data[1]['TEXT'] = '';
			      
			$data[2]['TEXT'] = $products[$k]['code'];
			
			//-------------------------------------------------------------------
			$fcws = $this->db->query("SELECT `id` FROM `wp_structure`, `wp_model`
                                        WHERE `id` = `link` AND `online` = 1 AND `title` = '{$products[$k]['code']}'
                                        ORDER BY `position` LIMIT 1");
			$productId = '';
			
			if ($fcws->num_rows() > 0) {
			    $result = $fcws->result_array();
			    $productId = $result[0]['id'];
			    /*$product_img = $this->db->query("SELECT `id`, `title` FROM `wp_structure`
								WHERE `type` = 'image' AND `online` = 1 AND `parent` = '{$result[0]['id']}'
								ORDER BY `position` LIMIT 1");
			    if ($product_img->num_rows() > 0) {
				$product_images = $product_img->result_array();
				$image = $product_images[0];
			    }
			    else{
				  $image = '';
			    }
			    $image_id = $image['id'];*/
			}
			
			//-------------------------------------------------------------------
			
			$data[2]['T_ALIGN'] = 'L';
			if($productId != ''){
			  //$data[2]['TEXT'] = "click to view";
			  $data[3]['TEXT'] = '<a href="http://www.nec-cds.com.au/products/detail/'.$productId . '">view product</a>';
			  //$data[2]['TEXT'] = "@image@".$productId;
			  //$data[2]['TEXT'] = "@image@".$image['id'];//$pdf->Image("http://www.nec-cds.com.au/wpdata/".$image['id']."-s.jpg", $pdf->GetX(), $pdf->GetY(), 20, 20, '', '');
			}
			else{
			  $data[3]['TEXT'] = '';
			}
			$data[4]['TEXT'] = $products[$k]['color'];
			$data[5]['TEXT'] = $products[$k]['scr'];
			$data[6]['TEXT'] = $products[$k]['description'];
			$data[6]['T_ALIGN'] = 'L';
			$data[7]['TEXT'] = $products[$k]['wty'];
			
			$price_list = $this->pricebook_model->getProductPriceList($cate_id,3,$product_id);
			
			if($view_all){
			    $data[8]['TEXT'] = $price_list[0]['exGST'];
			    $data[9]['TEXT'] = $price_list[0]['incGST'];
			    $data[10]['TEXT'] = $price_list[1]['exGST'];
			    $data[11]['TEXT'] = $price_list[1]['incGST'];
			    $data[12]['TEXT'] = $price_list[2]['exGST'];
			    $data[13]['TEXT'] = $price_list[2]['incGST'];
			    $data[14]['TEXT'] = $price_list[3]['exGST'];
			    $data[15]['TEXT'] = $price_list[3]['incGST'];
			    $data[16]['TEXT'] = $price_list[4]['exGST'];
			    $data[17]['TEXT'] = $price_list[4]['incGST'];
			    $data[18]['TEXT'] = $price_list[5]['exGST'];
			    $data[19]['TEXT'] = $price_list[5]['incGST'];
			    $data[20]['TEXT'] = $price_list[6]['exGST'];
			    $data[21]['TEXT'] = $price_list[6]['incGST'];
			    $data[22]['TEXT'] = $price_list[7]['exGST'];
			    $data[23]['TEXT'] = $price_list[7]['incGST'];
			    $data[24]['TEXT'] = $price_list[8]['incGST'];
			    
			    for($p_index=8; $p_index<=24; $p_index++){
			      $data[$p_index]['T_ALIGN'] = 'R';
			    }
			    
			    if($products[$k]['updated'] != ''){
			      for($x=1; $x<25; $x++){
				 $data[$x]['BG_COLOR']= array(255,250,205);
			      }
			    }
			}
			else if($dealer_type_name == $rrp){
			    $data[8]['TEXT'] = $price_list[8]['incGST'];
			    $data[8]['T_ALIGN'] = 'R';
			    
			    if($products[$k]['updated'] != ''){
			      for($x=1; $x<=8; $x++){
				 $data[$x]['BG_COLOR']= array(255,250,205);
			      }
			    }
			}
			else{
			    if($dealer_type_name == $distributor){
				    $data[8]['TEXT'] = $price_list[0]['exGST'];
				    $data[9]['TEXT'] = $price_list[0]['incGST'];
			    }
			    if($dealer_type_name == $key_partner){
				    $data[8]['TEXT'] = $price_list[1]['exGST'];
				    $data[9]['TEXT'] = $price_list[1]['incGST'];
			    }
			    if($dealer_type_name == $pro_av){
				    $data[8]['TEXT'] = $price_list[2]['exGST'];
				    $data[9]['TEXT'] = $price_list[2]['incGST'];
			    }
			    if($dealer_type_name == $govt){
				    $data[8]['TEXT'] = $price_list[3]['exGST'];
				    $data[9]['TEXT'] = $price_list[3]['incGST'];
			    }
			    if($dealer_type_name == $wholesale1){
				    $data[8]['TEXT'] = $price_list[4]['exGST'];
				    $data[9]['TEXT'] = $price_list[4]['incGST'];
			    }
			    if($dealer_type_name == $wholesale2){
				    $data[8]['TEXT'] = $price_list[5]['exGST'];
				    $data[9]['TEXT'] = $price_list[5]['incGST'];
			    }
			    if($dealer_type_name == $comm){
				    $data[8]['TEXT'] = $price_list[6]['exGST'];
				    $data[9]['TEXT'] = $price_list[6]['incGST'];
			    }
			    if($dealer_type_name == $int_vision){
				    $data[8]['TEXT'] = $price_list[7]['exGST'];
				    $data[9]['TEXT'] = $price_list[7]['incGST'];
			    }
			    
			    $data[10]['TEXT'] = $price_list[8]['incGST'];
			    
			    $data[8]['T_ALIGN'] = 'R';
			    $data[9]['T_ALIGN'] = 'R';
			    $data[10]['T_ALIGN'] = 'R';
			    
			    if($products[$k]['updated']!=''){
			      for($x=1; $x<=10; $x++){
				 $data[$x]['BG_COLOR']= array(255,250,205);
			      }
			    }
			}
			
			$pdf->tbSetDataType($data);
	
			$pdf->tbDrawData($data);
			for($y=0; $y<count($data); $y++){
		     
			   $data[$y]['BG_COLOR'] = array(255,255,255);
			
			}
			
		    } // end of for($k=0; $k<$p_size; $k++)
		    
		} //end of if(is_array($products) && count($products) > 0)
		
	      $a_size  = $this->pricebook_model->getAccessorySize(3, $cate_id);	
	      
	      if($a_size > 0){
		  
		  $accessories = $this->pricebook_model->getAccessories(3,$cate_id);
		  for($m=0; $m<$a_size; $m++){
		    
		    if($m == 0){
			$data[0]['TEXT'] = "Accessories";
			$data[0]['ROWSPAN'] = $a_size;
		    }
		    $access_id = $accessories[$m]['id'];
		    
		    if($accessories[$m]['updated']!='')
			$data[1]['TEXT'] = $accessories[$m]['updated'];
		    else
			$data[1]['TEXT'] = '';  
		  
		    $data[2]['TEXT'] = $accessories[$m]['code'];
		    $data[2]['T_ALIGN'] = 'L'; 
		    $data[2]['COLSPAN'] = 4;
		    $data[6]['TEXT'] = $accessories[$m]['description'];
		    $data[6]['T_ALIGN'] = 'L';
		    $data[7]['TEXT'] = '';
		    $a_price_list = $this->pricebook_model->getAccessPriceList($cate_id,3,$access_id);
		    
		    if($view_all){
			    $data[8]['TEXT'] = $a_price_list[0]['exGST'];
			    $data[9]['TEXT'] = $a_price_list[0]['incGST'];
			    $data[10]['TEXT'] = $a_price_list[1]['exGST'];
			    $data[11]['TEXT'] = $a_price_list[1]['incGST'];
			    $data[12]['TEXT'] = $a_price_list[2]['exGST'];
			    $data[13]['TEXT'] = $a_price_list[2]['incGST'];
			    $data[14]['TEXT'] = $a_price_list[3]['exGST'];
			    $data[15]['TEXT'] = $a_price_list[3]['incGST'];
			    $data[16]['TEXT'] = $a_price_list[4]['exGST'];
			    $data[17]['TEXT'] = $a_price_list[4]['incGST'];
			    $data[18]['TEXT'] = $a_price_list[5]['exGST'];
			    $data[19]['TEXT'] = $a_price_list[5]['incGST'];
			    $data[20]['TEXT'] = $a_price_list[6]['exGST'];
			    $data[21]['TEXT'] = $a_price_list[6]['incGST'];
			    $data[22]['TEXT'] = $a_price_list[7]['exGST'];
			    $data[23]['TEXT'] = $a_price_list[7]['incGST'];
			    $data[24]['TEXT'] = $a_price_list[8]['incGST'];
			    
			    for($a_index=8; $a_index<=24; $a_index++){
			      $data[$a_index]['T_ALIGN'] = 'R';
			    }
			    
			    if($accessories[$m]['updated']!=''){
			      for($x=1; $x<=24; $x++){
				 $data[$x]['BG_COLOR']= array(255,250,205);
			      }
			    }
			    
			}
			else if($dealer_type_name == $rrp){
			    $data[8]['TEXT'] = $a_price_list[8]['incGST'];
			    $data[8]['T_ALIGN'] = 'R';
			    
			    if($accessories[$m]['updated']!=''){
			      for($x=1; $x<=8; $x++){
				 $data[$x]['BG_COLOR']= array(255,250,205);
			      }
			    }
			}
			else{
			    if($dealer_type_name == $distributor){
				    $data[8]['TEXT'] = $a_price_list[0]['exGST'];
				    $data[9]['TEXT'] = $a_price_list[0]['incGST'];
			    }
			    if($dealer_type_name == $key_partner){
				    $data[8]['TEXT'] = $a_price_list[1]['exGST'];
				    $data[9]['TEXT'] = $a_price_list[1]['incGST'];
			    }
			    if($dealer_type_name == $pro_av){
				    $data[8]['TEXT'] = $a_price_list[2]['exGST'];
				    $data[9]['TEXT'] = $a_price_list[2]['incGST'];
			    }
			    if($dealer_type_name == $govt){
				    $data[8]['TEXT'] = $a_price_list[3]['exGST'];
				    $data[9]['TEXT'] = $a_price_list[3]['incGST'];
			    }
			    if($dealer_type_name == $wholesale1){
				    $data[8]['TEXT'] = $a_price_list[4]['exGST'];
				    $data[9]['TEXT'] = $a_price_list[4]['incGST'];
			    }
			    if($dealer_type_name == $wholesale2){
				    $data[8]['TEXT'] = $a_price_list[5]['exGST'];
				    $data[9]['TEXT'] = $a_price_list[5]['incGST'];
			    }
			    if($dealer_type_name == $comm){
				    $data[8]['TEXT'] = $a_price_list[6]['exGST'];
				    $data[9]['TEXT'] = $a_price_list[6]['incGST'];
			    }
			    if($dealer_type_name == $int_vision){
				    $data[8]['TEXT'] = $a_price_list[7]['exGST'];
				    $data[9]['TEXT'] = $a_price_list[7]['incGST'];
			    }
			    
			    $data[10]['TEXT'] = $a_price_list[8]['incGST'];
			    
			    $data[8]['T_ALIGN'] = 'R';
			    $data[9]['T_ALIGN'] = 'R';
			    $data[10]['T_ALIGN'] = 'R';
			    
			    if($accessories[$m]['updated']!=''){
			      for($x=1; $x<=10; $x++){
				 $data[$x]['BG_COLOR']= array(255,250,205);
			      }
			    }
			}
			
		    $pdf->tbSetDataType($data);
	
		    $pdf->tbDrawData($data);
		    unset($data[2]['COLSPAN']);
		    for($y=0; $y<count($data); $y++){
		     
			$data[$y]['BG_COLOR'] = array(255,255,255);
		     
		     }
		    
		  } //end of for($m=0; $m<$a_size; $m++)
		  
	      }// end of if($a_size > 0)
		
	    } //end of for($j=0; $j<count($cates); $j++)
	  
	} //end of if(is_array($cates) && count($cates) > 0)
	
     //output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();	

	$pdf->Output();   
?>