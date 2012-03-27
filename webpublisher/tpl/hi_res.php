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
      <h2 class="bar green"><span><?= $lang[65] ?></span></h2> 
      <form action=".?id=<?= $id ?>" method="post" enctype="multipart/form-data"> 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <? require ("tpl/inc/record.php"); ?> 
              <tr> 
                <td colspan="2"><label><?= $lang[66] ?> &bull;</label><br /> 
                  <input type="file" name="fileId" /></td> 
                <td colspan="2"><label><?= $lang[67] ?></label><br />
              <? if (is_file ($cfg['data'] . $id . "." . $record['extension'])) { ?> 
                  <img src="img/ico-file/<? if (is_file ("img/ico-file/{$record['extension']}.gif")) echo "{$record['extension']}.gif"; else echo "unknown.gif"; ?>" alt="Preview" width="16" height="16" /> <a href="file-preview.php?file=<?=  $id . '.' . $record['extension'] ?>&amp;filename=<?= $record['uri'] . "." . $record['extension'] ?>"><?= $record['uri'] . "." . $record['extension'] ?></a>
              <? } else { ?>
                  <?= $lang[68] ?>
              <? } ?>
			    </td>
              </tr>
			  <tr> 
                <td colspan="2"><label>Sample Image</label><br /> 
                  <input type="file" name="fileImageId" /></td> 
                <td colspan="2"><label>Sample Image Preview</label><br /> 
              <? if (is_file ($cfg['data'] . $id . "-s.jpg")) { ?> 
                  <a href="image-preview.php?image=<?= $cfg['data'] . $id ?>-l.jpg&amp;id=<?= $id ?>&amp;title=<?= urlencode ($record['title']) ?>" class="border" onClick="window.open (this.href, '', '<?= get_js_size ($cfg['data'] . $id . "-l.jpg", 10) ?>'); return (false);"><img src="<?= $cfg['data'] . $id ?>-s.jpg" alt="Preview" <?= get_html_size ($cfg['data'] . $id . "-s.jpg") ?> /></a> 
              <? } else { ?> 
                  <?= 'No Sample Image Found!' ?>
              <? } ?>
			    </td>
              </tr>
              <tr>
              	<td colspan="2"><label>Link to this file</label><br />
                <input type="text" name="linktothis" class="textfield width-100pct" value="<? if (is_file ($cfg['data'] . $id . '.' . $record['extension'])) echo "http://www.nec-cds.com.au/webpublisher/file-preview.php?file={$id}.{$record['extension']}&amp;filename={$record['uri']}.{$record['extension']}" ?>" onClick="this.value.select()" />
                </td>
                <td colspan="2"><label>Image Location</label><br />
                <input type="text" name="linktothis" class="textfield width-100pct" value="<? if (is_file ($cfg['data'] . $id . "-l.jpg")) echo "{$cfg['data']}{$id}-l.jpg" ?>" onClick="this.value.select();" />
                <label style="font-weight:normal; width:300px; display:block;">Use this field data to upload this sample image as a new image within WebPublisher.</label>
                </td>
              </tr>
              <? if (is_file ($cfg['data'] . $id . '.' . $record['extension'])) { ?>
              <tr>
              	<td colspan="4" align="left">
                	<input type="button" value="Duplicate this file" onclick="duplicateFile();" />
                </td>
              </tr>
              <? } ?>
              <? require ("tpl/inc/rights.php"); ?> 
            </table> 
          </div> 
        </div> 
      </form> 
		<? if (is_file ($cfg['data'] . $id . '.' . $record['extension'])) { ?>
        <script type="text/javascript" language="javascript" src="../includes/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../includes/js/blockui.v2.js"></script>
        <script type="text/javascript">
        function duplicateFile() {
        	$.getJSON(
				'duplicate_hi_res.php',
				{fileid: '<?= $id ?>', extension : '<?= $record['extension'] ?>', parent: '<?= $record['parent'] ?>'},
				function(data){
					if (data.error == false) {
						document.location = '?id=' + data.newID;
					} else {
						alert(data.errorMsg);
					}
				}
			);
        }
        </script>
        <? } ?>
    </div> 
    <? require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
