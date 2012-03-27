<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
        <div id="content">
           
		<style type="text/css">
		.model-image {
			width:160px;
		}
		.middle-container {
			width:auto; /* 480px */
		}
		.prod-model {
			width:480px;
		}
		.prize-cover {
			width:auto;
			overflow:hidden;
			margin-bottom:10px;
		}
		.point-details {
			float:right;
			width:130px;
		}
		.point-details .points {
			background:none repeat scroll 0 0 green;
			border:1px solid #CCCCCC;
			font-size:16px;
			font-weight:bold;
			padding:10px 5px;
			text-align:center;
		}
		.error-text {
			background:none repeat scroll 0 0 pink;
			border:1px solid red;
			color:crimson;
			padding:10px;
		}
		.success-text {
			background:none repeat scroll 0 0 lightGoldenRodYellow;
			border:1px solid green;
			color:green;
			padding:10px;
		}
		.error-text span, .success-text span {
			font-weight:bold;
		}
		.success-text a {
			color:green;
		}
		.contact-details-form td {
			padding:5px;
		}
		.error_message {
			padding:10px;
			height:auto !important;
		}
		.point-details .textfield {
			width:25px;
			margin-top:3px;
		}
		.qty-update {
			margin-top:8px;
			overflow:hidden;
		}
		.qty-update .update-btn {
			float:right;
			margin-top:-3px;
			margin-left:-3px;
		}
		</style>
        
        <div class="middle-container">
            <h2>Prize Redemption</h2>
			
            <?php
			if (isset($promotions_cart) && is_array($promotions_cart) && count($promotions_cart))
			{
				?>
				<form action="myaccount/redemption_update" method="post">
				<?php
				
				$point_total = 0;
				foreach ($promotions_cart as $prize)
				{
					$point_total += ($prize['points'] * $promotions_count[$prize['id']]);
				?>
				<div class="prize-cover">
					<div class="point-details common-data-right">
						<p class="points"><?= $prize['points'] ?> Points</p>
						<a href="myaccount/remove_promotion/<?= $prize['id'] ?>" class="remove">Remove from list</a>
						<p class="qty-update">
							<input type="text" size="3" class="textfield" name="updatepromo_<?= $prize['id'] ?>" value="<?= $promotions_count[$prize['id']] ?>" />
							<input type="image" src="includes/images/update-btn.png" name="update_cart" class="update-btn" value="Update" />
						</p>
					</div>
					<div class="prod-model">
						<? if (isset($prize['images'][0])) { ?>
							<a href="promotions/prizes/3943/<?= $prize['id'] ?>"><img src="wpdata/<?= $prize['images'][0]['id'] ?>-m.jpg" class="model-image" title="<?= $prize['images'][0]['title'] ?>" /></a>
						<? } ?>
						<h4><?= htmlentities($prize['title'], ENT_QUOTES) ?></h4>
						<p><?= character_limiter(strip_tags($prize['synopsis'], '<p><br><br />'), 120) ?></p>
							<p class="more">
								<a href="promotions/prizes/3943/<?= $prize['id'] ?>">More Information &raquo;</a>
							</p>
					</div>
				</div>
				<?php
				}
				?>
				</form>
				<?php
				
				if ($point_total > $point_balance)
				{
					?>
				<p class="error-text">You do not have enough points to redeem all the listed prizes.<br />
				Your point balance is <span class="balance"><?php echo $point_balance?></span> and you are attemting to redeem a total of <span class="point-total"><?php echo $point_total ?></span> points.</p>
					<?php
				}
				else
				{
				?>
				<p>Want to add more prizes to this list? <a href="promotions/prizes/">Add more from our prize pool.</a></p>
				<br /><br />
				<?php
				if ($redemption_form_error != '')
				{
					echo '<div class="error_message">' . $redemption_form_error . '</div>';
				}
				?>
				<form action="myaccount/redeem_points" method="post" onsubmit="return validateRedemption();">
					<p>Total of the current redemptions: <?php echo $point_total ?>, Your point balance is <?php echo $point_balance ?>.</p>
					<p>When you are ready to process your redemption, please fill the below form and submit.</p>
					<table border="0" cellpadding="0" cellspacing="0" class="contact-details-form">
						<tr>
							<td>Company</td>
							<td><?php echo $user_company ?></td>
						</tr>
						<tr>
							<td>Contact Name</td>
							<td><input type="text" name="contact_name" id="red-contact-name" class="textfield" value="" /></td>
						</tr>
						<tr>
							<td>Phone Number</td>
							<td><input type="text" name="contact_number" id="red-contact-number" class="textfield" value="" /></td>
						</tr>
						<tr>
							<td>Email Address</td>
							<td><input type="text" name="contact_email" id="red-contact-email" class="textfield" value="" /></td>
						</tr>
					</table>
					<input type="image" value="submit" name="process_redemptions" src="./images/submit_button.gif?q=1" onclick="return window.confirm('Are you sure you wish to submit the redemptions\nvalued at <?php echo $point_total ?> points?');" />
				</form>
				<?php
				}
			}
			else if (isset($complete))
			{
				?>
				<p class="success-text">
					Thank you for submitting your request. A confirmation email has been sent to the associated email address of your current login.
					<br />outlining the details of the redeemed products.
					<br /><br />
					Your new point balance is <span><?php echo $point_balance ?></span> points. <a href="myaccount/#point-balance">View your point transactions.</a>
				</p>
				<?php
			}
			else
			{
				?>
				<div class="prize-cover">
					<h3>You do not seem to have any promotions added for redemption.</h3>
					<p><a href="promotions/prizes/3943">Check our prize pool</a></p>
				</div>
				<?php
			}
			?>
            
        </div><!-- close middle content -->
		
		<script type="text/javascript">
		function validateRedemption()
		{
			var cname = $.trim($('#red-contact-name').val());
			var cnumber = $.trim($('#red-contact-number').val());
			var cemail = $.trim($('#red-contact-email').val());
			
			$('#red-contact-name, #red-contact-number, #red-contact-email').css('border-color', '#D6D6D6');
			
			if ( ! /[a-z]+/i.test(cname))
			{
				$('#red-contact-name').css('border-color', 'red').focus();
				alert('Invalid contact name');
				return false;
			}
			
			if ( ! /[0-9]+/.test(cnumber))
			{
				$('#red-contact-number').css('border-color', 'red').focus();
				alert('Invalid contact number');
				return false;
			}
			
			if ( ! /[a-z0-9\.\+_]@[a-z0-9]/.test(cemail))
			{
				$('#red-contact-email').css('border-color', 'red').focus();
				alert('Invalid contact email');
				return false;
			}
			
			return true;
		}
		</script>
        
		</div><!-- Close content -->
<? require ('tpl/footer.php'); ?>
