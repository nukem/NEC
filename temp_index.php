<?php
if (isset($_COOKIE["necdi_sess"]))
{
	setcookie("necdi_sess", "", time() - 3600);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<base href="http://www.nec-cds.com.au/" />
	<title>NEC | National Dealer Intranet</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="includes/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="includes/css/updatedlayout.css?q=5" type="text/css" media="screen" />
	
	<!-- link rel="stylesheet" href="includes/css/layout.css?q=f" type="text/css" media="screen" / -->

	<link rel="stylesheet" href="includes/css/jquery.lightbox-0.5.css" type="text/css" media="screen" />
	
	<script type="text/javascript" src="./includes/js/jquery.js" language="javascript"></script>
	<script type="text/javascript" src="./includes/js/jq-ui-1.6b.min.js" language="javascript"></script>
	<script type="text/javascript" src="./includes/js/jquery.lightbox-0.5.min.js" language="javascript"></script>
	<!--script type="text/javascript" src="./includes/js/iepngfix_tilebg.js" language="javascript"></script-->
	<!--[if IE 7]>
	<link href="includes/css/ie.css?q=5" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!--[if IE 6]>
	<link href="includes/css/ie6.css?q=8" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="./includes/js/jquery.pngFix.js"></script>
	<script type="text/javascript"> 
	    $(document).ready(function(){ 
			$(document).pngFix({
				blankgif:'images/blank.gif'
			}); 
	    }); 
	</script> 
	<![endif]-->

</head>

<body>
<div id="wrap">
	<div id="head">
		<a href="." class="logo">
        	<img src="./images/nec_header.jpg" alt="NEC | National Dealer Intranet" title="NEC | National Dealer Intranet" class="nec_header" />
        </a>
		
					
	</div><!-- Close head -->
	<div id="login_main">
		<div id="login_top"></div><!-- Close login_top -->

		<div id="login_bottom">
			<div id="login_content">
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
label, input {
	visibility:hidden;
}
</style>
				<form action="./userlogin" method="post" class="login_form">
					<table class="login" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="3" class="message_holder">
																<div class="messages">
								<h4>NOTICE</h4>
<p style="font-size:12px;">We are currently doing some maintenenace work on the site.<br />
This site will be available to be accessed shortly.</p>
								</div><!-- Close messages -->
															</td>
						</tr>
					</table>
				</form>
			<div id="login_message">
				<h3>Service currently unavailable!</h3>
                <p class="bigger">Your service will be back up and running once the current maintenenace operations are complete.<br />Thank you for your patience and we apologise for the inconvenience caused.</p>

				
			</div><!-- Close login_message -->

			<div class="clear_float"></div><!-- Close clear_float -->
			</div><!-- Close login_content -->
		</div><!-- Close login_bottom -->
	</div><!-- Close login_main -->
	<div id="foot">
		<p>Copyright &copy; 2008-09 NEC Australia Pty Ltd. All Rights Reserved.</p>

		<p class="visiontech"><a href="http://www.visiontechsolutions.com.au" target="_blank">developed by <span>visiontech</span>&nbsp;<b>digital</b></a></p>
	</div><!-- Close foot -->
</div><!-- Close wrap -->
<!--[if IE 6]>
<script src="includes/js/DD_belatedPNG.js"></script>
<script>
  /* EXAMPLE */
  DD_belatedPNG.fix('.png-fix');
  
  /* string argument can be any CSS selector */
  /* .png_bg example is unnecessary */
  /* change it to what suits you! */
  $('.DD_belatedPNG_sizeFinder').css('visibility', 'hidden !important');
</script>
<![endif]--> 

</body>
</html>
