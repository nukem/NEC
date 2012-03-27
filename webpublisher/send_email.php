<?php

require ("cfg.php");
require ("lang.php");
require ("fn.php");

require_once "lib/Swift.php";
require_once "lib/Swift/Connection/SMTP.php";

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

if(isset($_POST['count'])&& isset($_POST['subject'])){
	
	$count = $_POST['count'];
	$subject = $_POST['subject'];
	
	$sql = dbq('SELECT COUNT(*) AS num FROM nec_email_list');
	$sent = dbq('SELECT COUNT(*) AS num FROM nec_email_list WHERE sent = 1');
	$nec_email = "admin@nec-cds.com.au";// nec email address here
	$subject = "NEC price list";
	
	if($sql[0]['num'] == $sent[0]['num']){
	   echo "{error:false, msg:'FINISHED'}";
	   $delete_sent_mails = dbq('DELETE FROM nec_email_list');
	}else{
	
		$swift =& new Swift(new Swift_Connection_SMTP("localhost", 25));
		
		$addresses = dbq('SELECT * FROM nec_email_list WHERE sent = 0 LIMIT '.$count);
		
		if( is_array($addresses) && count($addresses) > 0 ){
		 
			$n = 0;
			
			$message =& new Swift_Message($subject);
			
			
			foreach($addresses as $address){
												
				$filename = $address['file_name'];
				
				$html = file_get_contents($filename);
				
				$regex = '@<img src="http://([^0-9]+)/([0-9]+)-s\.jpg" alt="([^"]+)" width="60" />@e';
				$replace = '"<img src=\"" . $message->attach(new Swift_Message_Image(new Swift_File("/home/ne/nec/nec-cds.com.au/public/www/wpdata/$2-s.jpg"))) . "\" alt=\"$3\" width=\"60\" />"';
				$html = preg_replace($regex, $replace, $html);
				$message->attach(new Swift_Message_Part($html, "text/html"));
					
				if(dbq('UPDATE nec_email_list SET sent=1 WHERE id='.$address['id'])){
					
					if ( ! $swift->send($message, $address['email'], $nec_email)){
					   die("Failer sending the email");
					}
					$n++;
				} 
			}
			
			$msg_str = ($sql[0]['num'] - $sent[0]['num'])-$n . ' Emails left, out of ' . $sql[0]['num'] . ' originally set in queue.';
			echo "{error:false, msg:'".$msg_str."'}";
			
			
			$swift->disconnect();
		}
	}
}


?>