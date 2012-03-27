<?php
$current_user = $this->session->userdata('logged_in_user');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<base href="<?= $this->config->item('base_url'); ?>" />
	<title>NEC | National Dealer Intranet</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="includes/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="includes/css/updatedlayout.css?q=9" type="text/css" media="screen" />
	
	<!-- link rel="stylesheet" href="includes/css/layout.css?q=f" type="text/css" media="screen" / -->

	<link rel="stylesheet" href="includes/css/jquery.lightbox-0.5.css" type="text/css" media="screen" />
	
	<script type="text/javascript" src="./includes/js/jquery.js" language="javascript"></script>
	<script type="text/javascript" src="./includes/js/jq-ui-1.6b.min.js" language="javascript"></script>
	<script type="text/javascript" src="./includes/js/jquery.lightbox-0.5.min.js" language="javascript"></script>
	<script type="text/javascript" src="./includes/js/jquery.blockUI.js" language="javascript"></script>
	<script type="text/javascript" src="./includes/js/compare.js" language="javascript"></script>
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
		
			<?php
				if(is_array($current_user)){
			?>
            <div id="user_panel">
                <div id="user_panel_end"></div><!-- Close user_panel_end -->
				<p id="user"><?php echo $current_user['name'].' [ '.$this->login_model->categories[$current_user['category_fk']].' ]';?></p>
				<p id="signout"><a href="myaccount/">My Account</a> | <a href="userlogin/">Signout</a></p>
            </div><!-- Close user_panel -->
            
            <div id="main_nav">
                <a href="" class="home png-fix">Home</a>
                <a href="news/" class="news png-fix">News</a>
                <a href="contact/" class="contact png-fix">Contact</a>
                <? if ($this->acl_model->check_access(1464, $current_user['category_fk'])) { ?>
                <form name="tech_search_form" id="tech_search_form" action="search/tech/" method="post">
                	<input type="text" name="tech_term" value="<?= ($this->uri->segment(1) == 'search' && $this->uri->segment(2) == 'tech' && $this->uri->segment(3) != '') ? rawurldecode($this->uri->segment(3)) : 'Search technical library' ?>" class="textfield search-field" />
					<input type="image" src="includes/images/search-btn.png" class="search-btn png-fix" />
					<!-- input type="image" src="includes/images/search_butt.jpg" / -->
                </form>
                <? } ?>
                <? if ($this->acl_model->check_access(1465, $current_user['category_fk'])) { ?>
                <form name="media_search_form" id="media_search_form" action="search/media/" method="post">
                	<input type="text" name="media_term" value="<?= ($this->uri->segment(1) == 'search' && $this->uri->segment(2) == 'media' && $this->uri->segment(3) != '') ? rawurldecode($this->uri->segment(3)) : 'Search media library' ?>" class="textfield search-field" />
					<input type="image" src="includes/images/search-btn.png" class="search-btn png-fix" />
					<!-- input type="image" src="includes/images/search_butt.jpg" / -->
                </form>
                <? } ?>
                <script type="text/javascript">
				$(function(){
					$('#tech_search_form input[@type=text]').focus(function(){
						if ($.trim(this.value) == 'Search technical library') {
							this.value = '';
						}
					});
					$('#media_search_form input[@type=text]').focus(function(){
						if ($.trim(this.value) == 'Search media library') {
							this.value = '';
						}
					});
					$('#tech_search_form input[@type=text]').blur(function(){
						if ($.trim(this.value) == '') {
							this.value = 'Search technical library';
						}
					});
					$('#media_search_form input[@type=text]').blur(function(){
						if ($.trim(this.value) == '') {
							this.value = 'Search media library';
						}
					});
					$('#tech_search_form').submit(function(){
						if ($.trim($('input[@type=text]', $(this)).val()) == '' || $.trim($('input[@type=text]', $(this)).val()) == 'Search technical library') {
							alert('Please enter your search term / model number');
							return false;
						} else {
							return true;
						}
					});
					$('#media_search_form').submit(function(){
						if ($.trim($('input[@type=text]', $(this)).val()) == '' || $.trim($('input[@type=text]', $(this)).val()) == 'Search media library') {
							alert('Please enter your search term / model number');
							return false;
						} else {
							return true;
						}
					});
					$('.tab-specifications table, .compare-item table').each( function() {
						$("tr:nth-child(odd)", $(this)).addClass("odd");
					});
				});
				</script>
            </div><!-- Close main_nav -->
			<?php
			}
			?>
		
	</div><!-- Close head -->
	<div id="login_main">
		<div id="login_top"></div><!-- Close login_top -->
		<div id="login_bottom">
			<div id="login_content">
