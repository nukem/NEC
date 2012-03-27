<?php require ('tpl/header.php'); ?>
<style type="text/css">
#flash-ad-container {
	width:460px;
	height:258px;
	overflow:hidden;
}
</style>
	<script type="text/javascript" src="includes/js/swfobject.js"></script>
	<?php require ('tpl/menu.php') ?>
    <?php require ('tpl/news.php') ?>
	<div class="video-thumbs">
<?php
foreach($thumbs as $t) {
?>
		<div class="thumb">
<?php
	if(isset($t['image']) && count($t['image']) > 0) {
?>
			<a href="./video/index/<?php echo $t['id']; ?>"><img src="wpdata/<?php echo $t['image']['id'];
?>-s.jpg" /></a>
<?php
	}
?>
<h3><a href="./video/index/<?php echo $t['id']; ?>"><?php echo $t['title']; ?></a></h3>
<p><?php echo date('d-m-Y', strtotime($t['created'])); ?></p>
		</div>
<?php
}
?>
	</div>
	<div id="content">
		<div class="video-content">
			<h1><?php echo $video['article']['title']; ?></h1>
			<div id="video-player">Flash + Javascript required to view this video</div>
			<?php echo $video['article']['content']; ?>
		</div>
		<script type="text/javascript">
<?php
if($video['file']['extension'] == 'flv') {
?>
		var flashvars = {
			video_content_path: "/wpdata/<?php echo $video['file']['id']; ?>.flv"
		};
		var params = {wmode:'transparent'};
		var attributes = {};
		
		swfobject.embedSWF("includes/swf/videoplayer-480x318.swf", "video-player", "480", "318", "9.0.0","includes/swf/expressInstall.swf", flashvars, params, attributes);
<?php
} else if($video['file']['extension'] == 'swf')	{
	// Format for the swf name is as follows:
	// ladeadvideo-WWWxHHH
	// where WWW -> width in pixels and HHH -> height in pixels
	$flash = 'wpdata/' . $video['file']['id'] . '.swf';
	list($width, $height, $type, $attr) = getimagesize($flash);

	$percentage = $width / $height;

	$tar_height = 480 / $percentage;
?>
		var flashvars = {}
		var params = {wmode:'transparent'};
		var attributes = {};
		
		swfobject.embedSWF("wpdata/<?php echo $video['file']['id']; ?>.swf", "video-player", "480", "<?php echo $tar_height; ?>", "9.0.0","includes/swf/expressInstall.swf", flashvars, params, attributes);
<?php
}
?>
		</script>

	</div><!-- Close content -->
<?php require ('tpl/footer.php'); ?>

