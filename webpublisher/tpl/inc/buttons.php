<p class="buttons">
	<?
	if (ereg ("({$user['parent']})", $record['editRights']) || $id == 0)
	{
		if ($id != 0)
		{
		?>
			<input type="checkbox" name="online" id="online" value="1"<? if (isset ($_POST['online']) || (! isset ($_POST['title']) && $record['online'] == 1)) echo ' checked="checked"'; ?> />&nbsp;<label for="online">Online</label>&nbsp;
		<?
		}
		?>
		<input type="submit" name="save" value="Save" class="button" onclick="validateTitle();" /> &nbsp;
	<?
	}

	/* ---------------------------------- */
	
	if (ereg ("({$user['parent']})", $record['createRights']) && $record['type'] != 'user')
	{
		$createType = array();
			
			switch ($record['type']){
				case 'range': // Inside a product category
					$createType[] = array('model', 'New Product Model');
					break;
				case 'model': // Inside a product category
					$createType[] = array('image', 'New Image');
					break;
				case 'folder': // Inside a folder
					if ($record['parent'] != 71 && $record['id'] != 124 && $record['id'] != 71) {
						$createType[] = array('folder', 'New Folder');
						$createType[] = array('article', 'New Article');
						$createType[] = array('image', 'New Image');
						$createType[] = array('file', 'New File');
						if (isset($path[2]) && isset($path[3]) && $path[2][0] == 89) {
							$createType[] = array('press', 'New Press Release');
						}
					}
					break;
				case 'article': // Inside an article
					$createType[] = array('image', 'New Image');
					$createType[] = array('file', 'New File');
					if ($path[1][0] == 81) {
						$createType[] = array('hi_res', 'Hi Resolution Image');
					}
					break;
				case 'press': // Inside press release
					$createType[] = array('file', 'New File');
					break;
				case 'prize': // Inside press release
					$createType[] = array('image', 'New Image');
					break;
					
			}
			
			switch ($record['id']){
				case 71: // Technical library
					$createType[] = array('folder', 'New Product Category');
					break;
				case 124: // User categories
					$createType[] = array('nec_cat', 'New User Category');
					break;
				case 3029:
					$createType[] = array('dyk', 'New Did you know? Slide');
					break;
			}
			
			switch ($record['parent']){
				case 1: // Inside users
					$createType[] = array('user', 'New User');
					break;
				case 71: // Inside technical libary
					$createType[] = array('range', 'New Product Subcategory');
					$createType[] = array('model', 'New Product Model');
					$createType[] = array('folder', 'New Folder');
					$createType[] = array('article', 'New Article');
					break;
				case 3858: // in prize pool
					$createType[] = array('prize', 'New Prize');
					break;
			}
			
			if ($record['id'] == 0) {
				$createType[] = array('folder', 'New Folder');
			}
			
			if (count($createType)) {
				
				?> 
				<select name="createType" class="textfield">
				
				<?php
				
				
					foreach($createType as $k => $v){			
						echo '<option value="'.$v[0].'">'.$v[1].'</option>';
					}
				
				?>
		
				</select>
				
				<?
				if($record['type'] != 'webuser')
				{
				?>
					<select name="times" class="textfield">
						<?
						for ( $i = 1; $i <= 15; $i ++ ) 
						{
						?>
							<option value="<?=$i?>"><?=$i?></option>
						<?
						}
						?>
					</select>
					
					<input type="hidden" name="currid" value="<?php if( isset($record['id']) ) { echo $record['id']; }else{ echo '0'; } ?>" />
					<input type="submit" name="create" value="<?= $lang[26] ?>" class="button" /> 
				<?
				}
				
			}
			
		if (isset ($_SESSION['epClipboard']) && $record['parent'] != 1 && $id != 1 && $id != 0)
		{
		?>
			<input type="submit" name="paste<? if (isset($_SESSION['clipboardCopy']) && $_SESSION['clipboardCopy'] === true) echo 'Copy' ?>" value="<?= $lang[27] ?>" class="button" /> 
		<?
		}
	}
  
	/* ---------------------------------- */

	if (ereg ("({$user['parent']})", $record['deleteRights']))
	{
		if (! isset ($_SESSION['epClipboard']) && $record['type'] != 'user' && $record['parent'] != 1 && $id != 1)
		{
		?>
			<input type="submit" name="cut" value="Cut" class="button" /> 
			<?
			if ($record['type'] == 'article')
			{
			?>
				<input type="submit" name="copy" value="Copy" class="button" /> 
			<?
			}
		}
		?>
		<input type="submit" name="delete" value="Delete" class="button" onclick="if (! window.confirm ('<?= $lang[31] ?>')) return (false);" /> 
	<?
	}
	?> 
</p>
<script type="text/javascript">
function validateTitle() {
	if (document.forms[0].title.value.replace(/^\s+/, '').replace(/\s+$/, '') == '') {
		alert('Please enter a title');
		document.forms[0].title.focus();
		return false;
	} else {
		return true;
	}
}
</script>
