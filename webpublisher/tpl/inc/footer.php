<hr />
<div id="footer"> 
  <p class="left"><?= $lang[75] ?></p> 
  <p class="right"><?= $lang[77] ?> &copy; 2005 - <?= date ('Y') ?></p> 
</div>	
<? if (isset($record) && $record['type'] == 'image') { ?>
<script type="text/javascript">
document.forms[0].onsubmit = function() {
	var el = document.forms[0].existing_wp_image;
	var re = new RegExp("^\.\./wpdata/([0-9]+)-(l|m|s)\.jpg$");
	if (el.value != '' && !re.test(el.value)) {
		alert('Incorrect upload link format!\nPlease copy and paste the value from\n"Image Location" field.');
		el.focus();
		return false;
	}
}
</script>
<? } ?>