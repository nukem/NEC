<?php

/*
 * Sending single email or to a set of
 * addresses separated with a ';'
 */

require ("cfg.php"); require ("lang.php"); require ("fn.php");

require_once "lib/Swift.php"; require_once "lib/Swift/Connection/SMTP.php";

error_reporting (E_ALL); //E_ERROR | E_PARSE);
ini_set ("arg_separator.output","&amp;");
ini_set ("session.use_only_cookies", true);

//session_save_path('/home/ne/nec/nec-cds.com.au/tmp');

session_start(); if (! @ mysql_connect ($cfg['db']['address'],
$cfg['db']['username'], $cfg['db']['password']))
 $errors [] = $lang[78];
if (! @ mysql_select_db ($cfg['db']['name']))
 $errors [] = $lang[79];
if (! $logFile = @ fopen ('log.txt', 'a'))
 $errors [] = $lang[80];
if (get_magic_quotes_gpc ()) {
 $_POST = array_map ('strip_slashes_deep', $_POST); $_GET = array_map
 ('strip_slashes_deep', $_GET);
}

if(isset($_POST['addresses']) && isset($_POST['file_name'])){

	$addresses = $_POST['addresses'];
	$filename = $_POST['file_name'];
	$subject = "NEC price list";
	$nec_email ="admin@nec-cds.com.au";// input from email address here
	
	if($addresses != ""){
		
		$addr_array = array();
		
		if(substr_count($addresses,";")>0){
		   $addr_array = explode(";", trim($addresses));
		} else
			$addr_array[] = trim($addresses);
	
	
		$swift =& new Swift(new Swift_Connection_SMTP("localhost",25));
		
		if( is_array($addr_array) && count($addr_array) > 0 ){
		 
			#$body = file_get_contents($filename);
			$message =& new Swift_Message($subject); 
			   			
			$html = file_get_contents($filename);
			
			$regex = '@<img src="http://([^0-9]+)/([0-9]+)-s\.jpg" alt="([^"]+)" width="60" />@e';
			$replace = '"<img src=\"" . $message->attach(new Swift_Message_Image(new Swift_File("/home/ne/nec/nec-cds.com.au/public/www/wpdata/$2-s.jpg"))) . "\" alt=\"$3\" width=\"60\" />"';
			$html = preg_replace($regex, $replace, $html);
			
			
			
			$message->attach(new Swift_Message_Part($html, "text/html"));
			
			
			foreach($addr_array as $address){
				
				if($address != ''){
															
					if ( ! $swift->send($message, trim($address),$nec_email)){
						die("{error:true, msg:'Failed sending the email'}");
					}
				}
			}
			
			echo "{error:false, msg:'FINISHED'}";
			$swift->disconnect();
		}
	} else{
			
			echo "{error:true, msg:'Email address is required.'}";
	}

}

?>