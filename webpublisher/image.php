<?

if (! isset ($errorsChecked)) {
 if (! ereg ('.+', $_POST['title']))
  $errors[] = $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (ereg_replace ('[^A-Za-z0-9]', '', strip_accents ($_POST['title'])));
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 if (! is_file ($cfg['data'] . $id . "-s.jpg") && ! is_uploaded_file ($_FILES['fileId']['tmp_name']) && $_POST['existing_wp_image'] == '')
  $errors[] = $lang[48];
 if ($_POST['existing_wp_image'] != '' && !preg_match('@^\.\./wpdata/([0-9]+)-(m|l|s)\.jpg$@', $_POST['existing_wp_image'], $img_matches)) {
 	$errors[] = 'Existing file supplied has incorrect format.';
 }
 if (is_uploaded_file ($_FILES['fileId']['tmp_name'])) {
  move_uploaded_file ($_FILES['fileId']['tmp_name'], $cfg['data'] . $id);
  $imageinfo = getimagesize ($cfg['data'] . $id);
  if (! in_array ($imageinfo[2], array (1, 2, 3)))
   $errors[] = $lang[113];
	 if (isset ($errors))
   unlink ($cfg['data'] . $id);
 }
 $errorsChecked = true;
} else {
 if (is_file ($cfg['data'] . $id)) {
  if (is_file ($cfg['data'] . "$id-s.jpg")) {
   unlink ($cfg['data'] . "$id-s.jpg");
   unlink ($cfg['data'] . "$id-m.jpg");
   unlink ($cfg['data'] . "$id-l.jpg");
  }
  resize_img ($cfg['data'] . $id, $cfg['data'] . "$id-s.jpg", $cfg['img']['small'][0], $cfg['img']['small'][1], $cfg['img']['small'][2], $cfg['img']['small'][3], $cfg['img']['small'][4], $cfg['img']['small'][5], $cfg['img']['small'][6], $cfg['img']['small'][7]);
  resize_img ($cfg['data'] . $id, $cfg['data'] . "$id-m.jpg", $cfg['img']['medium'][0], $cfg['img']['medium'][1], $cfg['img']['medium'][2], $cfg['img']['medium'][3], $cfg['img']['medium'][4], $cfg['img']['medium'][5], $cfg['img']['medium'][6], $cfg['img']['medium'][7]);
  resize_img ($cfg['data'] . $id, $cfg['data'] . "$id-l.jpg", $cfg['img']['large'][0], $cfg['img']['large'][1], $cfg['img']['large'][2], $cfg['img']['large'][3], $cfg['img']['large'][4], $cfg['img']['large'][5], $cfg['img']['large'][6], $cfg['img']['large'][7]);
  unlink ($cfg['data'] . $id);
 } else if (isset($img_matches[1])) {
 	
	// existing file supplied from WP
	$new_img = "{$img_matches[1]}-l.jpg";
	
	if (is_file ($cfg['data'] . "$id-s.jpg")) {
		unlink ($cfg['data'] . "$id-s.jpg");
		unlink ($cfg['data'] . "$id-m.jpg");
		unlink ($cfg['data'] . "$id-l.jpg");
	}
	
	resize_img ($cfg['data'] . $new_img, $cfg['data'] . "$id-s.jpg", $cfg['img']['small'][0], $cfg['img']['small'][1], $cfg['img']['small'][2], $cfg['img']['small'][3], $cfg['img']['small'][4], $cfg['img']['small'][5], $cfg['img']['small'][6], $cfg['img']['small'][7]);
	resize_img ($cfg['data'] . $new_img, $cfg['data'] . "$id-m.jpg", $cfg['img']['medium'][0], $cfg['img']['medium'][1], $cfg['img']['medium'][2], $cfg['img']['medium'][3], $cfg['img']['medium'][4], $cfg['img']['medium'][5], $cfg['img']['medium'][6], $cfg['img']['medium'][7]);
	resize_img ($cfg['data'] . $new_img, $cfg['data'] . "$id-l.jpg", $cfg['img']['large'][0], $cfg['img']['large'][1], $cfg['img']['large'][2], $cfg['img']['large'][3], $cfg['img']['large'][4], $cfg['img']['large'][5], $cfg['img']['large'][6], $cfg['img']['large'][7]);
	
 }
 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_image
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