<? require ('tpl/header.php'); ?>
<style type="text/css">
#flash-ad-container {
	width:460px;
	height:258px;
	overflow:hidden;
}
</style>
	<script type="text/javascript" src="includes/js/swfobject.js"></script>
	<? require ('tpl/menu.php') ?>
    <? require ('tpl/news.php') ?>
        <div id="content">
            <div class="home-content">
            	<h2><?= $home_content[0]['title'] ?></h2>
            	<?= $home_content[0]['content'] ?>
            </div>
			
			<!-- div style="width:460px; overflow:hidden; margin-bottom:14px;">
				<table style="text-align: center; background-color: #ffffff; font-size: 12px; width: 460px; font-family: Georgia,serif; padding: 0pt; margin: 0pt auto;" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#000000">
				 
				<tbody>
				<tr>
				<td><img src="http://nec-cds.com.au/edms/header.jpg" alt="" style="width:460px;" /></td>
				</tr>
				<tr>
				<td><img src="http://nec-cds.com.au/edms/arrived.gif" alt="" style="width:460px;" /></td>
				</tr>
				<tr>
				<td><img src="http://nec-cds.com.au/edms/footer.png" alt="" style="width:460px;" /></td>
				</tr>
				</tbody>
				</table>
			</div -->
			
            <div id="flash-ad-container">
                <div id="flash-ad">
                <a href="http://www.adobe.com/products/flashplayer/" onclick="window.open(this.href); return false;">Flash Player</a> is required to view this content!
                </div>
            </div>
            <script type="text/javascript">
			var flashvars = {};
			var params = {wmode:'transparent'};
			var attributes = {};
			
			swfobject.embedSWF("includes/swf/nec-note-460x258.swf?q=4", "flash-ad", "460", "258", "8.0.0","includes/swf/expressInstall.swf", flashvars, params, attributes);
			//swfobject.embedSWF("includes/swf/NEC_Puzzle_470x264.swf", "flash-ad", "460", "258", "8.0.0","includes/swf/expressInstall.swf", flashvars, params, attributes);
			
			</script>

		</div><!-- Close content -->
<? require ('tpl/footer.php'); ?>
