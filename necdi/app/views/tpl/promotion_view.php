<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
    	<style type="text/css">
		.promo-content {
			margin-right:167px;
		} 
		.promo-content table {
			width:465px;
		}
		</style>
        <div id="content">
        	<h2 class="page-title"><?= htmlentities($current['title'], ENT_QUOTES) ?></h2>
            
            
            <div class="common-data-right">
			<? if (isset($downloads) && $downloads) { ?>
                <h4>Downloads</h4>
                <? foreach ($downloads as $file) { ?>
                <a href="webpublisher/file-preview.php?file=<?= $file['id'].'.'.$file['extension'] ?>&amp;filename=<?= preg_replace('/[^a-z0-9\.]+/i', '_', $file['title']) . "." . $file['extension'] ?>" class="details"><?= $file['title'] ?></a></p>
                <? } ?>
            <? } ?>
            <? if (isset($images) && $images) foreach ($images as $mi) { ?>
            <a href="wpdata/<?= $mi['id'] ?>-l.jpg" title="<?= $mi['title'] ?>" class="light-box"><img src="wpdata/<?= $mi['id'] ?>-s.jpg" class="model-image-range" title="<?= $mi['title'] ?>" /></a>
            <? } ?>
            </div>
            
            <div class="promo-content">
                <?= $current['content'] ?>
            </div>
		</div><!-- Close content -->
        <script type="text/javascript">
		$(function(){
			$('a.light-box').lightBox({fixedNavigation:true, overlayBgColor:'#193264'});
		});
		</script>
<? require ('tpl/footer.php'); ?>