<? require('tpl/header.php') ?>
		
		<div class="padding20px">
			<form class="login-form register-form" method="post" action="account/forgot_password/">
				<? if (isset($submit_status) && $submit_status === true) {  ?>
                <div class="form-success">
                    <h2 class="page-title">Password recovery request successful!</h2>
                    <p>Your request has been submitted to the administrator.<br />
					You will receive an email once your password is re-set by the administrator.</p>
                </div>
                <? } else { ?>
                    
                <h2 class="page-title">Recover Password</h2>
				<p class="messages" style="width:615px;">Please submit your NEC Account Number in order to recover your password.<br />
				Note: If you are a media personnel, please contact the administrator requesting login details</p>
                <? if ($this->validation->error_string != '') { ?>
                <div class="form-error">
                    <?= $this->validation->error_string ?>
                </div>
                <? } ?>
                <? if (isset($submit_status) && $submit_status === false) {  ?>
                <div class="form-notice">
                    <p class="field-error">A database error occured while submitting your details!</p>
                    <p class="field-error">Please contact the administrators regarding this error.</p>
                </div>
                <? } ?>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="140">
							<p>
								<label for="dealer_no">NEC Account Number:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="dealer_no" type="text" class="textfield width200px" id="dealer_no" value="" />
							</p>
						</td>
					</tr>
				</table>
				<p>
					<input type="image" src="./images/submit_button.gif?q=1" name="submit" value="submit &raquo;" />
				</p>
			</form>
                <? } ?>
		</div>
		
<? require('tpl/footer.php') ?>
