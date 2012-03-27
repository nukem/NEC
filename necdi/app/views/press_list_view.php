<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
    
    	<style type="text/css">
		.date {
			color:#1e5494;
			font-size:12px;
			font-weight:bold;
		}
		</style>
        <div id="content">
        
        <h2 class="page-title">Press Releases - <?= htmlentities($current['title'], ENT_QUOTES) ?></h2>
        
		<? if ($pagination != '') { ?>
        <p class="pagination"><?= $pagination ?></p>
        <? } ?>
        
        <? if (isset($press) && is_array($press)) foreach ($press as $pr) { ?>
            <div class="news-item">
            	<h3><?= htmlentities($pr['title'], ENT_QUOTES) ?></h3>
                <p class="date"><?= date('d M Y', strtotime($pr['press_date'])) ?></p>
                <div>
                <?= word_limiter(strip_tags($pr['content'], '<p><br><br />'), 80); ?>
                </div>
                <p class="more"><a href="media/detail/<?= $pr['id'] ?>">More on this article &raquo;</a></p>
            </div>
        <? } else { ?>
        <p>No items to display!</p>
        <? } ?>
        
        <? if ($pagination != '') { ?>
        <p class="pagination"><?= $pagination ?></p>
        <? } ?>
        
		</div><!-- Close content -->
        <script type="text/javascript">
		$(function(){
			$('a.light-box').lightBox({fixedNavigation:true, overlayBgColor:'#193264'});
		});
		</script>
<? require ('tpl/footer.php'); ?>