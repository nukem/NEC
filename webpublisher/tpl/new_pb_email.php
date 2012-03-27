<?php
require ("../cfg.php");
require ("../lang.php");
require ("../fn.php");

error_reporting (E_ALL); //E_ERROR | E_PARSE);
ini_set ("arg_separator.output", "&amp;");
ini_set ("session.use_only_cookies", true);

//session_save_path('/home/ne/nec/nec-cds.com.au/tmp');

session_start();
if (! @ mysql_connect ($cfg['db']['address'], $cfg['db']['username'], $cfg['db']['password']))
 $errors [] = $lang[78];
if (! @ mysql_select_db ($cfg['db']['name']))
 $errors [] = $lang[79];
if (! $logFile = @ fopen ('log.txt', 'a'))
 $errors [] = $lang[80];
if (get_magic_quotes_gpc ()) {
 $_POST = array_map ('strip_slashes_deep', $_POST);
 $_GET = array_map ('strip_slashes_deep', $_GET);
}

$projector = "Projector";
$whiteboard = "Interactive Whiteboard";
$display = "Commercial Flat Panel Display";
$lcd = "LCD & Plasma Television";
$whitegoods = "Whitegoods";

$distributor = "DISTRIBUTOR";
$key_partner = "KEY PARTNER";
$pro_av = "PRO AV";
$govt = "GOVT";
$wholesale1 = "WHOLESALE1";
$wholesale2 = "WHOLESALE2";
$comm = "H/NORMAN COMM";
$int_vision = "INT VISION";
$rrp = "RRP";

$dealer_type = $_GET['pb_cate'];
$sql = dbq('SELECT * FROM nec_dealer WHERE id='.$dealer_type);
$dealer_type_name = $sql[0]['dealer_type'];


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title></title>
<style type='text/css'>
body{
	font-family: sans-serif;
}

h2{
	color: #000000;	
}

table{
        border: 1px solid rgb(200, 200, 200);
        caption-side: top;
        width: 70%;
        table-layout: auto;
        border-collapse: collapse;
        color: #000000;
        font-family: sans-serif;
        font-size: 12px;
    }
 th{
        color: #ffffff;
        background-color: darkblue;
        padding: 3px;
 }
 
 td{
        padding: 3px;
 }
    
</style>
</head>
<body>
<?
$query2 = dbq('SELECT * FROM nec_product_type');

$type_size = count($query2);

for($i=0; $i<$type_size; $i++){
	
	$type = $query2[$i]['type_name'];
?>
	<h2>NEC <?= $type?> Price List</h2>
	<table border='1'>
		<tr>
                <th rowspan='2'>CAT.</th>
                <th rowspan='2'>Code</th>
                <th rowspan='2'>Image</th>
<?
			if($type == $projector || $type == $whiteboard){
?>
                <th rowspan='2'>RES</th>
                <th rowspan='2'>Chipset</th>
<?
			}
			else if($type == $display){
?>
				<th rowspan='2'>Color</th>
				<th rowspan='2'>SCR Size</th>
<?
			}
			else if ($type == $lcd){
?>
				<th rowspan='2'>Notes</th>
				<th rowspan='2'>SCR Size</th>
<?
			}
?>
                <th rowspan='2'>Product Description</th>
                <th rowspan='2'>WTY</th>
<?
                if($dealer_type_name == $distributor){
?>
                <th colspan='2'>DISTRIBUTOR</th>
<?
                }
                if($dealer_type_name == $key_partner){
?>
                <th colspan='2'>KEY PARTNER</th>
<?
                }
                if($dealer_type_name == $pro_av){
?>
                <th colspan='2'>PRO AV</th>
<?
                }
                if($dealer_type_name == $govt){
?>
                <th colspan='2'>GOV'T</th>
<?
                }
                if($dealer_type_name == $wholesale1){
?>
                <th colspan='2'>WHOLESALE 1</th>
<?
                }
                if($dealer_type_name == $wholesale2){
?>
                <th colspan='2'>WHOLESALE 2</th>
<?
                }
                if($dealer_type_name == $comm){
?>
                <th colspan='2'>H/NORMAN COMM</th>
<?
                }
                if($dealer_type_name == $int_vision){
?>
                <th colspan='2'>INT VISION</th>
<?
                }
?>
                <th>RRP</th>
            </tr>
            <tr>
<?
            if($dealer_type != 9){
?>
                <th>exGST</th>
                <th>incGST</th>
<?
            }
?>
                <th>incGST</th>
            </tr>
<!----------------------------------------------------------------------------------------->
<?
	$type_id = 	$query2[$i]['id'];
	
	// select categories based on type of product
	$cates;
	
	if($type == $projector){
		$cates = dbq('SELECT * FROM nec_projector_cate');
	}
	/*
	else if($type == $whiteboard){
		$cates = dbq('SELECT * FROM nec_whiteboard_cate');
	}
	*/
	else if ($type == $display){
		$cates = dbq('SELECT * FROM nec_panel_display_cate');
	}
	else if ($type == $lcd){
		$cates = dbq('SELECT * FROM nec_lcd_tv_cate');
	}
	else if($type == $whitegoods){
		$cates = dbq('SELECT * FROM nec_whitegoods_cate');
	}
	//end of select categories
	
	if(count($cates) > 0){
		
		for($j=0; $j<count($cates); $j++){
			
			$cate_id = $cates[$j]['id'];
			$products = array();
			
			// select products
			if($type == $projector){
				$products = dbq('SELECT * FROM nec_projector WHERE cate_fk='.$cate_id);
			}
			/*
			else if($type == $whiteboard){
				$products = dbq('SELECT * FROM nec_whiteboard WHERE cate_fk='.$cate_id);
			}
			*/
			else if ($type == $display){
				$products = dbq('SELECT * FROM nec_panel_display WHERE cate_fk='.$cate_id);
			}
			else if ($type == $lcd){
				$products = dbq('SELECT * FROM nec_lcd_tv WHERE cate_fk='.$cate_id);
			}
			else if($type == $whitegoods){
				$products = dbq('SELECT * FROM nec_whitegoods WHERE cate_fk='.$cate_id);
			}	
			//end of select products
			
			if(count($products) > 0){
				
				$p_size = count($products);
?>
				<tr>
					<td rowspan='<?= $p_size+1?>'><?= $cates[$j]['cate_name']?></td>
				</tr>
<?
				for($k=0; $k<$p_size; $k++){
					
					$product_id = $products[$k]['id'];
					$fcws = dbq("SELECT `id` FROM `wp_structure`, `wp_model`
                                        WHERE `id` = `link` AND `online` = 1 AND `title` = '{$products[$k]['code']}'
                                        ORDER BY `position` LIMIT 1");
            
					if (count($fcws) > 0) {
						$product_img = dbq("SELECT `id`, `title` FROM `wp_structure`
															WHERE `type` = 'image' AND `online` = 1 AND `parent` = '{$fcws[0]['id']}'
															ORDER BY `position` LIMIT 1");
						if (count($product_img) > 0) {
							$img = $product_img[0];
						}
						
					}//end of if(count($fcws)>0)
?>
				<tr>
					<td><?= $products[$k]['code']?></td>
					<td>
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
					<td><?= $products[$k]['res']?></td>
					<td><?= $products[$k]['chipset']?></td>
<?
				}
				else if ($type == $display){
?>
					<td><?= $products[$k]['color']?></td>
					<td><?= $products[$k]['scr']?></td>
<?
				}
				else if ($type == $lcd){
?>
					<td><?= $products[$k]['notes']?></td>
					<td><?= $products[$k]['scr']?></td>
<?
				}
?>
					<td><?= $products[$k]['description']?></td>
					<td><?= $products[$k]['wty']?></td>
<?
					$price_list = dbq('SELECT * FROM nec_price_list WHERE product_type_fk='.$type_id." AND cate_fk=".$cate_id." AND product_fk=".$product_id." AND dealer_type_fk=".$dealer_type);
					$rrp = dbq('SELECT * FROM nec_price_list WHERE product_type_fk='.$type_id." AND cate_fk=".$cate_id." AND product_fk=".$product_id." AND dealer_type_fk=9");
					if($dealer_type != 9){
?>
					<td><?= $price_list[0]['exGST']?></td>
					<td><?= $price_list[0]['incGST']?></td>
<?
					}//end if 4dealer_type !=9
?>
					<td><?= $rrp[0]['incGST']?></td>
            </tr>
<?
				}//end of loop of products	
			
			}//end if count($products)>0
		
		// select accessories
		if($type == $projector){
			$query = dbq('SELECT COUNT(*) AS num FROM nec_projector_access WHERE cate_fk='.$cate_id);
		}
		else if($type == $whiteboard){
			//$accessories = dbq('SELECT COUNT(*) AS num FROM nec_projector_access WHERE cate_fk='.$cate_id);
			$query[0]['num']=0;
		}
		else if ($type == $display){
			$query = dbq('SELECT COUNT(*) AS num FROM nec_panel_display_access WHERE cate_fk='.$cate_id);
		}
		else if ($type == $lcd){
			$query = dbq('SELECT COUNT(*) AS num FROM nec_lcd_tv_access WHERE cate_fk='.$cate_id);
		}
		else if($type == $whitegoods){
			//$accessories = dbq('SELECT COUNT(*) AS num FROM nec_projector_access WHERE cate_fk='.$cate_id);
			$query[0]['num']=0;
		}	
		// end of select accessories
		
		$a_size = $query[0]['num'];
		if($a_size > 0){
			//select accessories
			if($type == $projector){
				$accessories = dbq('SELECT * FROM nec_projector_access WHERE cate_fk='.$cate_id);
			}
			else if($type == $whiteboard){
				//$accessories = dbq('SELECT COUNT(*) AS num FROM nec_projector_access WHERE cate_fk='.$cate_id);
				//$query[0]['num']=0;
			}
			else if ($type == $display){
				$accessories = dbq('SELECT * FROM nec_panel_display_access WHERE cate_fk='.$cate_id);
			}
			else if ($type == $lcd){
				$accessories = dbq('SELECT * FROM nec_lcd_tv_access WHERE cate_fk='.$cate_id);
			}
			else if($type == $whitegoods){
				//$accessories = dbq('SELECT COUNT(*) AS num FROM nec_projector_access WHERE cate_fk='.$cate_id);
				//$query[0]['num']=0;
			}
			//end of select accessories
?>
			<tr>
                <td rowspan='<?= $a_size+1?>'>Accessories</td>
            </tr>
<?
			for($m=0; $m<$a_size; $m++){
				
				$access_id = $accessories[$m]['id'];
?>
			<tr>
<?
			if($type == $projector || $type == $whiteboard){
?>
                <td colspan='4'><?= $accessories[$m]['code']?></td>
<?
			}
			else if($type == $display){
?>
				<td colspan='2'><?= $accessories[$m]['code']?></td>
				<td><?= $accessories[$m]['color']?></td>
				<td>&nbsp;</td>
<?
			}
			else if ($type == $lcd){
?>
				<td colspan='2'><?= $accessories[$m]['code']?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
<?
			}
?>
                <td><?= $accessories[$m]['description']?></td>
                <td>&nbsp;</td>
<?
			$a_price_list = dbq('SELECT * FROM nec_price_list WHERE product_type_fk='.$type_id." AND cate_fk=".$cate_id." AND access_fk=".$access_id." AND dealer_type_fk=".$dealer_type);
            $a_rrp = dbq('SELECT * FROM nec_price_list WHERE product_type_fk='.$type_id." AND cate_fk=".$cate_id." AND access_fk=".$access_id." AND dealer_type_fk=9");
            
            if($dealer_type != 9){
?>
			<td><?= $a_price_list[0]['exGST']?></td>
            <td><?= $a_price_list[0]['incGST']?></td>
<?
			}
?>
			<td><?= $a_rrp[0]['incGST']?></td>
        </tr>
<?

			}//end of loop accessories
			
		}//end if a_size >0
			
		}//end of for loop of count($cates)
		
	}// end of if(count($cates))
?>	
	</table><br />
<?
}// end loop of product types 
?>
</body>

</html>
