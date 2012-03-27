<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
        <div id="content">
        
        <? if (isset($empty_search)) { ?>
        
        <h2>No search term entered!</h2>
        <p>Please enter your search keyword.</p>
        
		<? } else if (isset($no_results)) { ?>
        
        <h2>You are searching for - <span class="search-term"><?= $keyword ?></span></h2>
        <p>Your search did not provide any results, please try a different keyword</p>
        
        <? } else { ?>
        
			<? if ($pagination != '') { ?>
            <p class="pagination"><?= $pagination ?></p>
            <? } ?>
            
            <h2>You are searching for - <span class="search-term"><?= $keyword ?></span></h2>
            <p>Models matching your search term are highlighted <span class="matching-colour">in blue</span></p>
            
            <? if (isset($models) && is_array($models)) foreach ($models as $model) { ?>
                <div class="search-result">
                    <h4><?= htmlentities($model['data']['title'], ENT_QUOTES) ?></h4>
                    <? foreach ($model['images'] as $file) { ?>
                        <div class="hi-res-block">
                        <? if (is_file('wpdata/' . $file['id'] . '-s.jpg')) { ?>
                                <a href="wpdata/<?= $file['id'] ?>-l.jpg" class="light-box" title="<?= $file['title'] ?>"><img src="wpdata/<?= $file['id'] ?>-s.jpg" class="model-image" alt="<?= $file['title'] ?>" /></a>
                        <? } ?>
                        <br /><?= $file['title'] ?><br />
                        <a href="webpublisher/file-preview.php?file=<?= $file['id'].'.'.$file['extension'] ?>&amp;filename=<?= preg_replace('/[^a-z0-9\.]+/i', '_', $file['title']) . "." . $file['extension'] ?>">Download File</a>
                        </div>
                    <? } ?>
                </div>
            <? } else { ?>
            <p>No items to display!</p>
            <? } ?>
            
            <? if ($pagination != '') { ?>
            <p class="pagination"><?= $pagination ?></p>
            <? } ?>
            
            
            <script type="text/javascript">
            $(function(){
                $('a.light-box').lightBox({fixedNavigation:true, overlayBgColor:'#193264'});
                <? if ($this->uri->segment(1) == 'search' && $this->uri->segment(2) == 'media' && $this->uri->segment(3) != '') { ?>
                $('.hi-res-block').each(function(){
                    if ($(this).text().toLowerCase().indexOf('<?= str_replace("'", "\'", rawurldecode($this->uri->segment(3))) ?>') != -1) {
                        $(this).css('background', '#3a69a0');
                    }
                });
                <? } ?>
            });
            </script>
            
        <? } ?>
            
        </div><!-- Close content -->
<? require ('tpl/footer.php'); ?>