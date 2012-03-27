<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
        <div id="content">
           
        <? if ($common) { ?>
        <div class="common-data-right">
            <h4>Useful Links for this product range</h4>
            <? if ($common['folders']) foreach ($common['folders'] as $cf) { ?>
            <?
            $rf = '';
            $rfl = '';
            ?>
            <?
            if ($d = $this->data_model->get_children($cf['id'], "'article', 'file'")) {
                $rf = ' onclick="$(\'.sd'. $cf['id'] .'\').slideToggle(500); return false;"';
                foreach ($d as $k) {
                    if ($k['type'] = 'file' && $kf = $this->data_model->get_file($k['id'])) {
                        $file = $kf[0];
                        $rfl .= '<a href="webpublisher/file-preview.php?file=' . $file['id'] . '.' . $file['extension'] . '&amp;filename=' . trim(preg_replace('/[^a-z0-9\.]+/i', '_', $file['title']), '_') . '.' . $file['extension'] . '" class="sub-details sd' . $cf['id'] . '" style="display:none;" onclick="window.open(this.href); return false;">' . $file['title'] . '</a>';
                    } else {
                        $rfl .= '<a href="products/detail/' . $k['id'] . '" class="sub-details sd' . $cf['id'] . '" style="display:none;">' . $k['title'] . '</a>';
                    }
                    
                }
            }
            ?>
            <a href="products/detail/<?= $cf['id'] ?>" class="details"<?= $rf ?>><?= $cf['title'] ?></a>
            <?= $rfl ?>
            <? } ?>
            <? if ($common['articles']) foreach ($common['articles'] as $cf) { ?>
            <a href="products/detail/<?= $cf['id'] ?>" class="details"><?= $cf['title'] ?></a>
            <? } ?>
        </div>
        <? } ?>
        
        <div class="middle-container">
			<? if ($pagination != '') { ?>
            <p class="pagination"><?= $pagination ?></p>
            <? } ?>
            <h2><?= htmlentities($current['title'], ENT_QUOTES) ?></h2>
            <? if ($models) foreach ($models as $model) { ?>
                <div class="prod-model">
                    <? if ($model['image']) { ?>
                        <a href="products/detail/<?= $model['data']['id'] ?>"><img src="wpdata/<?= $model['image']['id'] ?>-s.jpg" class="model-image" title="<?= $model['image']['title'] ?>" /></a>
                    <? } ?>
                    <h4><?= htmlentities($model['data']['model_number'], ENT_QUOTES) ?></h4>
					<span style="color:#99ffff;font-weight:bold" >(<?= htmlentities($model['data']['title'], ENT_QUOTES) ?>)</span>
                    <p><?= character_limiter(strip_tags($model['data']['content'], '<p><br><br />'), 100) ?></p>
						<p class="more">
							<a href="products/detail/<?= $model['data']['id'] ?>">More Information &raquo;</a>
							<a style="display: none" class="compare-prod" href="compare/add_item/<?= $model['data']['id'] ?>" rel="<?= $model['data']['id'] ?>" onclick="return processProduct($(this))">Add to Comparison List</a>
						</p>
                </div>
            <? } ?>
			<? if ($pagination != '') { ?>
            <p class="pagination"><?= $pagination ?></p>
            <? } ?>
            
            
            <?php
			// range with no products, just content in the content box
			if (isset($just_content)) {
				echo $just_content;
			} else {
				echo '<!-- HUH.. -->';
			}
			?>
            
        </div><!-- close middle content -->
        
		</div><!-- Close content -->
<? require ('tpl/footer.php'); ?>
