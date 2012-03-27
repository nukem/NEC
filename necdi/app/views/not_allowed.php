<? require ('tpl/header.php'); ?>

					<table class="login" cellpadding="0" cellspacing="0">
						<tr>
							<td class="message_holder">
								<?php
								$errors = $this->session->flashdata('system_errors');
								if(is_array($errors) && count($errors) > 0 ){
								?>
								<div class="error_message">
								<?php
									$i = 0;
									foreach($errors as $error){
										if($i == 0){
											echo '<h4>'.$error.'</h4>'."\n";
										} else {
											echo '<p>'.$error.'</p>'."\n";
										}
										$i++;
									}
								?>
								</div><!-- Close error_message -->
								<?php
								}
								$messages = $this->session->flashdata('system_messages');
								if(is_array($messages) && count($messages) > 0){
								?>
								<div class="messages">
								<?php
									$i = 0;
									foreach($messages as $message){
										if($i == 0){
											echo '<h4>'.$message.'</h4>'."\n";
										} else {
											echo '<p>'.$message.'</p>'."\n";
										}
										$i++;
									}
								?>
								</div><!-- Close messages -->
								<?php
								}
								?>
							</td>
						</tr>
					</table>

<? require ('tpl/footer.php'); ?>