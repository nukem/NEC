<?

if (! isset ($errorsChecked)) {
 if (! ereg ('.+', $_POST['title']))
  $errors[] = $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (ereg_replace ('[^A-Za-z0-9]+', '-', strip_accents ($_POST['title'])));
 
 if(substr($uri, -1) == '-') { $uri = substr_replace($uri, "", -1) ; }
  
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 if (! isset ($_POST['online']) && $id == $user['parent'])
  $errors[] = $lang[107];
 $errorsChecked = true;
} else {

 dbq("DELETE FROM nec_permissions WHERE link = $id;");
 dbq("OPTIMIZE TABLE nec_permissions;");

if($id != 1 && $id != 124 && isset($_POST['permissions'])){
 $query = "INSERT INTO nec_permissions (link, category_fk) VALUES ";
 foreach($_POST['permissions'] as $perm){
	$query .= "($id, $perm), ";
 }
 $query = substr($query, 0, -2);
 $query .= ";";
 
 dbq($query);
}

 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_folder
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
   deleteRights = '$deleteRights'
  WHERE
   link = id AND
   id = $id");
}

?>
