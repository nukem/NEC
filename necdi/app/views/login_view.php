<? require ('tpl/header.php'); ?>
<style type="text/css">
.textfield {
	width:160px;
}
.td label {
	display:block;
	text-align:right;
}
#login_message {
	height:auto;
}
#login_message .bigger {
	font-size:12px;
	padding-bottom:10px;
}
#login_message a {
	text-decoration:none;
	border-bottom:1px solid #5cf;
	color:#5cf;
}
#login_message a:hover {
	color:#5af;
}
</style>
				<form action="./userlogin" method="post" class="login_form">
					<table class="login" cellpadding="0" cellspacing="0">
						<tr>
							<td class="label" width="110" align="right"><label for="username">Login</label></td>
							<td class="input"><input type="text" name="username" class="textfield" id="username" /></td>
							<td rowspan="2" class="message_holder">
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
						<tr>
							<td class="label" align="right"><label for="password">Password</label></td>
							<td class="input"><input type="password" name="password" class="textfield" id="password" /></td>
						</tr>
						<tr>
							<td></td>
							<td class="align_right"><input type="image" src="./images/submit_button.gif?q=1" name="submit" value="submit &raquo;" /></td>
							<td></td>
						</tr>
					</table>
				</form>
			<div id="login_message">
				<h3>Don't have a Login?</h3>
                <p class="bigger">If you do not have a login, you need to obtain one by <a href="account/register">registering for an account</a>.</p>
                <p>If you have an account, but have forgotton your password, <a href="account/forgot_password">request a new password</a>.</p>
				
			</div><!-- Close login_message -->
<? require ('tpl/footer.php'); ?>
