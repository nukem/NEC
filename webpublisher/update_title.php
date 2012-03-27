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

if(isset($_POST['name'])){
 
  $title = $_POST['name'];
  $sql = dbq("UPDATE wp_structure SET title = '".$title."' WHERE id = 2257");
  echo "{error:false, msg:'Title has been updated'}";

}
else{
  
  echo "{error:true, msg:'Title not supplied!'}";

}
?>