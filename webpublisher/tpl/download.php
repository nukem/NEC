<? require ("tpl/inc/head.php"); ?>

<?php

$files = dbq("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_download
	WHERE link = id
	AND online = 1
	AND parent = $id
	ORDER BY file_type ASC");

?>

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

				<tr>
					<td colspan="4">
					Notice: if is not a file, then system would use url instead, also show remove button instead of delete.
				<?php
				$file_type = '';
				if($files){
				
				echo '<table>'."\n";
					
					foreach($files as $file){
						
						if($file['file_type'] != $file_type && is_file($cfg['data'].$file['title'].".".$file['extension'])){
							echo '<tr><td colspan="2" style="padding-top: 10px;"><label>'.$file['file_type'].'</label></td></tr>';
						}
						
						$file_type = $file['file_type'];
						
						echo '<tr><td style="width: 260px;">'."\n";
						
						if(is_file($cfg['data'].$file['title'].".".$file['extension'])){ ?>
							<p><img src="img/ico-file/<? if(is_file("img/ico-file/{$file['extension']}.gif")) echo "{$file['extension']}.gif"; else echo "unknown.gif"; ?>" alt="Preview" width="16" height="16" /> <a href="file-preview.php?file=<?= $file['title'].'.'.$file['extension'] ?>&amp;filename=<?= $file['title'] . "." . $file['extension'] ?>"><?= $file['file_name'] ?></a></p>
						<?
							
							echo '</td>'."\n".'<td>';
							
							echo '<a href=".?id='.$_GET['id'].'&amp;deleteUpload=true&amp;deleteFile='.$file['uri'].'&amp;deleteExt='.$file['extension'].'" onClick="return confirm(\'Are you sure?\');">Delete</a>'."\n";
							
							echo '</td></tr>'."\n";
						}
					}
				
				echo '</table>'."\n";
				
				} else {
				
					echo '<p>No files were found</p>';
				
				}
				
				require("tpl/inc/upload.php");
				?>
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
