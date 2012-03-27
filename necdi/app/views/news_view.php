<? require ('tpl/header.php'); ?>
    <? require ('tpl/menu.php') ?>
        <div class="page-content">
        
        <? if (isset($news_items) && is_array($news_items) && count($news_items) > 0) {?>
            <h2 class="page-title">Recent News</h2>
            <? foreach ($news_items as $item) { ?>
                <div class="news-item">
					<? if ( ( isset($item['images']) && count($item['images']) ) ) { ?>
						<div class="common-data-right">
						<? if ( isset($item['images']) ) foreach ($item['images'] as $nimg) { ?>
						<a class="light-box" title="<?= $nimg['title'] ?>" href="wpdata/<?= $nimg['id'] ?>-l.jpg"><img alt="<?= $nimg['title'] ?>" class="model-image-range" src="wpdata/<?= $nimg['id'] ?>-s.jpg"/></a>
						<? } ?>
						</div>
					<? } ?>
					<h3><?= htmlentities($item['title'], ENT_QUOTES) ?></h3>
					<?= word_limiter(strip_tags($item['content'], '<p><br><br />'), 100) ?>
					<p class="more"><a href="news/item/<?= $item['id'] ?>">more &raquo;</a></p>
                </div>
            <? } ?>
        <? } else if (isset($single_item)) { ?>
        	<h2 class="page-title"><?= htmlentities($news_item['title'], ENT_QUOTES) ?></h2>
            <div class="single-news-item">
            <? if ( ( isset($news_item['images']) && count($news_item['images']) ) || ( isset($news_item['files']) && count($news_item['files']) ) ) { ?>
            	<div class="common-data-right">
				<? if (isset($news_item['files']) && is_array($news_item['files'])) { ?>
                    <h4>Downloads</h4>
                    <? foreach ($news_item['files'] as $file) { ?>
                    <a href="webpublisher/file-preview.php?file=<?= $file['id'].'.'.$file['extension'] ?>&amp;filename=<?= trim(preg_replace('/[^a-z0-9\.]+/i', '_', $file['title']), '_') . "." . $file['extension'] ?>" class="details"><?= $file['title'] ?></a></p>
                    <? } ?>
                <? } ?>
                <? if ( isset($news_item['images']) ) foreach ($news_item['images'] as $nimg) { ?>
                <a class="light-box" title="<?= $nimg['title'] ?>" href="wpdata/<?= $nimg['id'] ?>-l.jpg"><img alt="<?= $nimg['title'] ?>" class="model-image-range" src="wpdata/<?= $nimg['id'] ?>-s.jpg"/></a>
                <? } ?>
                </div>
            <? } ?>
            <?= $news_item['content'] ?>
            <p><a href="news/">Back to News</a></p>
            </div>
			<script type="text/javascript">
			$(function(){
				$('a.light-box').lightBox({fixedNavigation:true, overlayBgColor:'#193264'});
			});
			</script>
        <? } ?>
        </div>
<? require ('tpl/footer.php'); ?>