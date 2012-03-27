<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
        <div id="content">
        
        <!--
        <?= $the_last_query ?>
        <? print_r($chunks) ?>
        -->
        
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
            <? if ($models) foreach ($models as $model) { ?>
                <div class="prod-model">
                    <? if ($model['image']) { ?>
                        <a href="products/detail/<?= $model['data']['id'] ?>"><img src="wpdata/<?= $model['image']['id'] ?>-s.jpg" class="model-image" title="<?= $model['image']['title'] ?>" /></a>
                    <? } ?>
                    <h4><?= htmlentities($model['data']['model_number'], ENT_QUOTES) ?> (<?= htmlentities($model['data']['title'], ENT_QUOTES) ?>)</h4>
                    <p><?= character_limiter($model['data']['content'], 120) ?></p>
                    <p class="more"><a href="products/detail/<?= $model['data']['id'] ?>">More Information &raquo;</a></p>
                </div>
            <? } ?>
			<? if ($pagination != '') { ?>
            <p class="pagination"><?= $pagination ?></p>
            <? } ?>
            
        <? } ?>
            
        </div><!-- Close content -->
<? require ('tpl/footer.php'); ?>