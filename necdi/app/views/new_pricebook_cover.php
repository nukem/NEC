<?php
error_reporting(E_ALL);
require ('tpl/header.php');

$product_types = $this->pricebook_model->get_product_types();
$sql = $this->pricebook_model->get_pb_title();
$title = $sql[0]['title'];

$article = $this->news_model->get_article_details(4226);
?>
<style type="text/css">
	#cover{
		margin-left: 210px;
		margin-right: 0;
		color: #ffffff;
		text-align: left ;
	}
	
	.notice{
		font-size: 9px;
		text-align:left;
		padding:0 5px;
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

	#title{
		padding: 10px 20px 20px 0;
	}
	#img{
		background-color: #fff;
		float: left;
	}
	
	h3{
		font-size: 16px;
	}

.pricebook-content {
	padding:  30px 40px;
	background: #2B2D31;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

.btn {
	display: inline-block !important;
	width: 50px;
	height: 21px;
	padding: 0 !important;
	margin: 10px 5px 10px 0;
}

.btn:hover {
	background-position: 0 -22px;
}

.pdf-btn {
background: url('./images/btns/pdf.png') !important;
margin-right: 0 !important;
}

.csv-btn {
background: url('./images/btns/csv.png') !important;
}
.view-btn {
background: url('./images/btns/view.png') !important;
}
h1, h2, h3 {
	color: #6FA2DE;
margin-bottom: 20px;
}

p.title {
	font-size: 14px;
	float: left;
}

p.call {
	float: right;
	font-size: 14px;
}
p.call span {
	color:#6FA2DE;
	font-weight: bold;
}

.ofh {
	overflow: hidden;
}
.nec-heading {
color: #fff;
}

#menu .sub_menu_1 span {
	text-indent: 5px;
}

</style>

<div id="menu">
	<ul class="main_menu">
		<li class="top">
			<a href="#">View / Download</a>
			<ul class="sub_menu_1">
				<li class=" odd">
					<span>
						Whole Pricebook<br />
						<a href="/pricebook/displayPricebook/" onclick="window.open(this.href); return false;" class="btn view-btn"></a>
						<a href="/pricebook/getPricebook/" class="btn csv-btn"></a>
					</span>
				</li>
				<li class=" even">
					<span>Projectors<br />
					<a href="/pricebook/getCategories/1/" onclick="window.open(this.href); return false;" class="btn view-btn"></a>
					<a href="/pricebook/getTypePricebook/1/" onclick="window.open(this.href); return false;" class="btn csv-btn"></a>
					<a href="/pricebook/getpdf/" onclick="window.open(this.href); return false;" class="btn pdf-btn"></a>
</span>
				</li>
				<li class=" odd">
					<span> LCD Public Displays<br />
					<a href="/pricebook/getCategories/3/" onclick="window.open(this.href); return false;" class="btn view-btn"></a>
					<a href="/pricebook/getTypePricebook/3/" onclick="window.open(this.href); return false;" class="btn csv-btn"></a>
					<a href="/pricebook/getpdf3/" onclick="window.open(this.href); return false;" class="btn pdf-btn"></a>
</span>
				</li>
				<li class=" even">
					<span> LCD Desktop Displays<br />
					<a href="/pricebook/getCategories/2/" onclick="window.open(this.href); return false;" class="btn view-btn"></a>
					<a href="/pricebook/getTypePricebook/2/" onclick="window.open(this.href); return false;" class="btn csv-btn"></a>
					<a href="/pricebook/getpdf2/" onclick="window.open(this.href); return false;" class="btn pdf-btn"></a>
</span>
				</li>
			</ul>
		</li>
	</ul>
</div>

<div id="cover">
	<div id="title">
		<h1 class="nec-heading">NEC Commercial Display Solutions</h1>
		<h1>PRICE BOOK</h1>
		<div class="ofh">
			<P class="title"> <?= $title?></P>
			<p class="call">Call <span>131 632</span> from anywhere in Australia</p>
		</div>
		<div class="pricebook-content">
			<h2><?php echo $article['title']; ?></h2>
			<?php echo $article['content']; ?>
		</div>
<? /* ?>
		<p><a href="/pricebook/getCategories/1/" onclick="window.open(this.href); return false;">Projectors</a></p>
		<!--p><a href="/pricebook/getCategories/2/" onclick="window.open(this.href); return false;">Interactive Whiteboard</a></p-->
		<p><a href="/pricebook/getCategories/3/" onclick="window.open(this.href); return false;">LCD & Plasma Displays</a></p>
		<!--<p><a href="/pricebook/getCategories/4/" onclick="window.open(this.href); return false;">DVD, LCD & Plasma Television</a></p>
		<p><a href="/pricebook/getCategories/5/" onclick="window.open(this.href); return false;">Whitegoods & Aircon</a></p><br />-->
		<p><b><a href="/pricebook/displayPricebook/" onclick="window.open(this.href); return false;">view whole pricebook</a></b></p>
		<p><b><a href="/pricebook/getPricebook/">Download whole pricebook</a></b></p>
		<p><b><a href="/pricebook/getpdf/" onclick="window.open(this.href); return false;">Download Projectors PDF</a></b></p>
		<!--p><b><a href="/pricebook/getpdf2/" onclick="window.open(this.href); return false;">Download Whiteboard PDF</a></b></p-->
		<p><b><a href="/pricebook/getpdf3/" onclick="window.open(this.href); return false;">Download LCD & Plasma Display PDF</a></b></p>
<? //*/ ?>
	</div>
		<p class="notice">*Price List is private and confidential and subject to NEC Australia
		Standard Terms and Conditions. <BR />Prices and specifications may be subject to change without notice. E&OE.
		</p>
	
	<!--<h3><a href="/pricebook/getPricebook/" onclick="window.open(this.href); return false;">view whole pricebook</a>&nbsp;&nbsp;or&nbsp;&nbsp;
	<a href="/pricebook/menu/" onclick="window.open(this.href); return false;">view categories</a></h3>-->
</div>
<?
require ('tpl/footer.php');
?>
