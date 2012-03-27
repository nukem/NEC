<? require ('tpl/header.php'); ?>
	<div id="content" class="compare-content">

<?php

$i = 1;
foreach($product_data as $p) {
	$last = '';
	if($i++ % 3 == 0) {
		$last = 'last-compare';
	}
	$p['specs']['content'] = preg_replace('/width=".+?"/', '', $p['specs']['content']);
	echo <<<HTML
		<div class="compare-item {$last}">
			<h2><a href="products/detail/{$p['id']}">{$p['title']}</a></h2>
			<img src="wpdata/{$p['image']['id']}-s.jpg" />
			<h3>Product Specs</h3>
			<div class="compare-specs">
				{$p['specs']['content']}
			</div>
		</div>
HTML;
}
?>

	</div><!-- Close content -->
<? require ('tpl/footer.php'); ?>
