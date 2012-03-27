<? require ("tpl/inc/head.php"); ?>
<body> 
<div id="page"> 
  <? require ("tpl/inc/header.php"); ?> 
  <? require ("tpl/inc/path.php"); ?> 
  <div id="content"> 
    <div id="left-col"> 
      <div id="left-col-border"> 
        <? if (isset ($errors)) require ("tpl/inc/error.php"); ?> 
        <? if (isset ($messages)) require ("tpl/inc/message.php"); ?> 
        <? if (isset ($_SESSION['epClipboard'])) require ("tpl/inc/clipboard.php"); ?> 
        <? require ("tpl/inc/structure.php"); ?> 
      </div> 
    </div> 
    <div id="right-col"> 
      <h2 class="bar green"><span><?= $lang[69] ?></span></h2> 
      <form action=".?id=<?= $id ?>" method="post"> 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
            <?
			
			require("tpl/inc/record.php");
			?>
			<tr>
				<td colspan="4">
					<label>Slide Title &bull; (<span id="limit-25"></span> characters left)</label><br />
					<input type="text" id="limit-25-key" name="dyk_title" class="textfield width-100pct" value="<?php if (isset($_POST['title'])) echo htmlentities($_POST['dyk_title']); else echo $record['dyk_title'] ?>" maxlength="25" />
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<label>Slide Copy &bull; (<span id="limit-100"></span> characters left) </label><br />
					<input type="text" id="limit-100-key" name="dyk_copy" class="textfield width-100pct" value="<?php if (isset($_POST['title'])) echo htmlentities($_POST['dyk_copy']); else echo $record['dyk_copy'] ?>" maxlength="200" />
				</td>
			</tr>
			<?
			require ("tpl/inc/rights.php");
			
			?>
            </table> 
          </div> 
        </div> 
      </form> 
    </div>
    <? require ("tpl/inc/footer.php"); ?> 
  </div> 
</div>

<script type="text/javascript" src="http://www.nec-cds.com.au/includes/js/jquery.js" language="javascript"></script>
<script type="text/javascript">
$(function(){
	$('#limit-25-key').keyup(function(){
		var desc_len = $(this).val();
		
		if (desc_len.length > 25) {
			$(this).val(desc_len.substring(0, 25));
		}
		
		var remain_len = 25 - desc_len.length;
		if (remain_len < 0) remain_len = 0;
		
		$('#limit-25').text(remain_len);
	});
	
	$('#limit-100-key').keyup(function(){
		var desc_len = $(this).val();
		
		if (desc_len.length > 200) {
			$(this).val(desc_len.substring(0, 200));
		}
		
		var remain_len = 200 - desc_len.length;
		if (remain_len < 0) remain_len = 0;
		
		$('#limit-100').text(remain_len);
	});
	
	$('#limit-25-key, #limit-100-key').keyup();
});
</script>


</body>
</html>
