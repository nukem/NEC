<?php

$projector = "Projector";
$whiteboard = "Interactive Whiteboard";
//$display = "Commercial Flat Panel Display";
$public = "LCD Public Displays";
$display = "LCD & Plasma Displays";
$lcd = "LCD & Plasma Television";
$whitegoods = "Whitegoods";

$distributor = "DISTRIBUTOR";
$key_partner = "KEY PARTNER";
$pro_av = "PRO AV";
$govt = "GOVT";
$wholesale1 = "WHOLESALE1";
$wholesale2 = "WHOLESALE2";
$comm = "EDUCATION";
$int_vision = "DEALER";
$rrp = "RRP";

$view_all = ($user_fk == 181 || $user_fk == 1620);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><base href="<?= $this->config->item('base_url') ?>" />
<title>NEC price list</title>
<style type="text/css" media="screen,print">
body{
	font-family: sans-serif;
}

a{
        color: #ffffff;
 }

h2{
	color: #ffffff;	
}

body{
	background: #A1B5CC;
}

table{
        border: 1px solid rgb(200, 200, 200);
        caption-side: top;
        width: 90%;
        table-layout: auto;
        border-collapse: collapse;
        color: #000000;
        font-family: sans-serif;
        font-size: 12px;
    }
 th{
        color: #ffffff;
        background-color: #205594;
        padding: 3px;
 }
 
 td{
        padding: 3px;
	/*background-color: #6287B2;*/
	color: #fff;
 }
 
 .updated-tr{
	background-color: #266fe3;
 }
 .normal-tr{
	background-color: #6287b2;	
 }
 .cate-td{
	background-color: #6287b2;
 }
    
</style>
<style type="text/css" media="print">
body {
	background:#fff;
	color: #000;
}

table{
    border: 1px solid #000;
}

th{
	background-color: #fff;
	color: #000;
}

thead {display: table-header-group;}


td{
	background-color: #fff;
	color: #000;
}

.print {
	display:none;
}
</style>
</head>
<body>
<center>
<br />
<div class="print">
	<input type="button" value="close window" onclick="window.close();" />
	<input type="button" value="print this page" onclick="window.open('/pricebook/instruction/', 'instruction', 'width=600, height=400');" />
	
	<input type="button" value="Download Excel Compatible File" onclick="document.location = '/pricebook/getPricebook/'" />
</div>

<br /><br />
<?
$query2 = $this->pricebook_model->get_product_types();

$type_size = count($query2);

for($i=0; $i<$type_size; $i++){
	
	$type = $query2[$i]['type_name'];
	
	$type_id = 	$query2[$i]['id'];
	
	$cates;
		
	$cates = $this->pricebook_model->get_categories($type);
	echo '<pre>';print_r($fields);echo '</pre>';
	if(is_array($cates) && count($cates) > 0){
?>
	<h2>NEC <?= $type?> Price List</h2>

	<table border="1">
		<thead>
		<tr>
                <th rowspan="2" align="center"><?=$fields[0]['title']; //CAT?></th>
				<th rowspan="2" align="center"><?=$fields[1]['title']; //Status?></th>
                <th rowspan="2" align="center"><?=$fields[2]['title']; //Code?></th>
                <th rowspan="2" align="center"><?=$fields[3]['title']; //Image?></th>
<?
			if($type == $projector || $type == $whiteboard){
?>
                <th rowspan="2" align="center"><?=$fields[4]['title']; //RES?></th>
                <th rowspan="2" align="center"><?=$fields[5]['title']; //Chipset?></th>
<?
			}
			else if($type == $display || $type == $public){
?>
				<th rowspan="2" align="center"><?=$fields[17]['title']; //Color?></th>
				<th rowspan="2" align="center"><?=$fields[19]['title']; //SCR Size?></th>
<?
			}
			else if ($type == $lcd){
?>
				<th rowspan="2" align="center"><?=$fields[18]['title']; //Notes?></th>
				<th rowspan="2" align="center"><?=$fields[19]['title']; //SCR Size?></th>
<?
			}
?>
                <th rowspan="2" align="center"><?=$fields[6]['title'];?></th>
                <th rowspan="2" align="center"><?=$fields[7]['title'];?></th>
<?
                if($dealer_type_name == $distributor || $view_all){
?>
                <th colspan="2" align="center"><?=$fields[8]['title'];?></th>
<?
                }
                if($dealer_type_name == $key_partner || $view_all){
?>
                <th colspan="2" align="center"><?=$fields[9]['title'];?></th>
<?
                }
                if($dealer_type_name == $pro_av || $view_all){
?>
                <th colspan="2" align="center"><?=$fields[10]['title'];?></th>
<?
                }
                if($dealer_type_name == $govt || $view_all){
?>
                <th colspan="2" align="center"><?=$fields[11]['title'];?></th>
<?
                }
                if($dealer_type_name == $wholesale1 || $view_all){
?>
                <th colspan="2" align="center"><?=$fields[12]['title'];?></th>
<?
                }
                if($dealer_type_name == $wholesale2 || $view_all){
?>
                <th colspan="2" align="center"><?=$fields[13]['title'];?></th>
<?
                }
                if($dealer_type_name == $comm || $view_all){
?>
                <th colspan="2" align="center"><?=$fields[14]['title'];?></th>
<?
                }
                if($dealer_type_name == $int_vision || $view_all){
?>
                <th colspan="2" align="center"><?=$fields[15]['title'];?></th>
<?
                }
?>
                <th align="center"><?=$fields[16]['title'];?></th>
            </tr>
            <tr>
<?
            			
			if($dealer_type_name == $distributor || $view_all){
				echo '<th align="center">exGST</th>';
				echo '<th align="center">incGST</th>';
			}
			if($dealer_type_name == $key_partner || $view_all){
				echo '<th align="center">exGST</th>';
				echo '<th align="center">incGST</th>';
			}
			if($dealer_type_name == $pro_av || $view_all){
				echo '<th align="center">exGST</th>';
				echo '<th align="center">incGST</th>';
			}
			if($dealer_type_name == $govt || $view_all){
				echo '<th align="center">exGST</th>';
				echo '<th align="center">incGST</th>';
			}
			if($dealer_type_name == $wholesale1 || $view_all){
				echo '<th align="center">exGST</th>';
				echo '<th align="center">incGST</th>';
			}
			if($dealer_type_name == $wholesale2 || $view_all){
				echo '<th align="center">exGST</th>';
				echo '<th align="center">incGST</th>';
			}
			if($dealer_type_name == $comm || $view_all){
				echo '<th align="center">exGST</th>';
				echo '<th align="center">incGST</th>';
			}
			if($dealer_type_name == $int_vision || $view_all){
				echo '<th align="center">exGST</th>';
				echo '<th align="center">incGST</th>';
			}
			
			
?>
                <th align="center">incGST</th>
            </tr>
	</thead>
	<tbody>
<?
	//$type_id = 	$query2[$i]['id'];
	
	// select categories based on type of product
	//$cates;
		
	//$cates = $this->pricebook_model->get_categories($type);
	
	//end of select categories
	
	//if(is_array($cates) && count($cates) > 0){
		
		for($j=0; $j<count($cates); $j++){
			
			$cate_id = $cates[$j]['id'];
			$products = array();
			
			// select products
			
			$products = $this->pricebook_model->getProducts($type_id,$cate_id);
				
			//end of select products
			
			if(is_array($products) && count($products) > 0){
				
				$p_size = count($products);
?>
				<tr>
				<td class="cate-td" rowspan="<?= $p_size+1?>" align="center"><?= $cates[$j]['cate_name']?></td>
				</tr>
<?
				for($k=0; $k<$p_size; $k++){
					
					$fcws = $product_img = $img = NULL;
					
					$product_id = $products[$k]['id'];
					$fcws = $this->db->query("SELECT `id` FROM `wp_structure`, `wp_model`
                                        WHERE `id` = `link` AND `online` = 1 AND `title` = '{$products[$k]['code']}'
                                        ORDER BY `position` LIMIT 1");
					
					$link_id = '';
					if ($fcws->num_rows() > 0) {
						$result = $fcws->result_array();
						$product_img = $this->db->query("SELECT `id`, `title` FROM `wp_structure`
                                                    WHERE `type` = 'image' AND `online` = 1 AND `parent` = '{$result[0]['id']}'
                                                    ORDER BY `position` LIMIT 1");
						if ($product_img->num_rows() > 0) {
							$product_images = $product_img->result_array();
							$img = $product_images[0];
						}
					$link_id = $result[0]['id'];	
					}//end of if(count($fcws)>0)
?>
				<? if($products[$k]['updated'] == ''){ ?>
				<tr class="normal-tr">
				<? } else { ?>
				<tr class="updated-tr">
				<? } ?>
					<?php // status code ?>
					<td align="center"><? if($products[$k]['updated'] != '') echo $products[$k]['updated']; ?></td>
					<?php // product code ?>
					<td><?
						if($link_id != ''){
						?>
						<a href="http://www.nec-cds.com.au/products/detail/<?= $link_id ?>" onclick="window.open(this.href); return false;"><?= $products[$k]['code']?></a>
						<?
						}
						else{
							echo  $products[$k]['code'];
						}
						?>
					</td>
					<td align="center">
<?
            if (is_array($img)) {
?>
            <img src="http://www.nec-cds.com.au/wpdata/<?= $img['id'] ?>-s.jpg" alt="<?= $img['title'] ?>" width="60" />
<?
            }
?>  
					</td>
<?
				if($type == $projector || $type == $whiteboard){
?>
					<td align="center"><?= $products[$k]['res']?></td>
					<td align="center"><?= $products[$k]['chipset']?></td>
<?
				}
				else if ($type == $display || $type == $public){
?>
					<td align="center"><?= $products[$k]['color']?></td>
					<td align="center"><?= $products[$k]['scr']?></td>
<?
				}
				else if ($type == $lcd){
?>
					<td align="center"><?= $products[$k]['notes']?></td>
					<td align="center"><?= $products[$k]['scr']?></td>
<?
				}
?>
					<td><?= $products[$k]['description']?></td>
					<td align="center"><?= $products[$k]['wty']?></td>
<?
				
				$price_list = $this->pricebook_model->getProductPriceList($cate_id,$type_id,$product_id);
					
				
				if($dealer_type_name == $distributor || $view_all){
					echo '<td align="right">'.$price_list[0]['exGST'].'</td>';
					echo '<td align="right">'.$price_list[0]['incGST'].'</td>';
				}
				if($dealer_type_name == $key_partner || $view_all){
					echo '<td align="right">'.$price_list[1]['exGST'].'</td>';
					echo '<td align="right">'.$price_list[1]['incGST'].'</td>';
				}
				if($dealer_type_name == $pro_av || $view_all){
					echo '<td align="right">'.$price_list[2]['exGST'].'</td>';
					echo '<td align="right">'.$price_list[2]['incGST'].'</td>';
				}
				if($dealer_type_name == $govt || $view_all){
					echo '<td align="right">'.$price_list[3]['exGST'].'</td>';
					echo '<td align="right">'.$price_list[3]['incGST'].'</td>';
				}
				if($dealer_type_name == $wholesale1 || $view_all){
					echo '<td align="right">'.$price_list[4]['exGST'].'</td>';
					echo '<td align="right">'.$price_list[4]['incGST'].'</td>';
				}
				if($dealer_type_name == $wholesale2 || $view_all){
					echo '<td align="right">'.$price_list[5]['exGST'].'</td>';
					echo '<td align="right">'.$price_list[5]['incGST'].'</td>';
				}
				if($dealer_type_name == $comm || $view_all){
					echo '<td align="right">'.$price_list[6]['exGST'].'</td>';
					echo '<td align="right">'.$price_list[6]['incGST'].'</td>';
				}
				if($dealer_type_name == $int_vision || $view_all){
					echo '<td align="right">'.$price_list[7]['exGST'].'</td>';
					echo '<td align="right">'.$price_list[7]['incGST'].'</td>';
				}
				
					
					echo '<td align="right">'.$price_list[8]['incGST'].'</td>';
								
?>
					
            </tr>
<?
				}//end of loop of products	
			
			}//end if count($products)>0
		
		// select accessories
		$query = $this->pricebook_model->getAccessorySize($type_id, $cate_id);	
		// end of select accessories
		
		$a_size = $query;
		if($a_size > 0){
			
			//select accessories
			$accessories = $this->pricebook_model->getAccessories($type_id,$cate_id);
			
			//end of select accessories
?>
			<tr>
                <td class="cate-td" rowspan="<?= $a_size+1?>" align="center">Accessories</td>
            </tr>
<?
			for($m=0; $m<$a_size; $m++){
				
				$access_id = $accessories[$m]['id'];
?>
			<? if($accessories[$m]['updated'] == '') { ?>
			<tr class="normal-tr">
			<? } else { ?>
			<tr class="updated-tr">
			<? } ?>
				<td align="center"><? if($accessories[$m]['updated']!= '') echo $accessories[$m]['updated']; ?></td>
<?
			if($type == $projector || $type == $whiteboard){
?>
                <td colspan="4"><?= $accessories[$m]['code']?></td>
<?
			}
			else if($type == $display || $type == $public){
?>
				<td colspan="2"><?= $accessories[$m]['code']?></td>
				<td align="center"><?= $accessories[$m]['color']?></td>
				<td>&nbsp;</td>
<?
			}
			else if ($type == $lcd){
?>
				<td colspan="2"><?= $accessories[$m]['code']?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
<?
			}
?>
                <td><?= $accessories[$m]['description']?></td>
                <td>&nbsp;</td>
<?
			
            $a_price_list = $this->pricebook_model->getAccessPriceList($cate_id,$type_id,$access_id);
            
			
			if($dealer_type_name == $distributor || $view_all){
					echo '<td align="right">'.$a_price_list[0]['exGST'].'</td>';
					echo '<td align="right">'.$a_price_list[0]['incGST'].'</td>';
			}
			if($dealer_type_name == $key_partner || $view_all){
				echo '<td align="right">'.$a_price_list[1]['exGST'].'</td>';
				echo '<td align="right">'.$a_price_list[1]['incGST'].'</td>';
			}
			if($dealer_type_name == $pro_av || $view_all){
				echo '<td align="right">'.$a_price_list[2]['exGST'].'</td>';
				echo '<td align="right">'.$a_price_list[2]['incGST'].'</td>';
			}
			if($dealer_type_name == $govt || $view_all){
				echo '<td align="right">'.$a_price_list[3]['exGST'].'</td>';
				echo '<td align="right">'.$a_price_list[3]['incGST'].'</td>';
			}
			if($dealer_type_name == $wholesale1 || $view_all){
				echo '<td align="right">'.$a_price_list[4]['exGST'].'</td>';
				echo '<td align="right">'.$a_price_list[4]['incGST'].'</td>';
			}
			if($dealer_type_name == $wholesale2 || $view_all){
				echo '<td align="right">'.$a_price_list[5]['exGST'].'</td>';
				echo '<td align="right">'.$a_price_list[5]['incGST'].'</td>';
			}
			if($dealer_type_name == $comm || $view_all){
				echo '<td align="right">'.$a_price_list[6]['exGST'].'</td>';
				echo '<td align="right">'.$a_price_list[6]['incGST'].'</td>';
			}
			if($dealer_type_name == $int_vision || $view_all){
				echo '<td align="right">'.$a_price_list[7]['exGST'].'</td>';
				echo '<td align="right">'.$a_price_list[7]['incGST'].'</td>';
			}
			
				
				echo '<td align="right">'.$a_price_list[8]['incGST'].'</td>';
            
?>
			
        </tr>
<?

			}//end of loop accessories
			
		}//end if a_size >0
			
		}//end of for loop of count($cates)
		
	}// end of if(count($cates))
?>
	</tbody>
	</table><br />
<?
}// end loop of product types 
?>

<br />
<div class="print">
	<input type="button" value="close window" onclick="window.close();" />
	<input type="button" value="print this page" onclick="window.open('/pricebook/instruction/', 'instruction', 'width=600, height=400');" />
	<input type="button" value="Download Excel Compatible File" onclick="document.location = '/pricebook/getPricebook/'" />
</div>
<br /><br />
</center>
</body>

</html>
