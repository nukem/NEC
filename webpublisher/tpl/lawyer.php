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
      <h2 class="bar green"><span><?= $lang[58] ?></span></h2> 
      <form action=".?id=<?= $id ?>" method="post" enctype="multipart/form-data" > 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <? require ("tpl/inc/record.php"); ?>
			  <tr>
				  <td colspan="2">
					<label>Job Title &bull;</label><br />
					<input type="text" name="jobTitle" class="textfield width-100pct" value="<? if (isset ($_POST['jobTitle'])) echo htmlspecialchars ($_POST['jobTitle']); else echo htmlspecialchars ($record['jobTitle']); ?>" />
				  </td>
			
				  <td colspan="2">
				  </td>
			  </tr>
			  
			  <tr>
				<td colspan="2">
				  <label>Qualifications</label>
				  <textarea name="qualifications" class="textfield width-100pct"><? if (isset($_POST['qualifications'])) echo htmlspecialchars ($_POST['qualifications']); else echo htmlspecialchars ($record['qualifications']); ?></textarea>
				</td>
				
				<td colspan="2">
				  <label>Area of practice</label>
				  <textarea name="practice" class="textfield width-100pct"><? if (isset($_POST['practice'])) echo htmlspecialchars($_POST['practice']); else echo htmlspecialchars($record['practice']); ?></textarea>
				</td>
			</tr>
			
			
			  
			  
              <tr> 
                <td colspan="4"> 
				<label><?= $lang[59] ?></label><br />
         <textarea name="content" cols="30" rows="15" class="textfield width-100pct tinymce"><? if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['content']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['content'])); ?></textarea>
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
</body>
</html>
