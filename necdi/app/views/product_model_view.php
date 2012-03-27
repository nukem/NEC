<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
    <? require ('tpl/news.php') ?>
        <div id="content">
        <? if ($common || ($model && is_array($model['images']))) { ?>
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
                        $rfl .= '<a href="webpublisher/file-preview.php?file=' . $file['id'] . '.' . $file['extension'] . '&amp;filename=' . preg_replace('/[^a-z0-9\.]+/i', '_', $file['title']) . '.' . $file['extension'] . '" class="sub-details sd' . $cf['id'] . '" style="display:none;" onclick="window.open(this.href); return false;">' . $file['title'] . '</a>';
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
            <p>&nbsp;</p>
            <? if ($model && is_array($model['images'])) foreach ($model['images'] as $mi) { ?>
                <a href="wpdata/<?= $mi['id'] ?>-l.jpg" title="<?= $mi['title'] ?>" class="light-box"><img src="wpdata/<?= $mi['id'] ?>-s.jpg" class="model-image-range" title="<?= $mi['title'] ?>" /></a>
            <? } ?>
        </div>
        <? } ?>
        <? if ($model) { ?>
        
        <div class="middle-container">
            <h2><?= htmlentities($model['data']['model_number'], ENT_QUOTES) ?></h2>
            <h2 style="color:#99ffff">(<?= htmlentities($model['data']['title'], ENT_QUOTES) ?>)</h2>
            <div class="prod-panel">
                <?= $model['data']['content'] ?>
            </div>
            <?
            if (count($model['articles']) > 0 || count($model['downloads']) > 0) { ?>
                
                <ul class="tab-session">
                <? if (count($model['articles']) > 0) foreach ($model['articles'] as $td) { ?>
                    <li><a href="<?= $this->uri->uri_string() ?>#ctab-<?= $td['id'] ?>"><?= $td['title'] ?></a></li>
                <? } ?>
				<? if (count($model['downloads']) > 0) { ?>
                    <li><a href="<?= $this->uri->uri_string() ?>#ctab-download">Downloads</a></li>
                <? } ?>
                </ul>
                
                <? if (count($model['articles']) > 0) foreach ($model['articles'] as $td) { ?>
				<div class="tab-<?php echo $td['uri'];?>" id="ctab-<?= $td['id'] ?>">
                <?= $td['content'] ?>
                </div>
                <? } ?>
				
				<? if (count($model['downloads']) > 0) { ?>
                <div id="ctab-download">
                    
                    <div>
                        <?
                        $file_type = '';
                        echo '<table>'."\n";
                            
                            foreach ($model['downloads'] as $md) {
                                
                                foreach ($md as $file) {
                                    if($file['file_type'] != $file_type && is_file('wpdata/'.$file['title'].".".$file['extension'])){
                                        echo '<tr><td colspan="2" style="padding-top: 10px;"><label>'.$file['file_type'].'</label></td></tr>';
                                    }
                                    
                                    $file_type = $file['file_type'];
                                    
                                    echo '<tr><td style="width: 260px;">'."\n";
                                    
                                    if(is_file('wpdata/'.$file['title'].".".$file['extension'])){ ?>
                                        <p><img src="webpublisher/img/ico-file/<? if(is_file("webpublisher/img/ico-file/{$file['extension']}.gif")) echo "{$file['extension']}.gif"; else echo "unknown.gif"; ?>" alt="Preview" width="16" height="16" /> <a href="webpublisher/file-preview.php?file=<?= $file['title'].'.'.$file['extension'] ?>&amp;filename=<?= preg_replace('/[^a-z0-9\.]+/i', '_', $file['file_name']) ?>"><?= $file['file_name'] ?></a></p>
                                    <?
                                        
                                        echo '</td>'."\n".'<td>';
                                        
                                        echo '&nbsp;';
                                        
                                        echo '</td></tr>'."\n";
                                    }
                                }
                            }
                        
                        echo '</table>'."\n";
                        ?>
                    </div>
                    
                </div>
                <? } ?>
                
                <script type="text/javascript">
                $(function(){
                    $(".tab-session").tabs();
					$('a.light-box').lightBox({fixedNavigation:true, overlayBgColor:'#193264'});
                });
                </script>
                
            <? } ?>
            
         	</div>
            
        <? } ?>
		</div><!-- Close content -->
<? require ('tpl/footer.php'); ?>
