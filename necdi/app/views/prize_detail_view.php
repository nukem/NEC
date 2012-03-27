<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
        <div id="content">
			
			<style type="text/css">
			.point-details {
				float:right;
			}
			.point-details .points {
				background:none repeat scroll 0 0 green;
				border:1px solid #CCCCCC;
				font-size:16px;
				font-weight:bold;
				padding:10px 5px;
				text-align:center;
			}
			.point-details a img {
				width:150px;
			}
			.intro {
				background:none repeat scroll 0 0 #021221;
				border:1px solid #062B46;
				font-size:12px;
				padding:10px;
				width:460px;
			}
			.page-title a {
				text-decoration:none;
				color:#4392D5;
			}
			</style>
			
			<!--[if lte IE 7]>
			<style type="text/css">
			p.intro {
				width:450px;
			}
			</style>
			<![endif]-->
			
        	<h2 class="page-title"><a href="promotions/prizes/<?php echo $parent_folder ?>">Prize Pool</a> &gt; <?= htmlentities($prize['title'], ENT_QUOTES) ?></h2>
            
			<div class="prod-panel">
				
				<div class="point-details common-data-right">
					<p class="points"><?= $prize['points'] ?> Points</p>
					<a href="myaccount/redeem_points/<?= $prize['id'] ?>" class="details">Redeem Now!</a>
					<? if (isset($prize['images']) && is_array($prize['images'])) foreach ($prize['images'] as $mi) { ?>
					<a href="wpdata/<?= $mi['id'] ?>-l.jpg" title="<?= $mi['title'] ?>" class="light-box"><img src="wpdata/<?= $mi['id'] ?>-m.jpg" class="model-image-range" title="<?= $mi['title'] ?>" /></a>
					<? } ?>
				</div>
           
				<p class="intro"><?= $prize['synopsis'] ?></p>
                <?= $prize['content'] ?>
            </div>
            <script type="text/javascript">
			$(function(){
				$('a.light-box').lightBox({fixedNavigation:true, overlayBgColor:'#193264'});
			});
			</script>
		</div><!-- Close content -->
<? require ('tpl/footer.php'); ?>
