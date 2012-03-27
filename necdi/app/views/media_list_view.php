<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
    
    	<style type="text/css">
		.hires-item-set {
			display:none;
		}
		.media-item h4 a {
			display:block;
			padding:6px 8px;
			background:#7492AE;
			text-decoration:none;
			border:1px solid #9DB3CA;
		}
		.media-item h4 a:hover {
			background:#627a95;
		}
		</style>
        <div id="content">
        
        
        <? if ($pagination != '') { ?>
        <p class="pagination"><?= $pagination ?></p>
        <? } ?>
        
        <h2><?= $current['title'] ?></h2>
        
        <? if (isset($models) && is_array($models)) foreach ($models as $model) { ?>
            <div class="media-item">
            	<h4><a href="<?= $this->uri->uri_string() ?>#" class="head-link"><?= htmlentities($model['data']['title'], ENT_QUOTES) ?></a></h4>
                <div class="hires-item-set">
				<? foreach ($model['images'] as $file) { ?>
                	<div class="hi-res-block">
					<? if (is_file('wpdata/' . $file['id'] . '-s.jpg')) { ?>
                            <a href="wpdata/<?= $file['id'] ?>-l.jpg" class="light-box" title="<?= $file['title'] ?>"><img src="wpdata/<?= $file['id'] ?>-s.jpg" class="model-image" alt="<?= $file['title'] ?>" /></a>
                    <? } ?>
                    <br /><?= $file['title'] ?><br />
                    <a href="webpublisher/file-preview.php?file=<?= $file['id'].'.'.$file['extension'] ?>&amp;filename=<?= preg_replace('/[^a-z0-9\.]+/i', '_', $file['title']) ?>"><strong>Download File</strong></a>
                    </div>
                <? } ?>
                </div>
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
			//$('.hires-item-set:first').css('display', 'block');
			$('.head-link').click(function(){
				$(this).parent().siblings('.hires-item-set').slideToggle(400);
				return false;
			});
		});
		</script>
<? require ('tpl/footer.php'); ?>