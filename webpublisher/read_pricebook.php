<?php
$data = 'not uploaded';
if (isset($_POST) && isset($_FILES)) { 
    if ($_POST['fname'] != '' && preg_match('/^[a-z0-9\-\_\.]+$/i', $_POST['fname'])) {
        $fname = 'file-' . $_POST['fname'] . '.txt';
    } else {
        $fname = 'file-random-name' . time() . '.txt';
    }
    
    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        move_uploaded_file($_FILES['userfile']['tmp_name'], $fname);
    }
    
    $data['fname'] = $fname;
    $data['userfile_name'] =$_FILES['userfile']['name'];
    $data['userfile_tmp_name'] = $_FILES['userfile']['tmp_name'];
    $data['userfile_size'] = $_FILES['userfile']['size'];
    $data['userfile_type'] = $_FILES['userfile']['type'];
}
?>
<html>
<head><title>File Upload</title></head>
<body>
    <pre><? if (isset($data)) print_r($data) ?></pre>
<table border="1" align="center">
    <tr><td>
    <form method="POST" enctype= "multipart/form-data"
       action="<? echo $_SERVER['PHP_SELF'] ?>">
       Upload file!
       <input type="file" name="userfile">
        <input  type="text" name="fname" />
       <input type="submit" name="action" value="upload">
    </form>
    </td></tr>
    </table>
</body>
</html>

