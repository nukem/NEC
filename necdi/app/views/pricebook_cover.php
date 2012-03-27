<?php

require ('tpl/header.php');
//require ('tpl/menu.php'); 

$product_types = $this->pricebook_model->get_product_types();
$sql = $this->pricebook_model->get_pb_title();
$title = $sql[0]['title'];
?>
<style type="text/css">
	#cover{
		margin-left: 210px;
		margin-right: 0;
		color: #ffffff;
	}
	#menu .sub_menu_1 span, #menu .sub_menu_1 a
	{
		text-decoration: underline !important;
	}
	#menu .sub_menu_1 a:hover
	{
		background-position: 0 -22px !important;
	}
	.notice{
		color:#999;
	}
	.white{
		background-color: #fff;
		color: #000;
		margin: 0;
		padding: 0;
	}
	
	.contact{
		margin-right:20px;
	}
	
	.contact p{
		margin-bottom: 0px;
	}

	#bg{
		background: url('../includes/images/body_bg_x.gif') repeat-x scroll 0 0;
	}
	#title{
		padding: 20px 20px 20px 0;
	}
	#img{
		background-color: #fff;
		float: left;
	}
	
	h3{
		font-size: 16px;
	}
	
	.pdf-btn {
	background: url('./images/btns-pdf.png') no-repeat 0px 0px !important;
	margin-right: 0 !important;
	}

	.csv-btn {
	background: url('./images/btns-csv.png') no-repeat 0px 0px !important;
	}
	.view-btn {
	background: url('./images/btns-view.png') no-repeat !important;
	}
	.btn {
	display: inline-block !important;
	width: 50px;
	height: 21px;
	padding: 0 !important;
	margin: 10px 5px;
}
.odd
{
	background:none repeat scroll 0 0 #454951;
}
.even
{
	background:none repeat scroll 0 0 #31343A;
}
</style>
<div id="menu">
	<ul class="main_menu">
		<li class="top"><a onclick="return false;" class="head" href="products/detail/71">View / Download</a>
			<ul class="sub_menu_1">
				<li class=" odd">
					<a href="/pricebook/displayPricebook/" onclick="window.open(this.href); return false;">Whole Pricebook</a>
					<a href="/pricebook/displayPricebook/" onclick="window.open(this.href); return false;" class="btn view-btn"></a>
					<a href="/pricebook/getPricebook/" class="btn csv-btn"></a>
				</li>
				<li class=" even"><a href="/pricebook/getCategories/1/" onclick="window.open(this.href); return false;">Projectors</a>
					<a href="/pricebook/getCategories/1/" onclick="window.open(this.href); return false;" class="btn view-btn"></a>
					<a href="/pricebook/getTypePricebook/1/" onclick="window.open(this.href); return false;" class="btn csv-btn"></a>
					<a href="/pricebook/getpdf/" onclick="window.open(this.href); return false;" class="btn pdf-btn"></a>
				</li>
				<li class=" odd"><a href="/pricebook/getCategories/2/" onclick="window.open(this.href); return false;">LCD Desktop Monitors</a>
					<a href="/pricebook/getCategories/2/" onclick="window.open(this.href); return false;" class="btn view-btn"></a>
					<a href="/pricebook/getTypePricebook/2/" onclick="window.open(this.href); return false;" class="btn csv-btn"></a>
					<a href="/pricebook/getpdf2/" onclick="window.open(this.href); return false;" class="btn pdf-btn"></a></li>
				<li class=" even"><a href="/pricebook/getCategories/3/" onclick="window.open(this.href); return false;">LCD Public Displays</a>
					<a href="/pricebook/getCategories/3/" onclick="window.open(this.href); return false;" class="btn view-btn"></a>
					<a href="/pricebook/getTypePricebook/3/" onclick="window.open(this.href); return false;" class="btn csv-btn"></a>
					<a href="/pricebook/getpdf3/" onclick="window.open(this.href); return false;" class="btn pdf-btn"></a></li>
			</ul>
		</li>
    </ul>
</div>
<div id="cover">
	<div style="width:100%;clear;both;float:left">
		<h1 style="color:#6fa2de;">NEC Commercial Display Solutions</h1>
		<h2 style="color:#fff;margin-top:25px;">PRICE BOOK</h2>
		<div style="float:left;font-weight:bold;font-size:12px;"><?= $title?></div><div style="float:right;font-size:12px;font-weight:bold;">Call <span style="color:#6fa2de;font-weight:bold;font-size:12px;">131 632</span> From anywhere in Australia</div>
	</div>
	<div style="clear;both;float:left;margin-top: 20px;">
		<div style="float:left;background:url('./images/pbhead.png') no-repeat;width:637px;height:25px;"></div>
		<div style="float:left;background:url('./images/b.png') repeat-x 0 0 #24272C;padding: 0 30px;width: 577px;">
		<?
		if(isset($news_items))
		{
			$i = 1;
			$last = count($news_items);
			foreach($news_items as $a)
			{
				if($i == 1)
				{
					echo "<h1 style='color:#6fa2de;'>".$a['title']."</h1>";
				}
				else
				{
					echo "<h2 style='color:#6fa2de;margin-top:10px;float: left;'>".$a['title']."</h2>";
				}
				
				if(isset($a['images']) && count($a['images'])>0)
				{
					echo "<div style='float:left;width:577px;padding-right:20px;'><div style='float:left;width:396px;padding-right:20px;'>".$a['content']."</div>";
					echo "<div style='float:left;width:160px;'>";
					foreach($a['images'] as $b)
					{
						echo "<img width='160px' src='./wpdata/".$b['id']."-l.jpg' />";
					}
					echo "</div></div>";
				}
				else
				{
					echo "<div style='float:left;width:577px;padding-right:20px;'>".$a['content']."</div>";
				}
				
				if($i != $last && $last != 1)
				{
					echo "<div style='float:left; width:577px;height:3px;background-color:#333;'></div>";
				}
				$i++;
			}
		}
		?>
		</div>
		<div style="float:left;background:url('./images/c.png') no-repeat;width:637px;height:16px;"></div>
		<div style="float:left;width:637px;height:auto;margin-top:10px;">
			<p class="notice">*Price List is private and confidential and subject to NEC Australia
		Standard Terms and Conditions. <BR />Prices and specifications may be subject to change without notice. E&OE.
			</p>
		</div>
	</div>
	<!--<div id="bg">
		<div id="title">
			<h3>NEC Commercial Display Solutions</h3><br /><br />
			<h1>PRICE BOOK</h1>
			<P></P><br />
			<p><a href="/pricebook/getCategories/1/" onclick="window.open(this.href); return false;">Projectors</a></p>
			<p><a href="/pricebook/getCategories/2/" onclick="window.open(this.href); return false;">LCD Desktop Monitors</a></p>
			<p><a href="/pricebook/getCategories/3/" onclick="window.open(this.href); return false;">LCD Public Displays</a></p>
			<!--<p><a href="/pricebook/getCategories/4/" onclick="window.open(this.href); return false;">DVD, LCD & Plasma Television</a></p>
			<p><a href="/pricebook/getCategories/4/" onclick="window.open(this.href); return false;">LCD Public Displays</a></p>-->
			<!--<p><a href="/pricebook/getCategories/5/" onclick="window.open(this.href); return false;">Whitegoods & Aircon</a></p><br />-->
			<!--<p><b><a href="/pricebook/displayPricebook/" onclick="window.open(this.href); return false;">view whole pricebook</a></b></p>
			<p><b><a href="/pricebook/getPricebook/">Download whole pricebook</a></b></p>
			<p><b><a href="/pricebook/getpdf/" onclick="window.open(this.href); return false;">Download Projectors PDF</a></b></p>
			<p><b><a href="/pricebook/getpdf2/" onclick="window.open(this.href); return false;">Download LCD Desktop Monitors PDF</a></b></p>
			<p><b><a href="/pricebook/getpdf3/" onclick="window.open(this.href); return false;">Download Public Displays PDF</a></b></p>
		</div>
	</div>
	<div class="white">
		<div class="contact">
			<br /><P>Call <strong>131 632</strong> From anywhere in Australia</P>
			<P><strong>www.nec.com.au</strong></P>
		</div>
	</div>
	<div id="img">
		<img src="/images/pricebook_cover.jpg" alt="pricebook_cover" width="640px" />
	</div>
	<div class="white">
		<p class="notice">*Price List is private and confidential and subject to NEC Australia
		Standard Terms and Conditions. <BR />Prices and specifications may be subject to change without notice. E&OE.
		</p>
	</div>
	
	<!--<h3><a href="/pricebook/getPricebook/" onclick="window.open(this.href); return false;">view whole pricebook</a>&nbsp;&nbsp;or&nbsp;&nbsp;
	<a href="/pricebook/menu/" onclick="window.open(this.href); return false;">view categories</a></h3>-->
</div>
<?
require ('tpl/footer.php');
?>
