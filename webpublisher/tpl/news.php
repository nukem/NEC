<? require ("tpl/inc/head.php"); ?>
<body> 
<script type="text/javascript" language="javascript" src="../includes/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../includes/js/date.js"></script>
<script type="text/javascript" language="javascript" src="../includes/js/date-picker.js"></script>
<style type="text/css">
@import url(../includes/css/date-picker.css);
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
      <h2 class="bar green"><span><?= $lang[58] ?></span></h2> 
      <form action=".?id=<?= $id ?>" method="post" enctype="multipart/form-data" > 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <? require ("tpl/inc/record.php"); ?> 
				<tr>
                	<td colspan="2">
                    <label>Published date</label><br />
                    <input type="text" name="press_date" class="textfield width-100pct date-pick" />
                    </td>
                    <td colspan="2">&nbsp;</td>
                </tr>
              <tr> 
                <td colspan="4"> 
				<label><?= $lang[59] ?></label><br />
         <textarea name="content" cols="30" rows="15" class="textfield tinymce width-100pct"><? if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['content']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['content'])); ?></textarea>
                </td> 
              </tr>
              <? require ("tpl/inc/rights.php"); ?> 
            </table> 
          </div> 
        </div> 
      </form> 
    </div> 
    <? require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
<script type="text/javascript">
$(document).ready(function(){
	Date.format = 'dd mmm yyyy';
	if($.browser.msie){
		$('.date-pick').datePicker({startDate:'2007-01-01'}).dpSetOffset(0, -275);
	}else{
		$('.date-pick').datePicker({startDate:'2007-01-01'});
	}
});
</script> 
</body>
</html>
