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
        
            <h2 class="page-title"><?= htmlentities($pr['title'], ENT_QUOTES) ?></h2>
            <p class="date"><?= date('d M Y h:m', strtotime($pr['press_date'])) ?></p>
            <? if (isset($pr['file_data'])) { ?>
            <div class="common-data-right">
                    <h4>Downloads</h4>
                    <? foreach ($pr['file_data'] as $file) { ?>
                    <a href="webpublisher/file-preview.php?file=<?= $file['id'].'.'.$file['extension'] ?>&amp;filename=<?= preg_replace('/[^a-z0-9\.]+/i', '_', $file['title']) . "." . $file['extension'] ?>" class="details"><?= $file['title'] ?></a></p>
                    <? } ?>
            </div>
            <? } ?>
            
            <div>
            <?= $pr['content'] ?>
            </div>
        
		</div><!-- Close content -->
        <script type="text/javascript">
		$(function(){
			$('a.light-box').lightBox({fixedNavigation:true, overlayBgColor:'#193264'});
		});
		</script>
<? require ('tpl/footer.php'); ?>