   <? if (isset($news_items) && is_array($news_items) && count($news_items) > 0) {?>
   <div id="news_panel">
	  <h2>Recent News</h2>
	  <?php
	  $i = 0;
	  foreach ($news_items as $item)
	  {
		 if ($i < 4)
		 {
			?>
	  <div class="news_item">
		 <h3><a href="news/item/<?= $item['id'] ?>"><?= $item['title'] ?></a></h3>
		 <p><?= strip_tags(character_limiter($item['content'], 240)) ?></p><p><a href="news/item/<?= $item['id'] ?>">read more...</a></p>
	  </div>
	  <?php
		 }
		 $i++;
	  }
	  ?>
   </div>
   <? } ?>