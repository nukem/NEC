<?

if (! isset ($errorsChecked)) {
 if (! ereg ('.+', $_POST['title']))
  $errors[] = $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 if (! ereg ('.+', $_POST['dyk_title']))
  $errors[] = 'Slide title is required';
 if (! ereg ('.+', $_POST['dyk_copy']))
  $errors[] = 'Slide copy is required';
 $uri = strtolower (ereg_replace ('[^A-Za-z0-9]+', '-', strip_accents ($_POST['title'])));
 
 if(substr($uri, -1) == '-') { $uri = substr_replace($uri, "", -1) ; }
  
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 if (! isset ($_POST['online']) && $id == $user['parent'])
  $errors[] = $lang[107];
 $errorsChecked = true;
} else {

 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_dyk
  SET
   title = '" . addslashes ($_POST['title']) . "',
   uri = '$uri',
   online = $online,
   sort = '{$_POST['sort']}',
   position = {$_POST['position']},
   modified = '$time',
   viewRights = '$viewRights',
   createRights = '$createRights',
   editRights = '$editRights',
   deleteRights = '$deleteRights',
   dyk_title = '" . mysql_real_escape_string($_POST['dyk_title']) . "',
   dyk_copy = '" . mysql_real_escape_string($_POST['dyk_copy']) . "'
  WHERE
   link = id AND
   id = $id");
}

?>
