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
                  <input type="file" name="fileId" />
				</td>
				<td>
				<label><input name="newdoc" type="checkbox" id="newdoc" value="1"<? if(isset($_POST['newdoc']) || $record['newdoc'] == 1) echo ' checked="checked"'; ?> />New Document</label>
				</td>
                <td><label><?= $lang[67] ?></label><br />
              <? if (is_file ($cfg['data'] . $id . "." . $record['extension'])) { ?> 
                  <img src="img/ico-file/<? if (is_file ("img/ico-file/{$record['extension']}.gif")) echo "{$record['extension']}.gif"; else echo "unknown.gif"; ?>" alt="Preview" width="16" height="16" /> <a href="file-preview.php?file=<?=  $id . '.' . $record['extension'] ?>&amp;filename=<?= $record['uri'] . "." . $record['extension'] ?>"><?= $record['uri'] . "." . $record['extension'] ?></a>
              <? } else { ?>
                  <?= $lang[68] ?>
              <? } ?>
			    </td>
              </tr> 
			  <tr>
			     <td colspan="4">
				    <label>File Can Be Accessed By:</label><br />
					<?
					$webUsers = dbq ("SELECT `id`, `title` FROM {$cfg['db']['prefix']}_folder, {$cfg['db']['prefix']}_structure WHERE link = id AND online = 1 AND parent = 44 ORDER BY position");
					$webAccess = dbq ("SELECT * FROM {$cfg['db']['prefix']}_access WHERE link = $id");
					$wac[$id] = array();
					
					if(isset($webAccess) && is_array($webAccess) && count($webAccess) > 0) foreach($webAccess as $wa)
					{
						$wac[$id][] = $wa['access'];
					}
					
					?>
					<div id="webUsersCategories">
						<?
						/*if(isset($wuc))
						{
							print_r($wuc);
						}*/							
						if(isset($webUsers) && is_array($webUsers) && count($webUsers) > 0) foreach ($webUsers as $wuc)
						{
						?>
							<label><input name="wuc[]" type="checkbox" id="wuc[]" value="<?=$wuc['id']?>"<? if(in_array($wuc['id'], $wac[$id])) echo ' checked="checked"'; ?> /><?=$wuc['title']?></label>&nbsp;&nbsp;
						<?
						}
						?>
					</div>
				 </td>
			  </tr>
			  <tr>
			    <td colspan="4">
				  <label>Information About file</label>
				  <br />
				  <textarea name="info" rows="10" class="textfield width-100pct" id="info"><?=$record['info']?></textarea>
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
