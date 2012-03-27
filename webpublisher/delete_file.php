<?php

if (isset($_POST['file_name']))
{
	$file_name = $_POST['file_name'];
	if (is_file($file_name))
	{
		unlink($file_name);
		echo "{error:false, msg: 'File Deleted !'}";
	}
	else
	{
		echo "{error:true, msg:'Specified file does not exist!'}";
	}
}
else
{
	echo "{error:true, msg:'File path not supplied!'}";
}
?>