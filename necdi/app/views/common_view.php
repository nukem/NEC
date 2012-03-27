<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
    <? require ('tpl/news.php') ?>
        <div id="content">
        <h2><?= $content_title ?></h2>
        <?= $content_data ?>
		</div><!-- Close content -->
<? require ('tpl/footer.php'); ?>