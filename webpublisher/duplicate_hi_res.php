<?php
/*
 * Duplicates the existing hi-res file
 */

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

if (isset($_GET['extension']) && isset($_GET['parent']) && isset($_GET['fileid']) && preg_match('/^[0-9]+$/', $_GET['fileid'])) {
	
	if (is_file($cfg['data'] . $_GET['fileid'] . '.' . $_GET['extension'])) {
		
		$existing = dbq("SELECT * FROM `wp_structure` WHERE `id` = {$_GET['fileid']}");
		
		$db = dbq ("SELECT MAX(position) AS position FROM {$cfg['db']['prefix']}_structure");
		$position = $db[0]['position'] + 1;
		$time = date ('Y-m-d H:i:s');
		$id = dbq ("INSERT INTO 
						{$cfg['db']['prefix']}_structure
					SET
						title = 'copy of {$existing[0]['title']}',
						uri = 'copy-of-{$existing[0]['uri']}',
						parent = {$_GET['parent']},
						type = 'hi_res',
						sort = 'position',
						position = $position,
						created = '$time',
						modified = '$time',
						viewRights = '{$existing[0]['viewRights']}',
						createRights = '{$existing[0]['createRights']}',
						editRights = '{$existing[0]['editRights']}',
						deleteRights = '{$existing[0]['deleteRights']}'");
		dbq ("INSERT INTO {$cfg['db']['prefix']}_hi_res SET link = $id, extension = '{$_GET['extension']}'");
		
		if ( !copy($cfg['data'] . $_GET['fileid'] . '.' . $_GET['extension'], $cfg['data'] . $id . '.' . $_GET['extension']) ) {
			
			echo "{error: true, errorMsg:'Copy files failed'}";
			
		} else {
		
			if (is_file($cfg['data'] . "{$_GET['fileid']}-s.jpg")) {
				copy($cfg['data'] . "{$_GET['fileid']}-s.jpg", $cfg['data'] . "$id-s.jpg");
				copy($cfg['data'] . "{$_GET['fileid']}-m.jpg", $cfg['data'] . "$id-m.jpg");
				copy($cfg['data'] . "{$_GET['fileid']}-l.jpg", $cfg['data'] . "$id-l.jpg");
			}
			
			echo "{error: false, newID: '{$id}'}";
		
		}
		
	} else {
		echo "{error: true, errorMsg:'Source file does not exist!'}";
	}
	
} else {

	echo "{error: true, errorMsg:'Invalid details suplied'}";
	
}
?>