<?php

require ("cfg.php");
require ("lang.php");
require ("fn.php");

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

$sql = dbq('SELECT * FROM nec_dealer');

$dealers="";
foreach($sql as $dealer){
	$dealers .= "<option value=".$dealer['id'].">".$dealer['dealer_type']."</option>";
}

$dir = "tpl/pb_email/";

if( file_exists($dir)) {
	
	$files = scandir($dir);
	$jj = 0;
	
	$sql = dbq('SELECT COUNT(*) AS num FROM nec_email_list');
	$sent = dbq('SELECT COUNT(*) AS num FROM nec_email_list WHERE sent = 1');
?>
	<style type="text/css">
		.file{
			padding:5px;
		}
		
		.file table td{
			padding-right:30px;
		}
		
	</style>
	<div style="display:none; height:50px;" id="mailSender">
    <p id="msg">Sending in progress... please wait..</p>
    <p id="newResult"></p>
    </div>
	<div style="display:none;" id = "initCounter"><?=$sent[0]['num']?> Send, out of <?=$sql[0]['num']?> in list.</div>
	<div id="file_list">
<?
	foreach( $files as $file ) {
		if( file_exists($dir . $file) && $file != '.' && $file != '..' && !is_dir($dir . $file) ) {
			?>
			<div class="file" id="del_file_<?= $jj ?>">
				  
				  <label><?= htmlentities($file, ENT_QUOTES) ?></label>&nbsp;&nbsp;
			
				  <a href="<?= htmlentities($dir . $file, ENT_QUOTES) ?>" onclick="window.open(this.href); return false;">View This File</a>&nbsp;&nbsp;<a href="#" onclick="$(this).siblings('.options-email').slideToggle(500); return false;">Options</a>
				  
					<div class="options-email">
						<table>
						<tr>
						<td><label>Email to custom address, seperate different addresses by ";"</label><br />
						<input type="text" name="email_addrs" id="email_addrs_<?= $jj?>" size="50" />
						
						<input type="button" name="email_<?= $jj?>" id="email_<?= $jj?>" value="Send" onclick="sendMail('<?= $dir.$file ?>','email_addrs_<?= $jj ?>');" /></td>
						<!-- get category -->
						<?
							$index = strrpos($file,"id-");
							//$dotpos = strrpos($file, ".");
							$cate_id = substr($file, $index+3, 1);
							$query = dbq("SELECT * FROM nec_dealer WHERE id=".$cate_id);
							$group_name = $query[0]['dealer_type'];
						?>
						
						<td><label>OR email to <?= $group_name ?> group</label><br />
						<!--<select id="dealers"><option value="">Select one group</option></select>-->
						
						<input type="button" name="email_group" id="email_group_<?= $jj ?>" value="Send" onclick="insertEmail('<?= $dir.$file ?>',<?= $cate_id ?>);" /></td></tr>
						</table>
						<br /><br />
						<input type="button" value="Delete this file" onclick="deleteFile('<?= $dir . $file ?>', 'del_file_<?= $jj ?>');" /><br /><br />
					</div>
				</div>
			<?php
		}
		$jj ++;
	}
?>
	</div>

<?
}

?>
	