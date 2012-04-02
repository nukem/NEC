<?php
require ("tpl/inc/head.php");
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
      <h2 class="bar green"><span><?= $lang[69] ?></span></h2> 
      <form action=".?id=<?= $id ?>" method="post"> 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
            <?php
			if($record['id'] == 124){
				echo '<style type="text/css">'."\n";
				?>
					.rights {
						display: none;
					}
				<?
				echo '</style>'."\n";
				
			}
            
			require("tpl/inc/pricebook_fields.php");
			
			require ("tpl/inc/rights.php");

			if($record['id'] != 1 && $path[1][0] != 238 && $path[1][0] != 124 && count($path) < 4) {
			
			?>
			  	<tr>
				<td colspan="4"><label>Accessibility</label></td>
				</tr>
			<?php 
				$count = 0;
				
				foreach($permissions as $perm){
				
					if(!($count % 4)){
						echo '<tr>'."\n";
					}
					
					echo '<td><input type="checkbox" name="permissions[]" value="'.$perm['link'].'"';
					
					if(in_array($perm['link'], $accesseses)){
						echo 'checked="checked"';
					}
					
					echo ' />'.$perm['title'].'</td>'."\n";
					
					if(!(($count + 1) % 4) && $count  != 0){
						echo '</tr>'."\n";
					}
					
					$count++;
					
				}
				
				if($count % 4){ echo '</tr>'; }
				
			  }?>
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