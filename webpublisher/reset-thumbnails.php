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

$files = dbq("SELECT * FROM `wp_hi_res` WHERE `thumb` = 0 ORDER BY `recId`");

if (is_array($files)) {
	$rec = count($files);
	$fl = array();
	$i = 0;
	foreach ($files as $file) {
		if ($i < 25) {
			
			if (is_file ($cfg['data'] . "{$file['link']}-l.jpg")) {
				
				rename($cfg['data'] . "{$file['link']}-l.jpg", $cfg['data'] . "{$file['link']}-l.src");
				
				unlink ($cfg['data'] . "{$file['link']}-s.jpg");
				unlink ($cfg['data'] . "{$file['link']}-m.jpg");
				
				resize_img ($cfg['data'] . "{$file['link']}-l.src", $cfg['data'] . "{$file['link']}-s.jpg", $cfg['img']['small'][0], $cfg['img']['small'][1], $cfg['img']['small'][2], $cfg['img']['small'][3], $cfg['img']['small'][4], $cfg['img']['small'][5], $cfg['img']['small'][6], $cfg['img']['small'][7]);
				resize_img ($cfg['data'] . "{$file['link']}-l.src", $cfg['data'] . "{$file['link']}-m.jpg", $cfg['img']['medium'][0], $cfg['img']['medium'][1], $cfg['img']['medium'][2], $cfg['img']['medium'][3], $cfg['img']['medium'][4], $cfg['img']['medium'][5], $cfg['img']['medium'][6], $cfg['img']['medium'][7]);
				resize_img ($cfg['data'] . "{$file['link']}-l.src", $cfg['data'] . "{$file['link']}-l.jpg", $cfg['img']['large'][0], $cfg['img']['large'][1], $cfg['img']['large'][2], $cfg['img']['large'][3], $cfg['img']['large'][4], $cfg['img']['large'][5], $cfg['img']['large'][6], $cfg['img']['large'][7]);
				
				unlink ($cfg['data'] . "{$file['link']}-l.src");
				
				dbq("UPDATE `wp_hi_res` SET `thumb` = 1 WHERE `recId` = {$file['recId']}");
				
				$fl[] = "{$file['link']}-l.src";
				
			}
			
		}
		$i++;
	}
	
	echo "<pre>\n{$rec} files left\nConverted the following\n";
	echo join("\n", $fl) . "\nPrinting the result array\n" . print_r($files, true) . "</pre>";
	
}
?>