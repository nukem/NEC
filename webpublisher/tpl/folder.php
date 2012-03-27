<? require ("tpl/inc/head.php");

if($id == 124){
	// Set conditional sql
	$sqlstring = " where 1 = 1 ";
	if ($_POST['getuserid'] != "" and $_POST['getuserid'] != "Enter Dealer No."): $sqlstring .= " and dealer_no like '%{$_POST['getuserid']}%' "; endif;
	if ($_POST['getcompany'] != "" and $_POST['getcompany'] != "Enter Company"): $sqlstring .= " and company like '%{$_POST['getcompany']}%' "; endif;
	if ($_POST['getname'] != "" and $_POST['getname'] != "Enter Name"): $sqlstring .= " and name like '%{$_POST['getname']}%' "; endif;
	if ($_POST['gettelephone'] != "" and $_POST['gettelephone'] != "Enter Phone"): $sqlstring .= " and telephone like '%{$_POST['gettelephone']}%' "; endif;
	if ($_POST['getemail'] != "" and $_POST['getemail'] != "Enter Email"): $sqlstring .= " and email like '%{$_POST['getemail']}%' "; endif;
	if ($_POST['getstate'] != "" and $_POST['getstate'] != "Enter State"): $sqlstring .= " and state like '%{$_POST['getstate']}%' "; endif;
	
	$sql = "SELECT * FROM nec_users {$sqlstring}"; // WHERE category_fk <> 181";
	$dealers = dbq($sql);
	
	if(count($dealers) <= 0){
		$dealers = false;
	}

} else {
	$dealers = false;
}

echo '<!--' . print_r($path, true) . '-->';
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
				//require("tpl/inc/record_dealers.php");
			}
            
			require("tpl/inc/record.php");
			
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
				
			  }
			
			if($dealers){
			
			?>
			<tr>
				<td colspan="4">
                    
                    <? include ('tpl/inc/usermanagement.php') ?>
                    
					</td>
				</tr>
			<? } ?>
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
