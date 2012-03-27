<? require ('tpl/header.php'); ?>
	<? require ('tpl/menu.php') ?>
        <div id="content">
           
		<style type="text/css">
		.model-image {
			width:160px;
		}
		.middle-container {
			width:auto; /* 480px */
		}
		.prod-model {
			width:480px;
		}
		.prize-cover {
			width:auto;
			overflow:hidden;
			margin-bottom:10px;
		}
		.point-details {
			float:right;
			width:130px;
		}
		.point-details .points {
			background:none repeat scroll 0 0 green;
			border:1px solid #CCCCCC;
			font-size:16px;
			font-weight:bold;
			padding:10px 5px;
			text-align:center;
		}
		</style>
        
        <div class="middle-container">
			<? if ($pagination != '') { ?>
            <p class="pagination"><?= $pagination ?></p>
            <? } ?>
            <h2>Prize Pool</h2>
            <?php
			if (isset($prize_intro))
			{
				echo '<div class="intro-text">', $prize_intro['content'], '</div>';
			}
			
			if (isset($prizes) && is_array($prizes))
			{
				$promotions_cart = $this->session->userdata('promotions_cart');
				if ( ! is_array($promotions_cart))
				{
					$promotions_cart = array();
				}
				foreach ($prizes as $prize)
				{
					#print_r($prize);
					?>
				<div class="prize-cover">
					<div class="point-details common-data-right">
						<p class="points"><?= $prize['points'] ?> Points</p>
						<?php
						if (array_key_exists($prize['id'], $promotions_cart))
						{
							echo 'Already added your list.<br /><a href="myaccount/redeem_points/">Check your list</a>';
						}
						else
						{
							?>
						<a href="myaccount/redeem_points/<?= $prize['id'] ?>/list" class="details">Redeem Now!</a>
							<?php
						}
						?>
					</div>
					<div class="prod-model">
						<? if (isset($prize['images'][0])) { ?>
							<a href="promotions/prizes/<?= $parent_folder . '/' . $prize['id'] ?>"><img src="wpdata/<?= $prize['images'][0]['id'] ?>-m.jpg" class="model-image" title="<?= $prize['images'][0]['title'] ?>" /></a>
						<? } ?>
						<h4><?= htmlentities($prize['title'], ENT_QUOTES) ?></h4>
						<p><?= character_limiter(strip_tags($prize['synopsis'], '<p><br><br />'), 120) ?></p>
							<p class="more">
								<a href="promotions/prizes/<?= $parent_folder . '/' . $prize['id'] ?>">More Information &raquo;</a>
							</p>
					</div>
				</div>
            <?php
				}
			}
			?>
			<? if ($pagination != '') { ?>
            <p class="pagination"><?= $pagination ?></p>
            <? } ?>
            
        </div><!-- close middle content -->
        
		</div><!-- Close content -->
<? require ('tpl/footer.php'); ?>
