<?

if (! isset ($errorsChecked)) {
 if (! ereg ('.+', $_POST['title']))
  $errors[] = $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (ereg_replace ('[^A-Za-z0-9]+', '-', strip_accents ($_POST['title'])));
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 if (! is_file ($cfg['data'] . "$id" . "." . $record['extension']) && ! is_uploaded_file ($_FILES['fileId']['tmp_name']))
  $errors[] = 'Hi resolution file must be uploaded.';
 
 if (is_uploaded_file ($_FILES['fileImageId']['tmp_name'])) {
  move_uploaded_file ($_FILES['fileImageId']['tmp_name'], $cfg['data'] . $id);
  $imageinfo = getimagesize ($cfg['data'] . $id);
  if (! in_array ($imageinfo[2], array (1, 2, 3))) {
   $errors[] = $lang[113];
  }
  if (isset ($errors)) {
   unlink ($cfg['data'] . $id);
  }
 }
 $errorsChecked = true;
} else {
 if (is_uploaded_file ($_FILES['fileId']['tmp_name'])) {
  if ($record['extension'] != '') {
   unlink ($cfg['data'] . "$id" . "." . $record['extension']);
  }
  $extension = strtolower (ereg_replace ('.*\.([A-Za-z0-9_-]+)$', '\\1', $_FILES['fileId']['name']));
  move_uploaded_file ($_FILES['fileId']['tmp_name'], $cfg['data'] . "$id.$extension");
  $image_info = @getimagesize($cfg['data'] . "$id.$extension");
  if ( !is_file($cfg['data'] . $id) && is_array($image_info) && in_array($image_info[2], array(1, 2, 3)) ) {
  	@copy($cfg['data'] . "$id.$extension", $cfg['data'] . $id);
  }
 } else {
  $extension = $record['extension'];
 }
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
 }
 if ($record['position'] != $_POST['position']) {
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 }
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_hi_res
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
   extension = '$extension'
  WHERE
   link = id AND
   id = $id");
}

?>