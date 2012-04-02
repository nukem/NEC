<? require('tpl/header.php') ?>
		
		<div id="login-page">
		<h2 class="login-title">User Login</h2>
			<? if (isset($notallowed) && $notallowed === true) { ?>
				<h2>You do not have access to this area of the site!</h2>
			<? } else { ?>
			<form action="./userlogin" method="post" class="login-form">
				<p><label for="username">Dealer Number:</label>&nbsp;<input name="username" type="text" class="textfield width200px" id="username" value="<?=$this->input->post('username')?>" /></p>
				<p><label for="password">Password:</label>&nbsp;<input name="password" type="password" class="textfield width200px" id="password" /></p>
				<div class="buttons login-button">
					<button type="submit" class="positive">Login</button>
				</div>
				<input type="hidden" name="last_url" value="<?= $this->session->flashdata('last_url') ?>" />
				<p class="forgot-pass"><a href="account/forgot_password">Forgot your password?</a></p>
			</form>
			<script type="text/javascript">
			window.onload = function() {
				document.forms[0].username.focus();
			}
			</script>
			<? } ?>
		<p class="no-account">If you do not have an account, please <a href="account/register/">register here</a>.</p>
		
		</div>
		
<? require('tpl/footer.php') ?>