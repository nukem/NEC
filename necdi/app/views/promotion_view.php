<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
    	<style type="text/css">
		.promo-content {
			margin-right:167px;
		} 
		.promo-content table {
			width:465px;
		}
		.promotion-points {
			background:#80A90F;
			color:navy;
			float:right;
			font-size:14px;
			font-weight:bold;
			padding:5px 25px 5px 8px;
			display:block;
			text-decoration:none;
		}
		.promotion-points em {
			font-size:12px;
			color:white;
			font-style:normal;
		}
		.promo-title-cover {
			overflow:visible;
			width:auto;
			position:relative;
			margin-bottom:8px;
			height:30px;
			border-bottom:2px solid #164E8F;
		}
		.promo-title-cover h2 {
			position:absolute;
			border-bottom:none;
			margin-bottom:2px;
			bottom:0;
			float:left;
		}
		.promo-title-cover img.feature {
			right:-10px;
			top:-10px;
			position:absolute;
			width:32px;
		}
		</style>
        <div id="content">
			<div class="promo-title-cover">
				<h2 class="page-title"><?= htmlentities($current['title'], ENT_QUOTES) ?></h2>
			</div>
            
            
            <div class="common-data-right">
			<? if (isset($downloads) && $downloads) { ?>
                <h4>Downloads</h4>
                <? foreach ($downloads as $file) { ?>
                <a href="webpublisher/file-preview.php?file=<?= $file['id'].'.'.$file['extension'] ?>&amp;filename=<?= preg_replace('/[^a-z0-9\.]+/i', '_', $file['title']) . "." . $file['extension'] ?>" class="details"><?= $file['title'] ?></a></p>
                <? } ?>
                <p>&nbsp;</p>
            <? } ?>
            <? if (isset($images) && $images) foreach ($images as $mi) { ?>
            <a href="wpdata/<?= $mi['id'] ?>-l.jpg" title="<?= $mi['title'] ?>" class="light-box"><img src="wpdata/<?= $mi['id'] ?>-s.jpg" class="model-image-range" title="<?= $mi['title'] ?>" /></a>
            <? } ?>
            </div>
            
            <div class="promo-content">
                <?= $current['content'] ?>
                <? if (isset($tabs) && count($tabs) > 0) { ?>
                
                    <ul class="tab-session">
                    <? foreach ($tabs as $td) { ?>
                        <li><a href="<?= $this->uri->uri_string() ?>#ctab-<?= $td['id'] ?>"><?= $td['title'] ?></a></li>
                    <? } ?>
                    </ul>
                    
                    <? foreach ($tabs as $td) { ?>
                    <div id="ctab-<?= $td['id'] ?>">
                    <?= $td['content'] ?>
                    </div>
                    <? } ?>
                    
               <? } ?>
            </div>
		</div><!-- Close content -->
        <script type="text/javascript">
		$(function(){
			$(".tab-session").tabs();
			$('a.light-box').lightBox({fixedNavigation:true, overlayBgColor:'#193264'});
		});
		</script>
<? require ('tpl/footer.php'); ?>