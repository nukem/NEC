<?

$cfg['db']['address'] = "localhost";
$cfg['db']['username'] = "neccd_db";
$cfg['db']['password'] = "qwerty123#";
$cfg['db']['name'] = "neccd_db";
$cfg['db']['prefix'] = "wp";

$cfg['wysiwyg_base_uri'] = "../";

$cfg['data'] = "../wpdata/";

$mce_type[] = 'article';
$mce_type[] = 'model';
$mce_type[] = 'faq';
$mce_type[] = 'range';
$mce_type[] = 'press';
$mce_type[] = 'prize';

$cfg['img']['small'] = array (150, 100, 'fit', false, 100, 0xFF, 0xFF, 0xFF);
$cfg['img']['medium'] = array (280, 200, 'shrink', false, 100, 0xFF, 0xFF, 0xFF);
$cfg['img']['large'] = array (600, 400, 'shrink', false, 100, 0xFF, 0xFF, 0xFF);

if(preg_match('/^(localhost|computer\.local|192.168.0.6)/', $_SERVER['HTTP_HOST'])){
	$cfg['db']['address'] = "localhost";
	$cfg['db']['username'] = "root";
	$cfg['db']['password'] = "root";
	$cfg['db']['name'] = "nec";
}
?>
