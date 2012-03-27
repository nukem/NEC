<? require ("tpl/inc/head.php"); ?>
<body> 
<div id="page"> 
	<? require ("tpl/inc/header.php"); ?> 
	<? require ("tpl/inc/path.php"); ?> 
	<div id="content"> 
		<div id="left-col"> 
			<div id="left-col-border"> 
				<? if (isset ($errors)) require ("tpl/inc/error.php"); ?> 
				<? if (isset ($messages)) require ("tpl/inc/message.php"); ?> 
				<? if (isset ($_SESSION['epClipboard'])) require ("tpl/inc/clipboard.php"); ?> 
				<? require ("tpl/inc/structure.php"); ?> 
			</div> 
		</div> 
		<div id="right-col"> 
			<h2 class="bar green"><span><?= $lang[58] ?></span></h2> 
			<form action=".?id=<?= $id ?>" method="post" enctype="multipart/form-data" > 
				<? require ("tpl/inc/buttons.php"); ?> 
				<div class="right-col-padding1"> 
					<div class="width-99pct"> 
						<table class="rec-table"> 
							<? require ("tpl/inc/record.php"); ?> 
							<tr>
								<td colspan="4">
									<label for="model_number">Description</label><br />
									<input type="text" name="model_number" value="<? if (isset ($_POST['model_number'])) echo htmlspecialchars ($_POST['model_number']); else echo htmlspecialchars ($record['model_number']); ?>" id="model_number" class="width-100pct textfield" />
								</td>
							</tr>
							<tr>
								<td colspan="4"> 
									<label><?= $lang[59] ?></label><br />
									<textarea name="content" cols="30" rows="15" class="width-100pct textfield tinymce"><? if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['content']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['content'])); ?></textarea>
								</td> 
							</tr>
							<? require ("tpl/inc/rights.php"); ?> 
						</table> 
					</div> 
				</div> 
			</form> 
		</div> 
		<? require ("tpl/inc/footer.php"); ?> 
	</div> 
</div> 
</body>
</html>
