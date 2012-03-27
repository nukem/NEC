<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $lang[0] ?></title>
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen,projection" />
<link rel="stylesheet" href="/includes/css/jquery.popover.css" type="text/css" media="screen,projection" />
<? if(isset($loadMCE)){ ?>
<script type="text/javascript" src="tinymce/tiny_mce.js"></script>
<script type="text/javascript">
<!--
tinyMCE.init({
	mode: "specific_textareas",
	editor_selector : "tinymce",
	plugins: "table, paste",
	theme: "advanced",
	doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
	fix_list_elements: true,
	width: "100%",
	theme_advanced_blockformats: "p,h2,h3,h4,h5,h6",
	theme_advanced_toolbar_location: "top",
	theme_advanced_toolbar_align: "left",
	theme_advanced_buttons1: "formatselect, bold, italic, strikethrough, justifyleft, justifycenter, justifyright, indent, outdent, bullist, numlist, image, sub, link, unlink, forecolor, charmap, cleanup, code, removeformat ",
	theme_advanced_buttons2: "table, row_props, row_before, row_after, col_before, col_after, delete_row, delete_col, split_cells, merge_cells, pastetext,pasteword,selectall",
	theme_advanced_buttons3: ""
	
});
-->
</script>
<? } ?>
<script type="text/javascript">
<!--
function keepAlive() {
    var imgAlive = new Image();
    var date = new Date();
    imgAlive.src = 'keepalive.php?date=' + date.getTime();
}

setInterval("keepAlive()", 60*1000);
-->
</script>
<style type="text/css">
a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 2px 0 3px 3px;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
	background: url(img/calendar.png) no-repeat; 
}
a.dp-choose-date.dp-disabled {
	background-position: 0 -20px;
	cursor: default;
}
/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
	width: 140px;
	float: left;
}
</style>
</head>
