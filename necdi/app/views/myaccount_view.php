<? require('tpl/header.php') ?>
    <style type="text/css">
	#login_main .textfield {
		margin-right:50px;
		margin-bottom:10px;
	}
	#login_main select.textfield {
		width:170px;
	}
	
	#point-balance {
		margin-top:15px;
	}
	
	h3.point-balance {
		font-size:14px;
		margin-bottom:12px;
	}
	h3.point-balance span {
		color:green;
	}
	.point-history-table, .point-history-table td, .point-history-table th {
		border-collapse:collapse;
		border:1px solid #666;
	}
	.point-history-table td, .point-history-table th {
		padding:4px;
	}
	.point-history-table th {
		background:#444;
	}
	</style>
		<div class="padding20px">
			<form class="login-form register-form" method="post" action="myaccount/">
			<? if (isset($update_status) && $update_status === true) {  ?>
                <div class="form-success">
                    <h2 class="page-title">Update Successful</h2>
                    <p>You have successfully updated your details.</p>
                    <? if ($this->input->post('update_password')) { ?>
                        <p>You have updated your password, please use the new password from this point onwards.</p>
                    <? } ?>
                </div>
                <p>&nbsp;</p>
            <? } ?>
                    
                <h2 class="page-title">Your Details</h2>
                <? if ($this->validation->error_string != '') { ?>
                <div class="form-error">
                    <?= $this->validation->error_string ?>
                </div>
                <? } ?>
                <? if (isset($update_status) && $update_status === false) {  ?>
                <div class="form-notice">
                    <p class="field-error">A database error occured while submitting your details!</p>
                    <p class="field-error">Please contact the administrators regarding this error.</p>
                </div>
                <? } ?>
				<table border="0" cellpadding="0" cellspacing="0" class="my-acc-table">
					<tr>
						<td width="140">
							<p>
								<label for="name">Full Name:</label>&nbsp;*&nbsp;</td>
							</p>
						</td>
						<td width="180">
							<p>
								<input name="name" type="text" class="textfield width200px" id="name" value="<?=$this->validation->name?>" />
							</p>
						</td>
						<td width="140">
							<p>
								<label for="company">Company Name:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td width="180">
							<p>
								<input name="company" type="text" class="textfield width200px" id="company" value="<?=$this->validation->company?>" />
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p>
								<label for="position">Position Held:</label>&nbsp;<span>*</span>&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="position" type="text" class="textfield width200px" id="position" value="<?=$this->validation->position?>" />
							</p>
						</td>
						<td>
							<p>
								<label for="telephone">Contact No:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="telephone" type="text" class="textfield width200px" id="telephone" value="<?=$this->validation->telephone?>" />
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p>
								<label for="dealer_no">NEC Account Number:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p>
								<?=$this->validation->dealer_no?><input name="dealer_no" type="hidden" id="dealer_no" value="<?=$this->validation->dealer_no?>" />
							</p>
						</td>
						<td>
							<p>
								<label for="email">Email Address:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="email" type="text" class="textfield width200px" id="email" value="<?=$this->validation->email?>" />
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="register-password">
								<label for="password">Password:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p class="register-password">
								<input name="password" type="password" class="textfield width200px" id="password" />
							</p>
						</td>
						<td>
							<p class="register-password">
								<label for="password_2">Confirm Password:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p class="register-password">
								<input name="password_2" type="password" class="textfield width200px" id="password_2" />
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p>
								<label for="address">Address:</label>&nbsp;<span>*</span>&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="address" type="text" class="textfield width200px" id="address" value="<?=$this->validation->address?>" />
							</p>
						</td>
						<td>
							<p>
								<label for="state">State:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p><?= $this->validation->state ?><input type="hidden" name="state" value="<?= $this->validation->state ?>" /></p>
						</td>
					</tr>
                    <tr>
						<td><label for="update_password">Update Password?</label> </td>
						<td><input type="checkbox" name="update_password" id="update_password"<? if ($this->input->post('update_password')) echo ' checked="checked"' ?> style="vertical-align:middle;" /> Tick here to update your password.</td>
                        <td colspan="2">&nbsp;
							
						</td>
					</tr>
                    <script type="text/javascript">
                    $(function(){
                        if ( $('#update_password').is(':not(:checked)') ) {
                            $('.register-password').hide();
                        }
                    });
                    $('#update_password').click(function(){
                        if ( $(this).is(':checked') ) {
                            $('.register-password:not(:visible)').slideDown();
                        } else {
                            $('.register-password:visible').slideUp();
                        }
                    });
                    </script>
				</table>
				<p>To update your details, click the submit button.</p>
				<input type="image" src="./images/submit_button.gif?q=1" name="submit" value="submit &raquo;" />
			
			</form>
			
			<div id="point-balance">
				<h2 class="page-title">Your Points</h2>
				<h3 class="point-balance">Your current point balance is <span><?php echo $points['balance'] ?></span> points.</h3>
				<p>If you wish to see further detail regarding
your points allocation, please contact Michelle Hancox on
<a href="mailto:michelle.hancox@nec.com.au">michelle.hancox@nec.com.au</a>.</p>
				<?php
				if ($points['html'] != '')
				{
					?>
					<h4>Point transaction history</h4>
					<table border="0" cellpadding="0" cellspacing="0" class="point-history-table" width="590">
						<thead>
							<th width="145">Type</th>
							<th>Debits</th>
							<th>Credits</th>
							<th width="120">Date</th>
							<th>Details</th>
						</thead>
						<tbody>
							<?php echo $points['html'] ?>
						</tbody>
					</table>
					<?php
				}
				?>
			</div>
			
		</div>
<? require('tpl/footer.php') ?>
