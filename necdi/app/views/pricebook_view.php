<?php

    $projector = "Projector";
	$whiteboard = "LCD Desktop Monitors";
	//$display = "Commercial Flat Panel Display";
	$display = "LCD Public Displays";
	$lcd = "LCD & Plasma Television";
	$whitegoods = "Whitegoods";
    
    $distributor = "DISTRIBUTOR";
    $key_partner = "KEY PARTNER";
    $pro_av = "PRO AV";
    $govt = "GOVT";
    $wholesale1 = "WHOLESALE1";
    $wholesale2 = "WHOLESALE2";
    $comm = "EDUCATION";
    $int_vision = "INT VISION";
    $rrp = "RRP";
    
    $isAdmin = ($user_fk == 181 || $user_fk == 1620);
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="<?= $this->config->item('base_url') ?>" />
	<title>NEC <?= $name?> price list</title>
<style type="text/css" media="screen,print">
    #pricebook{
        border: 1px solid rgb(200, 200, 200);
        caption-side: top;
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;
        color: #ffffff;
        font-family: sans-serif;
        font-size: 12px;
    }
    
	#pricebook th{
		background-color: #205594;
	}
	
    #pricebook td{
        padding: 5px;
	/*background-color: #6287B2;*/
    }
    
    .normal-tr{
	background-color: #6287B2;
    }
    
    .updated-tr{
	background-color: #266fe3;
    }
    
    .cate-td{
	background-color: #6287B2;
    }
    
    body{
        background: #A1B5CC;
		font-family:arial, sans-serif;
    }
    
    #pricebook a:hover{
        color: #EAEAEA;
    }
    
    #pricebook a:visited{
        color: #FFFFFF;
    }
    
    #pricebook a{
        color: #ffffff;
    }
	h2 {
		font-family:arial, sans-serif;
		color:#fff;
	}
</style>
<style type="text/css" media="print">
body {
	background:#fff;
	font-family:arial, sans-serif;
}
#pricebook{
    border: 1px solid #000;
	color: #000;
}
#pricebook th{
	background-color: #fff;
}

#pricebook td{
	background-color: #fff;
}
.close-print {
	display:none;
}
h2 {
	font-family:arial, sans-serif;
	color:#000;
}
</style>

</head>
<body>
<center>
<br />
<div class="close-print">
<input type="button" value="Close Window" onclick="window.close();" />
<input type="button" value="Print This Page" onclick="window.open('/pricebook/instruction/', 'instruction', 'width=600, height=400');" />
<?#<input type="button" value="Download Excel Compatible File" onclick="document.location = '<?= rtrim($this->uri->uri_string(), '/') /true'" />?>
</div>
<br />
<h2><?= $name?> - <?= $cate?></h2>	
<table border='1' id="pricebook">
    <tr>
<?
        if($a_num != 0){
?>
        <th rowspan='2'><?=$fields[0]['title'];?></th>
<?
        }
?>
	<th rowspan="2"><?=$fields[1]['title'];?></th>
        <th rowspan='2'><?=$fields[2]['title'];?></th>
        <th rowspan='2'><?=$fields[3]['title'];?></th>
<?
        if($name == $projector||$name == $whiteboard){
?>
        <th rowspan='2'><?=$fields[4]['title'];?></th>
        <th rowspan='2'><?=$fields[5]['title'];?></th>
<?
        }
        if($name == $display){
?>
        <th rowspan='2'><?=$fields[17]['title'];?></th>
        <th rowspan='2'><?=$fields[19]['title'];?></th>
<?
        }
        if($name == $lcd){
?>
        <th rowspan='2'><?=$fields[18]['title'];?></th>
        <th rowspan='2'><?=$fields[19]['title'];?></th>
<?
        }
?>
        <th rowspan='2'><?=$fields[6]['title'];?></th>
        <th rowspan='2'><?=$fields[7]['title'];?></th>
<?
        if($pricebook_cate == trim($distributor)|| $isAdmin){
?>
        <th colspan='2'><?=$fields[8]['title'];?></th>
<?
        }
        if($pricebook_cate == trim($key_partner)|| $isAdmin){
?>
        <th colspan='2'><?=$fields[9]['title'];?></th>
<?
        }
        if($pricebook_cate == trim($pro_av) || $isAdmin){
?>
        <th colspan='2'><?=$fields[10]['title'];?></th>
<?
        }
        if($pricebook_cate == trim($govt) || $isAdmin){
?>
        <th colspan='2'><?=$fields[11]['title'];?></th>
<?
        }
        if($pricebook_cate == trim($wholesale1) || $isAdmin){
?>
        <th colspan='2'><?=$fields[12]['title'];?></th>
<?
        }
        if($pricebook_cate == trim($wholesale2) || $isAdmin){
?>
        <th colspan='2'><?=$fields[13]['title'];?></th>
<?
        }
        if($pricebook_cate == trim($comm) || $isAdmin){
?>
        <th colspan='2'><?=$fields[14]['title'];?></th>
<?
        }
        if($pricebook_cate == trim($int_vision) || $isAdmin){
?>
        <th colspan='2'><?=$fields[15]['title'];?></th>
<?
        }
?>
        <th><?=$fields[16]['title'];?></th>
    </tr>
    <tr>
<?
        if($pricebook_cate == trim($distributor) || $isAdmin){
?>
        <th>exGST</th>
        <th>inGST</th>
<?
        }
        if($pricebook_cate == trim($key_partner) || $isAdmin){
?>
        <th>exGST</th>
        <th>inGST</th>
<?
        }
        if($pricebook_cate == trim($pro_av) || $isAdmin){
?>
        <th>exGST</th>
        <th>inGST</th>
<?
        }
        if($pricebook_cate == trim($govt) || $isAdmin){
?>
        <th>exGST</th>
        <th>inGST</th>
<?
        }
        if($pricebook_cate == trim($wholesale1) || $isAdmin){
?>
        <th>exGST</th>
        <th>inGST</th>
<?
        }
        if($pricebook_cate == trim($wholesale2) || $isAdmin){
?>
        <th>exGST</th>
        <th>incGST</th>
<?
        }
        if($pricebook_cate == trim($comm) || $isAdmin){
?>
        <th>exGST</th>
        <th>inGST</th>
<?
		}
		if($pricebook_cate == trim($int_vision) || $isAdmin){
?>
        <th>exGST</th>
        <th>inGST</th>
<?
        }
?>
        <th>inGST</th>
    </tr>
    
<?
        if($a_num != 0){
?>
        <td class="cate-td" align='center' rowspan='<?= $p_num+1 ?>'><?= $cate?></td>
<?
        }
?>    
    
<?
foreach($table as $row){
	echo '<!-- ' . print_r($row, true) . '-->';
?>
<? if($row['updated'] == '') { ?>
    <tr class="normal-tr">
<? } else{ ?>
    <tr class="updated-tr">
<? } ?>
	<td align="center"><? if($row['updated']!= '') echo $row['updated']; ?></td>
        <td>

<?
            if ($row['id']!=''){
?>
                <a href="http://www.nec-cds.com.au/products/detail/<?= $row['id']?>" onclick="window.open(this.href); return false;"><?= $row['code']?></a>
<?
            }else
                echo $row['code'];
?>        
       
        </td>
        <td align='center'>
            
<?

            if (is_array($row['product_image'])) {
?>
            <img src="http://www.nec-cds.com.au/wpdata/<?= $row['product_image']['id'] ?>-s.jpg" alt="<?= $row['product_image']['title'] ?>" width="60" />
<?
            }
?>            
           
        </td>
<?
        if($name == $projector||$name == $whiteboard){
?>
        <td align='center'><?= $row['res']?></td>
        <td align='center'><?= $row['chipset']?></td>
<?
        }
        if($name == $display){
?>
        <td align='center'><?= $row['color']?></td>
        <td align='center'><?= $row['scr']?></td>
<?
        }
        if($name == $lcd){
?>
        <td align='center'><?= $row['notes']?></td>
        <td align='center'><?= $row['scr']?></td>
<?
        }
?>
        <td><?= $row['description']?></td>
        <td align='center'><?= $row['wty']?></td>
<?
        if($pricebook_cate == trim($distributor) || $isAdmin){
?>
        <td align='right'><?= $row['0_ex']?></td>
        <td align='right'><?= $row['0_inc']?></td>
<?
        }
        if($pricebook_cate == trim($key_partner) || $isAdmin){
?>
        <td align='right'><?= $row['1_ex']?></td>
        <td align='right'><?= $row['1_inc']?></td>
<?
        }
        if($pricebook_cate == trim($pro_av) || $isAdmin){
?>
        <td align='right'><?= $row['2_ex']?></td>
        <td align='right'><?= $row['2_inc']?></td>
<?
        }
        if($pricebook_cate == trim($govt) || $isAdmin){
?>
        <td align='right'><?= $row['3_ex']?></td>
        <td align='right'><?= $row['3_inc']?></td>
<?
        }
        if($pricebook_cate == trim($wholesale1) || $isAdmin){
?>
        <td align='right'><?= $row['4_ex']?></td>
        <td align='right'><?= $row['4_inc']?></td>
<?
        }
        if($pricebook_cate == trim($wholesale2) || $isAdmin){
?>
        <td align='right'><?= $row['5_ex']?></td>
        <td align='right'><?= $row['5_inc']?></td>
<?
        }
        if($pricebook_cate == trim($comm) || $isAdmin){
?>
        <td align='right'><?= $row['6_ex']?></td>
        <td align='right'><?= $row['6_inc']?></td>
<?
        }
        if($pricebook_cate == trim($int_vision) || $isAdmin){
?>
        <td align='right'><?= $row['7_ex']?></td>
        <td align='right'><?= $row['7_inc']?></td>
<?
        }
?>
        <td align='right'><?= $row['8_inc']?></td>
    </tr>
        
<?
}
        if($a_num != 0){
?>
        <td class="cate-td" align='center' rowspan='<?= $a_num+1 ?>'>accessories</td>
<?
        }
foreach ($access_table as $row){
?>
<? if($row['updated'] == '') { ?>
    <tr class="normal-tr">
<? } else { ?>
    <tr class="updated-tr">	
<? } ?>
        <td align="center"><? if($row['updated']!='') echo $row['updated']; ?></td>

<?
        if($name == $projector||$name == $whiteboard){
?>
        <td colspan='4'><?= $row['code']?></td>
<?
        }
        else{
?>
        <td colspan='2'><?= $row['code']?></td>
<?
        }
?>
        
<?
        if($name == $display){
?>
        <td><?= $row['color']?></td>
        <td>&nbsp;</td>
<?
        }
        if($name == $lcd){
?>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
<?
        }
?>
        <td><?= htmlentities($row['description'], ENT_QUOTES) ?></td>
        <td>&nbsp;</td>
<?
        if($pricebook_cate == trim($distributor)|| $isAdmin){
?>
        <td align='right'><?= $row['0_ex']?></td>
        <td align='right'><?= $row['0_inc']?></td>
<?
        }
        if($pricebook_cate == trim($key_partner) || $isAdmin){
?>
        <td align='right'><?= $row['1_ex']?></td>
        <td align='right'><?= $row['1_inc']?></td>
<?
        }
        if($pricebook_cate == trim($pro_av) || $isAdmin){
?>
        <td align='right'><?= $row['2_ex']?></td>
        <td align='right'><?= $row['2_inc']?></td>
<?
        }
        if($pricebook_cate == trim($govt) || $isAdmin){
?>
        <td align='right'><?= $row['3_ex']?></td>
        <td align='right'><?= $row['3_inc']?></td>
<?
        }
        if($pricebook_cate == trim($wholesale1) || $isAdmin){
?>
        <td align='right'><?= $row['4_ex']?></td>
        <td align='right'><?= $row['4_inc']?></td>
<?
        }
        if($pricebook_cate == trim($wholesale2) || $isAdmin){
?>
        <td align='right'><?= $row['5_ex']?></td>
        <td align='right'><?= $row['5_inc']?></td>
<?
        }
        if($pricebook_cate == trim($comm) || $isAdmin){
?>
        <td align='right'><?= $row['6_ex']?></td>
        <td align='right'><?= $row['6_inc']?></td>
<?
        }
        if($pricebook_cate == trim($int_vision) || $isAdmin){
?>
        <td align='right'><?= $row['7_ex']?></td>
        <td align='right'><?= $row['7_inc']?></td>
<?
        }
?>
        <td align='right'><?= $row['8_inc']?></td>
    </tr>
    
<?

}

?>
</table>
<br /><br />
<div class="close-print">
	<input type="button" value="Close Window" onclick="window.close();" />
	<input type="button" value="Print This Page" onclick="window.open('/pricebook/instruction/', 'instruction', 'width=600, height=400');" />
	<?php #<input type="button" value="Download Excel Compatible File" onclick="document.location = '<?= rtrim($this->uri->uri_string(), '/') /true'" />?>
</div>
</center>
</body>
</html>
