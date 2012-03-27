				<tr>
					
					
					<td><label>File Type</label><br />
						<select name="fileType" class="textfield width-100pct">
						<?php
						
						$options = array(
							'false'								=>		'Select a category...',
							'Brochure'							=>		'Brochure',
							'Structural Drawing'				=>		'Structural Drawing',
							'Driver'							=>		'Driver',
							'RS232 Protocol'					=>		'RS232 Protocol',
							'Installation & How-To Guide'		=>		'Installation &amp; How-To Guide',
							'User Manual'						=>		'User Manual',
							'High Resolution Image'				=>		'High Resolution Image'
						);
						
						foreach($options as $option => $value){
							echo '<option value="'.$option.'"';
							if(isset($_POST['fileType']) && $_POST['fileType'] == $option){
								echo ' selected';
							}
							echo '>'.$value.'</option>'."\n";
						}
						
						?>
						</select>
					</td>
					<td><label>File Name</label><br />
						<input type="text" name="fileName" class="textfield width-100pct" value="<?php if(isset($_POST['fileName'])){ echo $_POST['fileName']; } ?>"/>
						<input type="hidden" name="parent_id" value="<?= $id ?>" />
					</td>
					
					<td colspan="1"><label>File</label><br />
						<input type="file" name="fileId" class="textfield width-100pct" />
					</td>
					<td colspan="1"><label>Ultimately, You may just type in url</label><br />
						<input type="text" name="fileuri" class="textfield" style="width:300px" />
					</td>
				</tr>