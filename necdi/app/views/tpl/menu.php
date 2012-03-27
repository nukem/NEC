<?
/*
 * select the array of webpublisher items
 * that is available to the current users' category
 */
$acl = array();
if ($current_user['category_fk'] == 181) {
   $acl_q = $this->db->query("SELECT `id` AS `link`
                              FROM `wp_structure`");
} else {
   $acl_q = $this->db->query("SELECT `link`
                              FROM `nec_permissions`
                              WHERE `category_fk` = '{$current_user['category_fk']}'");
}

if ($acl_q->num_rows() > 0) {
   foreach($acl_q->result_array() as $acl_row) {
      $acl[] = $acl_row['link'];
   }
}

//echo '<!--'.print_r($current_user, true).'-->';

$products = $this->data_model->get_data_set(array(71), 2);

$promotions = $this->data_model->get_data_set_m(array(637), 2);

$media = $this->data_model->get_data_set_m(array(81), 2);

$prizes_menu = $this->data_model->get_data_set_m(array(3858), 2);

$promotions[0]['child_set'][] = $prizes_menu[0];

/*
echo '<!--'.print_r($promotions, true).'-->';
echo '<!--'.print_r($prizes, true).'-->';
echo '<!--'.print_r($media, true).'-->';
*/

/*
 * get the whole product set and the permissions list
 * and output the menu
 */
function outputMenu($items, $perm, $uri = 'products', $sub = 1) {
   $menu = '';
   $num = 1;
   foreach ($items as $item) {
      
      if ($sub > 2 || in_array($item['id'], $perm)) {
         
         $class = $dash = '';
         $top_cats = ' onclick="return false;"';
		 if ($sub == 1) {
		 	$class .= 'top';
		 }
         if ($sub > 1) {
            $class .= ($num % 2) ? ' odd' : ' even';
            $top_cats = '';
         }
		 if ($sub > 2) {
		 	$dash = '- ';
		 }
         
		 if ($uri == 'prizes')
		 {
			$menu .= '<li class="' . $class . '"><a href="promotions/prizes/' . $item['id'] . '" class="head"' . $top_cats . '>' . $dash . $item['title'] . '</a>' . "\n";
		 }
		 else if($item['id'] == '2258')
		 {
			$menu .= '<li class="' . $class . '"><a href="pricebook" class="head"' . $top_cats . '>' . $dash . $item['title'] . '</a>' . "\n";
		 }
		 else
		 {
			$menu .= '<li class="' . $class . '"><a href="'. $uri .'/detail/' . $item['id'] . '" class="head"' . $top_cats . '>' . $dash . $item['title'] . '</a>' . "\n";
		 }
         
		 if (isset($item['child_set']) && count($item['child_set'])) {
			$new_uri = $uri;
			if ($item['id'] == 3858) # uh oh - prizes
			{
			   $new_uri = 'prizes';
			}
            $menu .= '<ul class="sub_menu_' . $sub . '">' . "\n";
            $menu .= outputMenu($item['child_set'], $perm, $new_uri, $sub+1);
            $menu .= '</ul>' . "\n";
         }
         $menu .= '</li>' . "\n";
         
      }
      $num++;
   }
   return $menu;
}
?>

<div id="menu">
	  <ul class="main_menu">
      <?= outputMenu($products, $acl, 'products') ?>
      <?= outputMenu($promotions, $acl, 'promotions') ?>
      <?= outputMenu($media, $acl, 'media') ?>
      </ul>
</div>

<script type="text/javascript">
   var current_web_id = 0;
   var parent_web_id = 0;
   <?
   if ($this->uri->segment(3)) {
	  $current_web_id = $this->uri->segment(3);
	  $parent_web_id = 0;
	  $uq = $this->db->query("SELECT `parent` FROM `wp_structure` WHERE `id` = '{$current_web_id}'");
	  if ($uq->num_rows() > 0) {
		 $urlq = $uq->result_array();
		 $parent_web_id = $urlq[0]['parent'];
	  }
	  echo "current_web_id = '{$current_web_id}';\n";
	  echo "parent_web_id = '{$parent_web_id}';\n";
   }
   ?>
   
   
  $(function(){
      $('.main_menu ul ul').each(function(){
         $(this).hide().siblings('a').click(function(){
                     $(this).siblings('ul').slideToggle(500);
                     $('.sub_menu_2').not($(this).siblings('ul')).slideUp(500);
                     return false;
                  });
		 var activeUL = false;
		 $('li a', $(this)).each(function(){
			if (this.href.indexOf('/detail/'+current_web_id) >= 0 || this.href.indexOf('/detail/'+parent_web_id) >= 0 || this.href.indexOf('/prizes/'+current_web_id) >= 0) {
			   activeUL = true;
			   $(this).html($(this).html() + ' &raquo;').addClass('selected');
			}
		 });
		 if (activeUL == true) $(this).css('display', 'block');
      });
   }); 
</script>
