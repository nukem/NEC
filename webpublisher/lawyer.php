<?

if (! isset ($errorsChecked)) {
 if (! ereg ('.+', $_POST['title']))
  $errors[] = $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (ereg_replace ('[^A-Za-z0-9]+', '-', strip_accents ($_POST['title'])));
 
 if (!preg_match('/[a-z]+/i', $_POST['jobTitle']))
  $errors[] = 'Job Title is required.';
 
 
 if(substr($uri, -1) == '-') { $uri = substr_replace($uri, "", -1) ; }
 
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 $errorsChecked = true;
} else {


 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_lawyer
  SET
   title = '" . mysql_real_escape_string ($_POST['title']) . "',
   uri = '$uri',
   online = $online,
   sort = '{$_POST['sort']}',
   position = {$_POST['position']},
   modified = '$time',
   viewRights = '$viewRights',
   createRights = '$createRights',
   editRights = '$editRights',
   deleteRights = '$deleteRights',
   content = '" . mysql_real_escape_string (preg_replace('/src="..\//', 'src="', $_POST['content'])) . "',
   jobTitle = '" . mysql_real_escape_string ($_POST['jobTitle']) . "',
   qualifications = '" . mysql_real_escape_string ($_POST['qualifications']) . "',
   practice = '" . mysql_real_escape_string ($_POST['practice']) . "'
  WHERE
   link = id AND
   id = $id");
}

?>