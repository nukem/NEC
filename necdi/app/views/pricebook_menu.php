<?php
require ('tpl/header.php');
//require ('tpl/menu.php'); 


$product_types = $this->pricebook_model->get_product_types();
$sql = $this->pricebook_model->get_pb_title();
$title = $sql[0]['title'];
?>
<style type="text/css">

.pb_menu {
    
    font-size: 14px;
    color: #465478;
    font-family: sans-serif;
    font-weight: bold;
}
.pb_menu ul {
    padding: 5px;
    font-size: 20px;
}

.pb_menu li{
    list-style: none;
    padding: 2px;
    
}

.pb_menu li ul li{
    padding-left:20px;
}

.no-underline{
    text-decoration: none;
    font-size: 12px;
    font-weight: normal;
    color: #ffffff;
}

.no-underline:hover{
    text-decoration: underline;
}

.blue {
    color: #465478;
    font-weight: bolder;
}

.title{
    
}

</style>
<h1 class="title"><?= $title ?> Price Book Categories</h1>
<br />
<div class="pb_menu">

<ul>
<?
//foreach($product_types as $type){
    //$type_name = $type['type_name'];
    //$type_id = $this->pricebook_model->getTypeId($type_name);
    $type_name = $name;
    $type_id = $id;
?>
    <li class='p_type'><?= $type_name?>
<?
    $categories = $this->pricebook_model->get_categories($type_name);
?>
    <ul>
<?
    foreach($categories as $cate){
        $cate_name = $cate['cate_name'];
        $src = "/pricebook/generateTable/".$type_id."/".$cate['id'];
?>
        <li><a class="no-underline" href='<?= $src ?>' onclick="window.open(this.href); return false;"><?= $cate_name?></a></li>
<?
    }
?>
    <li><b><a class="no-underline blue" href="/pricebook/getTypePricebook/<?= $type_id?>/">Download <?= $type_name?> Pricebook</a></b></li>
    </ul></li>
<?
//}
?>
</ul>
</div>
<?
require ('tpl/footer.php');
?>