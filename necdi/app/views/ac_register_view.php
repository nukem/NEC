<? require('tpl/header.php') ?>
    <style type="text/css">
	.textfield {
		margin-right:50px;
		margin-bottom:4px;
	}
	select.textfield {
		width:240px;
	}
    .register-table td {
        padding-bottom:8px;
    }
	.highlight {
		color:crimson;
	}
	.field-error {
		border-color:#FF3366;
	}
	</style>
<script type="text/javascript">
function validateForm() {
    
    var fdata = {
		'name' : ['[a-z]+', 'Name is a required field'],
		'company' : ['[a-z0-9]+', 'Company is a required field'],
		'position' : ['[a-z0-9]+', 'Position is a required field'],
		'telephone' : ['^[0-9 \-]+$', 'Contact Number is required and should only contain numbers, spaces or dashes'],
		'email' : ['^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$', 'Valid email address is required'],
		'address' : ['[a-z]+', 'Postal address is a required field'],
		'postcode' : ['[0-9]{4}', 'Valid Postcode required']
		
	};
    
    if($('input[@name="ac_confirm"]:checked').val() == 'y'){
	fdata['dealer_no'] = ['[a-z0-9]+', 'NEC Account Number is required'];
    }
    if($('input[@name="ac_confirm"]:checked').val() == 'n'){
	fdata['relationship'] = ['[a-z0-9]+', 'Relationship with NEC is a required field'];
	fdata['reason'] = ['[a-z0-9]+', 'Reason requiring access is a required field'];
	fdata['referee'] = ['[a-z0-9]+', 'Who referred you to this site is a required field'];
	fdata['username'] = ['[a-z0-9]+', 'user name is a required field'];
    }
	
	var errors = [];
	var errorFld;
	
	var j = 0;
	
	for (var i in fdata) {
		var re = new RegExp(fdata[i][0], 'i');
		if (!re.test($('#'+i).val())) {
			$('#'+i).addClass('field-error');
			errors.push(fdata[i][1]);
			if (j == 0) errorFld = i;
			j++;
		} else {
			$('#'+i).removeClass('field-error');
		}
		
	}
	
	if ($('#state').val() == "Select your state") {
		errors.push('State must be selected');
		$('#state').addClass('field-error');
	} else {
		$('#state').removeClass('field-error');
	}
	
	if ($('#name').val().length > 15) {
		errors.push('Name length should no more than 15 characters');
		$('#name').addClass('field-error');
	} else {
		$('#name').removeClass('field-error');
	}
	
	if($('input[@name="ac_confirm"]:checked').val() != 'y' && $('input[@name="ac_confirm"]:checked').val() != 'n'){
	    errors.push('Your account type must be specified');
	}
	
    if($('input[@name="ac_confirm"]:checked').val() == 'y'){
	var pass1 = /[0-9]+/.test($('#password').val());
	var pass2 = /[a-z]+/i.test($('#password').val());
	var pass3 =  ($('#password').val().length < 6) ? false : true;
	
	if (pass1 && pass2 && pass3) {
		$('#password').removeClass('field-error');
	} else {
		errors.push('Password must be at leaset 6 characters long and must include both letters and numbers');
		$('#password').addClass('field-error');
	}
	
	if ($('#password').val() != $('#password_2').val()) {
		errors.push('Password confirmation must match with password.');
		$('#password_2').addClass('field-error');
	} else {
		$('#password_2').removeClass('field-error');
	}
	
    }
    if($('input[@name="ac_confirm"]:checked').val() == 'n'){
	var pass4 = /[0-9]+/.test($('#password_3').val());
	var pass5 = /[a-z]+/i.test($('#password_3').val());
	var pass6 =  ($('#password_3').val().length < 6) ? false : true;
	
	if (pass4 && pass5 && pass6) {
		$('#password_3').removeClass('field-error');
	} else {
		errors.push('Password must be at leaset 6 characters long and must include both letters and numbers');
		$('#password_3').addClass('field-error');
	}
	
	if ($('#password_3').val() != $('#password_4').val()) {
		errors.push('Password confirmation must match with password.');
		$('#password_4').addClass('field-error');
	} else {
		$('#password_4').removeClass('field-error');
	}
	
    }
    
    if (errors.length > 0) {
	
	    $('#'+errorFld).focus();
	    alert(errors.join('\n'));
	    return false;
	    
    } else {
    
	    return true;
	    
    }
}

$(function(){
    $('#account-holder, #no-account').hide();
    $('input[@name="ac_confirm"]').click(function(){
	if ($(this).val() == 'y') {
	    $('#no-account:visible').slideUp(400);
	    $('#account-holder:hidden').slideDown(400);
	} else {
	    $('#no-account:hidden').slideDown(400);
	    $('#account-holder:visible').slideUp(400);
	}
    });
})
</script>
		<div class="padding20px">
			<form class="login-form register-form" method="post" action="account/register/<?= $this->uri->segment(3) ?>" onsubmit="return validateForm();">
			<? if (isset($submit_status) && $submit_status === true) {  ?>
                <div class="form-success">
                    <h2 class="page-title">Initial Registration Successful</h2>
                    <p>Thank you for registering for an account with the NEC Dealer Intranet<br />Your registration has been submitted through to the administrator of this site.</p>
                    <p>You will be notified via email, once your account is approved by the administrator.</p>
                </div>
            <? } else { ?>
                    <? if (isset($update_status) && $update_status === true) { ?>
                    <div class="form-success">
                        <p>User successfully updated</p>
                    </div>
                    <? } ?>
                    <?
                    $the_heading = 'Register';
                    ?>
                <h2 class="page-title"><?= $the_heading ?></h2>
				<p class="messages" style="margin-bottom:15px;">[ * ] Denotes a require field<br />Please note that the registrations are only available for authorised dealers with active accounts with NEC Commercial Display Solutions Division.</p>
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
		<p>Register your details to obtain access to the Intranet</p><br />
		<div>
				<table border="0" cellpadding="0" cellspacing="0" class="register-table">
					<tr>
						<td width="220">
							<p>
								<label for="name">Full Name:</label>&nbsp;*&nbsp;</td>
							</p>
						</td>
						<td width="270">
							<p>
								<input name="name" type="text" class="textfield width200px" id="name" value="<?=$this->validation->name?>" />
							</p>
						</td>
						<td width="220">
							<p>
								<label for="company">Company Name:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td width="270">
							<p>
								<input name="company" type="text" class="textfield width200px" id="company" value="<?=$this->validation->company?>" />
							</p>
						</td>
					</tr>
					<tr>
						<td width="220">
							<p>
								<label for="position">Position Held:</label>&nbsp;<span>*</span>&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="position" type="text" class="textfield width200px" id="position" value="<?=$this->validation->position?>" />
							</p>
						</td>
						<td width="220">
							<p>
								<label for="telephone">Contact Telephone No:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="telephone" type="text" class="textfield width200px" id="telephone" value="<?=$this->validation->telephone?>" />
							</p>
						</td>
					</tr>
					
					<tr>
						<td width="220">
							<p>
								<label for="email">Email Address:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="email" type="text" class="textfield width200px" id="email" value="<?=$this->validation->email?>" />
							</p>
						</td>
						<td width="220">
							<p>
								<label for="address">Postal Address:</label>&nbsp;<span>*</span>&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="address" type="text" class="textfield width200px" id="address" value="<?=$this->validation->address?>" />
							</p>
						</td>
					</tr>
					<tr>
						<td width="220">
							<p>
								<label for="state">State:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p>
								<select name="state" class="textfield width200px" id="state">
								<? $states = array("Select your state", "NSW", "VIC", "QLD", "ACT", "WA", "SA", "NT", "TAS");
								foreach ($states as $state) { ?>
									<option value="<?= $state ?>"<?= ($this->validation->state == $state) ? ' selected="selected"' : '' ?>><?= $state ?></option>
								<? } ?>
							</p>
						</td>
						<td width="220">
							<p>
								<label for="postcode">Postcode:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p>
								<input name="postcode" type="text" class="textfield width200px" id="postcode" value="<?=$this->validation->postcode?>" />
							</p>
						</td>
					</tr>
				</table>
		</div>
			
				<!--<p>Register your details to obtain an account for the Intranet</p>-->
				<p>
				    <label for="confirmation">Do you have a direct account with NEC Display Solutions?</label>
				    <input type="radio" name="ac_confirm" value="y"<? if (isset($_POST['ac_confirm']) && $_POST['ac_confirm'] == 'y') echo ' checked="checked"'; ?>> Yes
				    <input type="radio" name="ac_confirm" value="n"<? if (isset($_POST['ac_confirm']) && $_POST['ac_confirm'] == 'n') echo ' checked="checked"'; ?>> No
				</p>
			<br />
			<div id="account-holder">
			    <table border="0" cellpadding="0" cellspacing="0" class="register-table">
			    <tr>
						<td width="220">
							<p>
								<label for="dealer_no">Please enter your NEC Account Number: </label>&nbsp;*&nbsp;
							</p>
						</td>
						<td width="270">
							<p>
								<input name="dealer_no" type="text" class="textfield width200px" id="dealer_no" value="<?=$this->validation->dealer_no?>" />
							</p>
						</td>
			    </tr>
			    <tr>
						<td width="220">
							<p class="register-password">
								<label for="password">Please select a password:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p class="register-password">
								<input name="password" type="password" class="textfield width200px" id="password" value="<?=$this->validation->password?>" />
							</p>
						</td>
                        
					</tr>
					
                    <? if (!$this->input->post('dealer_no') && 1 == 2) { ?>
                    <tr>
                        <td colspan="4">
                            <p class="messages" style="width:615px;">Please note that this NEC Account Number will be your login once your account is approved.<br />
                                Password must be at least 6 characters long and must include both letters and numbers.
                            </p>
                        </td>
                    </tr>
                    <? }?>
					<tr>
						
						<td width="220">
							<p class="register-password">
								<label for="password_2">Confirm Password:</label>&nbsp;*&nbsp;
							</p>
						</td>
						<td>
							<p class="register-password">
								<input name="password_2" type="password" class="textfield width200px" id="password_2" value="<?=$this->validation->password_2?>" />
							</p>
						</td>
					</tr>
			</table>
			</div>
			<br />
			<div id="no-account">
			    <table border="0" cellpadding="0" cellspacing="0" class="register-table">
				<tr>
				    <td width="220"><label>What is your relationship with NEC? </label>&nbsp;*&nbsp;</td>
				    <td><input type="text" class="textfield width200px" name="relationship" id="relationship" value="<?=$this->validation->relationship?>" /></td>
				</tr>
				<tr>
				    <td width="220"><label>Reason you require access? </label>&nbsp;*&nbsp;</td>
				    <td><input type="text" class="textfield width200px" name="reason" id="reason" value="<? echo $this->validation->reason?>" /></td>
				</tr>
				<tr>
				    <td width="220"><label>Who referred you to this site?<br /> (Contact and company name) </label>&nbsp;*&nbsp;</td>
				    <td><input type="text" class="textfield width200px" name="referee" id="referee" value="<?=$this->validation->referee?>" /></td>
				</tr>
				<tr>
				    <td width="220"><label>Please select a user name:  </label>&nbsp;*&nbsp;</td>
				    <td><input type="text" class="textfield width200px" name="username" id="username" value="<?=$this->validation->username?>" /></td>
				</tr>
				<tr>
				    <td width="220"><label>Please select a password:  </label>&nbsp;*&nbsp;</td>
				    <td><input type="password" class="textfield width200px" name="password_3" id="password_3" value="<?=$this->validation->password_3?>" /></td>
				</tr>
				<tr>
				    <td width="220"><label>Please confirm your password:  </label>&nbsp;*&nbsp;</td>
				    <td><input type="password" class="textfield width200px" name="password_4" id="password_4" value="<?=$this->validation->password_4?>" /></td>
				</tr>
			    </table>
			</div>
				<input type="image" src="./images/submit_button.gif?q=1" name="submit" value="submit &raquo;" />
			
            <? } ?>
			</form>
		</div>
<? require('tpl/footer.php') ?>
