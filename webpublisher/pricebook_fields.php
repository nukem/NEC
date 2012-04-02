<?php
if($_POST)
{
	while(list($key, $value) = each($_POST['field']))
	{
		$value = mysql_escape_string($value);
		$sql = "UPDATE nec_pricetable_fields SET title='{$value}' WHERE id={$key}";
		dbq($sql);
	}

}