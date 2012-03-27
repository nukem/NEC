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
      <h2 class="bar green"><span><?= $lang[73] ?></span></h2> 
      <form action=".?id=<?= $id ?>" method="post" enctype= "multipart/form-data"> 
        <? //require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct">
			
			<style type="text/css">
			.error {
				color:red;
			}
			.options-email {
				display:none;
				padding-top:10px;
			}
			</style>
			
<script type="text/javascript" language="javascript" src="../includes/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../includes/js/blockui.v2.js"></script>

<script type="text/javascript" language="javascript">
function generate(){
	var pb_cate_value = $('#pb_cate').val();
	if (pb_cate_value == 0) {
		alert('Please select a category!');
		return;
	}
	$.post(
			"/webpublisher/gen_email_file.php",
			{ pb_cate: pb_cate_value },
			function(data){
				if (typeof(data) == 'object') {
					//alert(data.file);
					display_files();
				} else {
					alert('Error creating the file!');
				}
			},
			"json"
		);
}

function display_files(){
	$.get("/webpublisher/read_dir.php",
		  function(data){
			$('#html_files').html(data);
		  }
	);
}

function deleteFile(file, parentDiv){
	$.post(
		"/webpublisher/delete_file.php",
		{file_name: file},
		function(data){
			if (typeof(data) == 'object') {
				if (data.error){
					alert(data.msg);
				} else {
					alert(data.msg);
					$('#'+parentDiv).hide('fast', function(){
						$(this).remove();
					});
				}
			} else {
				alert('Error deleting the file!');
			}
		},
		"json"
	);
}

function insertEmail(file, cate_id){
	
	cate = cate_id;
	
	$.post(
		"/webpublisher/insert_email.php",
		{category:cate, filename:file}
	);
	$('#mailSender').slideDown("slow",
                            function() {
								$('#msg').show();
                                sendEmail();
                                $('#initCounter').fadeOut("slow");
                            });
}

function sendEmail(){
	
	var limit = 30;
	var interval = 1000 * 15;
	
	$.blockUI({message: '<h3>Email sending in progress...</h3>'});
	
	$.post(
		"/webpublisher/send_email.php",
		{count:limit, subject:'NEC Price List'},
		function(data){
			if(typeof(data)=='object'){
				if(data.error){
					alert(data.msg);
				}
				else{
					if(data.msg == 'FINISHED'){
						$('#newResult').fadeOut("slow", function(){
							$('#newResult').html("Sending Complete");
							$('#newResult').fadeIn("slow");
							$('#msg').hide("slow");
						});
						$.unblockUI();
						return;
					}else{
						$('#newResult').fadeOut("slow", function() {
							$('#newResult').html(data.msg);
							$('#newResult').fadeIn("slow", function(){
								setTimeout("sendEmail()", interval);
							});
						});
					}
				}
			}
			else
				alert('Error sending email.');
		   },
		   "json"
	);
	return false;
}

function sendMail(file, email_field){
	
	var addrs = $('#'+email_field).val();
	
	if ($.trim(addrs) == '') {
		alert('Please enter the email addresses in order to send the PriceBook');
		return false;
	}
	
	var addr_array = new Array()
	if(addrs.indexOf(";") == -1)
		addr_array[0] = addrs;
	else
		addr_array = addrs.split(";");
		
	for(var i=0; i<addr_array.length; i++){
		if(!validate(addr_array[i])){
			alert('You input an invalid email address');
			return false;
		}
	}
	
	$.blockUI({message: '<h3>Email sending in progress...</h3>'});
	
	$.post(
		"/webpublisher/sendMail.php",
		{file_name: file, addresses:addrs},
		function(data){
			if(typeof(data)=='object'){
				if(data.error){
					alert(data.msg);
				}
				else{
					if(data.msg == 'FINISHED'){
						$('#mailSender').slideDown("slow",
								function() {
									$('#msg').show();
									$('#initCounter').fadeOut("slow");
									$('#newResult').fadeOut("slow", function(){
									$('#newResult').html("Sending Complete");
									$('#newResult').fadeIn("slow");
									$('#msg').hide("slow");
									});
						 });
						$('#'+email_field).val('');
					}else{
						alert(data.msg);
					}
					$.unblockUI();
				}
			}
			else
				alert('Error sending email');
		},
		"json"
	);
	return false;
	
}

function updateTitle(name){
  var title = $('#title').val();
  title = $.trim(title);
  
  if(title == ''){
	alert('Please input a title first.');
	return false;
  }
  
  $.post(
		"/webpublisher/update_title.php",
		{name : title},
		function(data){
		  if(typeof(data)=='object'){
			if(data.error){
			  alert(data.msg);
			}
			else{
			  alert(data.msg);
			}
		  }
		  else{
			alert('Error updating title!');
		  }
		},
		"json"
	);
	return false;
}

function validate(email){
	
		email = $.trim(email);
        var apos = email.indexOf('@');
        var dotpos = email.indexOf("."); 
		if (apos==-1||dotpos ==-1) {
            return false;   
        } else if (apos<1) {
            return false;
        } else if (apos == email.length-1){
            return false;
        } else {
            return true;     
       }
	
}


$(function(){
	display_files();
});
</script>
<?php

    require_once('price_book/upload.php');
	require_once('price_book/db_connection.php');
	
	$projector = "Projector";
	$whiteboard = "LCD Desktop Monitors";
	//$display = "Commercial Flat Panel Display";
	$display = "LCD Public Displays";
	$lcd = "LCD & Plasma Television";
	$whitegoods = "Whitegoods";
     
    
    if(isset($_POST['action']) && count($_POST['action'])>0){
		
	  
		if(isset($_POST['title']) && trim($_POST['title'])!= ''){
		  
		    			
			if(isset($_FILES['userfile1']) && is_uploaded_file($_FILES['userfile1']['tmp_name'])&&
			   isset($_FILES['userfile2']) && is_uploaded_file($_FILES['userfile2']['tmp_name'])&&
			   isset($_FILES['userfile3']) && is_uploaded_file($_FILES['userfile3']['tmp_name'])){
			   //isset($_FILES['userfile4']) && is_uploaded_file($_FILES['userfile4']['tmp_name'])&&
			   //isset($_FILES['userfile5']) && is_uploaded_file($_FILES['userfile5']['tmp_name'])){
			
			  $con = new Db_connection();
			  $con->truncate_table();
			
			  
			  if(isset($_FILES['userfile1']) && is_uploaded_file($_FILES['userfile1']['tmp_name'])){
				  $obj_upload = new Upload($_FILES['userfile1'],$_POST['fname1'],trim($projector));    // $_POST['fname1'] = 'projector'
				  $obj_upload->load_file();
				  
				  echo 'PROJECTOR ';
			  }
			  
			  
			  if(isset($_FILES['userfile2']) && is_uploaded_file($_FILES['userfile2']['tmp_name'])){
				  
				  $obj_upload = new Upload($_FILES['userfile2'],$_POST['fname2'],trim($whiteboard));  // $_POST['fname2'] => 'whiteboard'; // LCD Desktop Monitors
				  $obj_upload->load_file();
				  
				  echo '- DISP 1 ';
			  }
			  
			  
			  if(isset($_FILES['userfile3']) && is_uploaded_file($_FILES['userfile3']['tmp_name'])){
				  
				  $obj_upload = new Upload($_FILES['userfile3'],$_POST['fname3'],trim($display));  // $_POST['fname3'] => 'panel_display';
				  $obj_upload->load_file();
				  
				  echo '- DISP 2 ';
			  }
			  
			  
			  /*if(isset($_FILES['userfile4']) && is_uploaded_file($_FILES['userfile4']['tmp_name'])){
				  
				  $obj_upload = new Upload($_FILES['userfile4'],$_POST['fname4'],trim($lcd));
				  $obj_upload->load_file();
			  }
			  
			  
			  if(isset($_FILES['userfile5']) && is_uploaded_file($_FILES['userfile5']['tmp_name'])){
				  
				  $obj_upload = new Upload($_FILES['userfile5'],$_POST['fname5'],trim($whitegoods));
				  $obj_upload->load_file();
			  }*/
			  
			  if (isset($con)) unset($con);
			  
			  $con = new Db_connection();
			  $con->update_pricebook_title($_POST['title']);
			  
			  print "<font color='green'>Files have been successfully uploaded !</font><br /><br />";
			}
			else{
			  print '<p class="error">Error! You need to upload all the data files to the server.</p>';
			}
		}
		else{
		  print '<p class="error">Please input a title for new price book.</p>';
		}
    }
?>

            <h1>Upload Price Book</h1>
			<br /><br />
			
			<table class="rec-table">
				  
				  <tr>
					<td colspan="2"><label>Please input a date for this pricebook (eg. 20 Dec 2009)&bull;</label>
						<input class="textfield width-100pct"  type="text" name="title" id="title" />
						<input type="button" value="Save Name" onclick="updateTitle();" />
						<br /><br /></td>
					<td>&nbsp;</td>
				  </tr>
				  
				  <tr>
					<td><label>Upload Projector Price List&bull;</label><br />
						<input type="file" name="userfile1" />
						<input type="hidden" name="fname1" value="projector" /></td>
					   
				  				  		
					<td><label>Upload LCD Desktop Monitors Price List&bull;</label><br />
						<input type="file" name="userfile2" />
						<input type="hidden" name="fname2" value="whiteboard" /></td>
					   
				  
				  
				  
					<td><label>Upload Flat Panel Displays Price List&bull;</label><br />
						<input type="file" name="userfile3" />
						<input type="hidden" name="fname3" value="panel_display" /></td>
					   
				  	<td>&nbsp;</td>		  				  			  
					<!--<td><label>Upload LCD & Plasma Television Price List&bull;</label><br />
						<input type="file" name="userfile4" />
						<input type="hidden" name="fname4" value="lcd" /></td>-->
					   
				  </tr>
				  				  
				  <tr>
					<!--<td><label>Upload Whitegoods Price List&bull;</label><br />
						<input type="file" name="userfile5" />
						<input type="hidden" name="fname5" value="whitegoods" /></td>-->
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
			
			</table>
			<br /><br />
			<div><input type="submit" value="upload" name="action" /></div>
			<br /><br />			
			<? //if(isset($_POST['action'])){ ?>
				  <a href='../pricebook/' onclick="window.open(this.href); return false;">View Price List</a><br /><br />
			<?
			   //}
			?>
			
					<h1>Email Price Book</h1><br /><br />
					<table class="rec-table"><tr>
					<td><label>Select one dealer type</label>
					<select id = "pb_cate">
					<option value="0">Select one dealer category</option>
				  <?
					  $pricebook_cats = dbq('SELECT * FROM nec_dealer');
					  if(count($pricebook_cats) != 0){
						for($i=0; $i<count($pricebook_cats); $i++){
				  ?>
							<option value="<?= $pricebook_cats[$i]['id']?>"><?= $pricebook_cats[$i]['dealer_type']?></option>
				  <?	
						}
					  }
				  ?>
				  </select></td>
				  <td colspan='3'><input type="button" name="email" value="Generate Price List" onclick="generate();" /></td>
				  </tr>
				  </table>
			<br />
			<!-- display generated html files -->
			
			<div id="html_files"></div>
			
			<!-- end of display html files-->

          </div> 
        </div>
	  </form>
    </div> 
    <? require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
