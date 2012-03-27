   <? if (isset($news_items) && is_array($news_items) && count($news_items) > 0) {?>
	  <h2>Recent News</h2>
	  <? foreach ($news_items as $item) { ?>
	  <div class="news-item">
		 <h3><?= $item['title'] ?></h3>
		 <?= $item['content'] ?><a href="news/#<?= $item['id'] ?>">more &raquo;</a>
	  </div>
	  <? } ?>
   <? } ?>