<?
$pricebook_cats = dbq('SELECT * FROM nec_dealer');
?>
<style type="text/css">
			
table#users {
	margin-top: 20px;
	font-size: 11px;
}
#users th {
	text-align: left;
	background: #E1E7EA;
}
#users th.over {
	background: #ccc;
}
#users td, #users th {
	border: 1px solid #CCCCCC;
	border-collapse: collapse;
	padding: 4px 4px;
}
.approvebox {
	text-align: center;
}
.approvebox input {
	margin: 0;
	width: 13px;
	height: 13px;
	overflow: hidden;
}

.user-table tr.odd {
	background-color:#F8F8F8;
}
.user-table td a {
	cursor:pointer;
}
.user-table th {
	cursor:pointer;
}
.pager {
	height:20px;
}
.pager a {
	font-size:12px;
	color:#fff;
	text-decoration:none;
	display:block;
	background:#999;
	border:1px solid #666;
	padding:2px 5px;
	width: 36px;
}
.pager a:hover {
	color:#333;
	background:#f2f2f2;
	border:1px solid #666;
}
.pager .pagedisplay {
	width:60px;
}
.pager td {
	padding:4px ;
	padding-right: 12px !important;
}

#approve-user, #ajax-edit-user {
    display:none;
	padding:12px;
}
#approve-user .controls, #ajax-edit-user .controls {
    display:none;
}
#approve-user .controls .errors, #ajax-edit-user .controls .errors {
    display:none;
    color:red;
    margin-top:0;
}
#approve-user .controls .reject-user {
    display:none;
    margin-top:10px;
}
#approve-user .controls .reject-user textarea {
    width:500px;
    height:120px;
    margin-bottom:10px;
}
#approve-user .user-content table, #ajax-edit-user .user-content table {
    width:625px;
    margin-bottom:10px;
	border-collapse:collapse;
}
#approve-user .user-content td, #ajax-edit-user .user-content td {
    text-align:left;
	padding:4px;
	border-collapse:collapse;
	border:1px solid #ccc;
}

#ajax-edit-points,
.point-history, .point-processing, .point-content {
	display:none;
}
.point-content {
	overflow:hidden;
	width:auto;
}
.add-points {
	float:left;
	text-align:left;
}
.close-points {
	float:right;
}
.point-balance {
	color:steelBlue;
	font-size:14px;
	font-weight:bold;
	padding-bottom:15px;
}
.point-balance span {
	color:green;
}

.point-history-table {
	width:590px;
	margin:10px auto 0;
}
.point-history-table, .point-history-table td, .point-history-table th {
	border-collapse:collapse;
	border:1px solid #888;
}
.point-history-table th {
	background:#ccc;
	color:#fff;
}
.point-history-table td, .point-history-table th {
	padding:5px;
}
#search-box {
	padding:0;
	margin:0;
	line-height: 1.3em;
}
#search-box button {
	padding-top: 4px;
}
.popover-content ul {
	padding: 4px 21px;
}
.popover-content ul li{
	color: #000;
}
.popover-content ul li span {
	display: inline-block;
	width: 80px;
}
.popover-content ul li strong{
	display: inline-block;
}
.popover {
	padding:4px;
}
</style>
			
            <p style="float:right;padding:8px 5px 0 0;"><a href="addNewUser" onclick="editUser(); return false;">Add New User</a></p>

			<div id="pager" class="pager">
                <table cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td class="nav"><a href="#" class="first">&laquo; first </a></td>
                        <td class="nav"><a href="#" class="prev">&lt; prev </a></td>
                        <td class="paging"><input type="text" class="pagedisplay grey_input"/></td>
                        <td class="nav"><a href="#" class="next">next &gt;</a></td>
                        <td class="nav"><a href="#" class="last">last &raquo;</a></td>
                        <td class="nav"><select class="pagesize select-box">
                            <option selected="selected"  value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option  value="40">40</option>
                        </select></td>
                    </tr>
                </table>
			</div>			
 <div id="search-box">
 <?php $page_id = intval($_GET['id']);?><br>
 </div>
			<div id="pager" class="pager">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
				<!-- Do the search bar -->
					<tr>
					<td><input type='text' onblur="if(this.value == '') { this.value = 'Enter Dealer No.'; }" onfocus="if(this.value == 'Enter Dealer No.') { this.value = ''; }" value='Enter Dealer No.' name='getuserid' style='width:95% !important;'></td>
					<td><input type='text' onblur="if(this.value == '') { this.value = 'Enter Company'; }" onfocus="if(this.value == 'Enter Company') { this.value = ''; }" value='Enter Company' name='getcompany' style='width:95% !important;'></td>
					<td><input type='text' onblur="if(this.value == '') { this.value = 'Enter Name'; }" onfocus="if(this.value == 'Enter Name') { this.value = ''; }" value='Enter Name' name='getname' style='width:95% !important;'></td>
					<td><input type='text' onblur="if(this.value == '') { this.value = 'Enter Phone'; }" onfocus="if(this.value == 'Enter Phone') { this.value = ''; }" value='Enter Phone' name='gettelephone' style='width:95% !important;'></td>
					<td><input type='text' onblur="if(this.value == '') { this.value = 'Enter Email'; }" onfocus="if(this.value == 'Enter Email') { this.value = ''; }" value='Enter Email' name='getemail' style='width:95% !important;'></td>
					<td><input type='text' onblur="if(this.value == '') { this.value = 'Enter State'; }" onfocus="if(this.value == 'Enter State') { this.value = ''; }" value='Enter State' name='getstate' style='width:95% !important;'></td>
					<td><input type="submit" name="searchuser" value="Search" /></td>
                </table>
			</div>			
			<?php
				echo '<table width="100%" cellpadding="0" cellspacing="0" id="users" class="user-table">'."\n";
				echo '<thead>'."\n" . '<tr>' ."\n";
				echo '<th>Dealer No. (Last Login)</th>'."\n";
				echo '<th>Company</th>'."\n";
				echo '<th>Contact Name</th>'."\n";
				echo '<th>Phone</th>'."\n";
				echo '<th>Email</th>'."\n";
				echo '<th>State</th>'."\n";
				echo '<th>Actions</th>'."\n".'</tr>'."\n".'</thead>'."\n";
				echo "<tbody>\n";
				
				foreach($dealers as $dealer){
					$logininfo = '';
					if(!empty($dealer['last_login']) && ($dealer['last_login'] != '0000-00-00 00:00:00'))
					{
						$logininfo = '  (' . date('j/M/Y', strtotime($dealer['last_login'])) . ')';
					}
					echo '<tr id="utr-'.$dealer['userid'].'">'."\n";
?>
					<td id="utdn-<?php echo $dealer['userid'];?>" style="display:relative;">
						<?php echo $dealer['dealer_no'] . $logininfo;?>					
					</td>
<?php
				    echo '<td>'.$dealer['company'].'</td>'."\n";
					echo '<td>'.$dealer['name'].'</td>'."\n";
					echo '<td>'.$dealer['telephone'].'</td>'."\n";
					echo '<td>'.$dealer['email'].'</td>'."\n";
					echo '<td>'.$dealer['state'].'</td>'."\n";
					
					if ($dealer['approved'] == 0) {
						echo '<td id="utd-'.$dealer['userid'].'"><a onclick="getApproval('.$dealer['userid'].')">Approve</a></td>'."\n";
					} else if ($dealer['category_fk'] != 181) {
						echo '<td id="utd-'.$dealer['userid'].'"><a onclick="editUser('.$dealer['userid'].')">Edit</a> | <a onclick="deleteExistingUser('.$dealer['userid'].')">Delete</a></td>'."\n";
					} else {
                        echo '<td id="utd-'.$dealer['userid'].'"><a onclick="editUser('.$dealer['userid'].')">Edit</a> | Admin</td>';
                    }
					
					echo "</tr>\n";
					
				}
				
				echo '</tbody>'."\n".'</table>'."\n";
			
			?>
			<script type="text/javascript" language="javascript" src="../includes/js/jquery.js"></script>
			<script type="text/javascript" language="javascript" src="../includes/js/blockui.v2.js"></script>
			<script type="text/javascript" language="javascript" src="../includes/js/tablesort.pager.js"></script>
			<script type="text/javascript" language="javascript" src="../includes/js/tablesort.min.js"></script>
			<script type="text/javascript" language="javascript" src="../includes/js/jquery.popover.min.js"></script>
			<script type="text/javascript" language="javascript">
				$(function(){
					$(".user-table").tablesorter({widgets: ['zebra']}).tablesorterPager({container: $("#pager"), positionFixed: false, size:10});
                    $('.user-table th').hover(
                        function() { $(this).addClass('over'); },
                        function() { $(this).removeClass('over'); }
                    );
					
					$('#point-add-remove-comments').focus(function(){
						if (this.value == this.defaultValue)
						{
							this.value = '';
						}
					});
					$('#point-add-remove-comments').blur(function(){
						if (this.value == '')
						{
							this.value = this.defaultValue;
						}
					});
					$("a.login-info").popover({title:'Login Information'});
				});
				
				var selected_user = 0;
                
				function getApproval(id) {
					$.blockUI({
						message:$('#approve-user'),
						css: {width: '600px', marginLeft: '50%', left: '-250px', top: '20px', border: '2px solid #999999', cursor: 'default'},
						overlayCSS: {backgroundColor:'#fff', opacity: '0.8'}
					});
					$.getJSON('http://<?php echo $_SERVER['SERVER_NAME'];?>/account/ajax_get_user/'+id, function(data){
						selected_user = data.userid;
						var table = '<table cellspacing="0" cellpadding="4"><tbody>';
						table += '<tr><td>Name</td><td>'+data.name+'</td></tr>';
						table += '<tr><td>Company</td><td>'+data.company+'</td></tr>';
						table += '<tr><td>Dealer No (Login)</td><td><input type="text" name="approve_dealer_no" id="approve_dealer_no" value="'+data.dealer_no+'" /></td></tr>';
						table += '<tr><td>Email</td><td>'+data.email+'</td></tr>';
						table += '<tr><td>Telephone</td><td>'+data.telephone+'</td></tr>';
						table += '<tr><td>State</td><td>'+data.state+'</td></tr>';
						if(data.comments != null){
								table += '<tr><td>Comments</td><td><textarea rows="4" cols="50">'+(data.comments)+'</textarea></td></tr>';
						}
						else{
								table += '<tr><td>Comments</td><td><textarea rows="4" cols="50">No Comments</textarea></td></tr>';
						}
						table += '</tbody></table>';
						$('#approve-user .user-content').slideUp(200, function(){
							$(this).html(table).slideDown();
						})
						$('#approve-user .controls').slideDown();
					}); 
				}
                
				function cancelBlock() {
					$.unblockUI();
					$('#approve-user .user-content').html('<p>Please Wait... Loading Content</p>');
					$('#approve-user .controls .category-select').val(0);
					$('#approve-user .controls .errors').html(' ');
					$('#approve-user .controls .reject-user:visible').slideUp();
					selected_user = 0;
				}
                
				function approveUser() {
					//console.log($('#approve-user .controls .category-select').val());
					var selected_cat = $('#approve-user .controls .category-select').val();
					
					//pricebook category value
					var pb_selected_cat = $('#approve-user .controls .pb-category-select').val();
					
				var approve_dealer_no = $('#approve_dealer_no').val();
					if (selected_cat == 0) {
						$('#approve-user .controls .errors').css({'display':'none', 'color':'red'}).html('You must select a category before approving this user!').slideDown(400);
					}else if(pb_selected_cat == 0){
				        $('#approve-user .controls .errors').css({'display':'none', 'color':'red'}).html('You must select a price book category before approving this user!').slideDown(400);
				    } else if (selected_user == 0) {
                        $('#approve-user .controls .errors:visible').css({'display':'none', 'color':'red'}).html('Error! User not properly selected.').slideDown(400);
                    } else if (!approve_dealer_no.match(/[a-z0-9]+/i)) {
                        $('#approve-user .controls .errors:visible').css({'display':'none', 'color':'red'}).html('Dealer Number must not be empty!').slideDown(400);
                    } else if (window.confirm('Is this Dealer Number acurate?')) {
						//$.getJSON('http://<?php echo $_SERVER['SERVER_NAME'];?>/account/ajax_approve_user/'+selected_user+'/'+selected_cat+'/'+approve_dealer_no+'/'+pb_selected_cat, function(data){
						$.post('http://<?php echo $_SERVER['SERVER_NAME'];?>/account/ajax_approve_user/',
							   {id:selected_user, cate: selected_cat, dealer_no:approve_dealer_no, pb_cate:pb_selected_cat},
								function(data){
							if (typeof(data) == 'object') {
								if (data.error == false) {
									$('#approve-user .controls .errors').html(' ').css('color', 'green').html('User successfully approved!').not(':visible').slideDown();
									$('#utd-'+selected_user).html('<a onclick="editUser('+selected_user+')">Edit</a> | <a onclick="deleteUser('+selected_user+')">Delete</a>');
									$('#utdn-'+selected_user).html(approve_dealer_no);
									setTimeout(cancelBlock, 500);
								} else {
									alert(data.errorMsg);
									cancelBlock();
								}
							} else {
								alert('Error retrieving data from the server!');
								cancelBlock();
							}
						},
						"json");
					}
				}
                
				function rejectUser() {
					msg = 'Dear user,\n\nYour application to obtain an account for the NEC dealer Intranet has been unsuccessful.\n\n';
					msg += 'Please accept our apologies for any inconveniences caused.\n\n';
					msg += 'If you wish to pursue the matter, please contact the administrators on displays@nec.com.au\n\nAdministrator\nNEC Dealer Intranet\n';
					msg = $('#rejected-text').val(msg);
					$('#approve-user .controls .reject-user:not(:visible)').slideDown();
				}
                
				function deleteUser() {
					msg = $('#rejected-text').val();
					$.post('http://<?php echo $_SERVER['SERVER_NAME'];?>/account/ajax_delete_user', {id: selected_user, email: msg}, function(data){
						if (typeof(data) == 'object') {
							if (data.error == false) {
								$('#approve-user .controls .reject-user:visible').slideUp();
								$('#approve-user .controls .errors').html(' ').css('color', 'green').html('User successfully deleted!').not(':visible').slideDown();
								$('#utr-'+selected_user).remove();
								setTimeout(cancelBlock, 800);
							} else {
								alert(data.errorMsg);
								cancelBlock();
							}
						} else {
							alert('Error retrieving data from the server!');
							cancelBlock();
						}
					},
					"json");
				}
                
                function deleteExistingUser(id) {
                    msg = '<div id="user-del-form">Are you sure you want to delete this user? <input type="button" value=" Yes " onclick="userDel('+id+')" /> ';
                    msg += ' <input type="checkbox" id="inform-delete-to-user-'+id+'" /> Inform the user upon deletion. <input type="button" value="No, cancel" onclick="$.unblockUI();" /></div>';
                    $.blockUI({
						message:msg,
						css: {width: '600px', padding:'12px', marginLeft: '50%', left: '-250px', top: '20px', border: '2px solid #999999', cursor: 'default'},
						overlayCSS: {backgroundColor:'#fff', opacity: '0.8'}
					});
                }
                
                function userDel(id) {
                    inform = 'no';
                    if ($('#inform-delete-to-user-'+id).attr('checked')) {
                        inform = 'yes';
                    }
                    $.getJSON(
                        'http://<?php echo $_SERVER['SERVER_NAME'];?>/account/ajax_user_del/'+id+'/'+inform,
                        function(data) {
							if (typeof(data) == 'object') {
								if (data.error == false) {
									$('#user-del-form').css('color', 'green').html('User Deleted!');
									$('#utr-'+id).remove();
									setTimeout($.unblockUI, 800);
								} else {
									alert(data.errormsg);
									setTimeout($.unblockUI, 400);
								}
							} else {
								alert('Error retrieving data from the server!');
								setTimeout($.unblockUI, 400);
							}
                        }
                    );
                }
				
				function viewUserPoints(id) {
					$('#ajax-edit-points-form .point-processing').show();
					$('#ajax-edit-points-form .points-user-id').val(id);
					
					displayUserPointsHistory(id);
					
					$('#ajax_user_edit').slideUp(400, function(){
						$('#ajax-edit-points').slideDown(400);
					});
				}
                
				function addUserPoints() {
					
					if ( ! /^[0-9]+$/.test($('#ajax-edit-points-form .point-val').val()))
					{
						alert('Point value can only be a positive number!');
						return false;
					}
					
					if ( ! /^(1|2)$/.test($('#ajax-edit-points-form .point-option').val()))
					{
						alert('Point credit or debit option must be selected!');
						return false;
					}
					
					$('#ajax-edit-points-form .point-processing').hide();
					$('.point-content, .point-history, .point-balance', $('#ajax-edit-points-form')).show();
					
					$.post(
						'http://<?php echo $_SERVER['SERVER_NAME'];?>/myaccount/add_user_points',
						$('#ajax-edit-points-form').serialize(),
						function(data){
							if (data.error)
							{
								alert(data.error_msg);
							}
							else
							{
								$('#ajax-edit-points-form')[0].reset();
								displayUserPointsHistory(data.userid);
							}
						},
						'json'
					)
					
					return false;
				}
				
				function closeUserPoints() {
					
					$('#ajax-edit-points').slideUp(200, function(){
						$('#ajax_user_edit').slideDown(200);
					});
				}
				
				function displayUserPointsHistory(id)
				{
					$.getJSON(
							'http://<?php echo $_SERVER['SERVER_NAME'];?>/myaccount/get_points_history/' + id,
							function(data)
							{
								if (data.error)
								{
									alert(data.error_msg);
								}
								else
								{
									$('#ajax-edit-points-form .point-balance span').text(data.balance);
									$('#ajax-edit-points-form .point-history table tbody').html(data.html);
									$('#ajax-edit-points-form .point-processing').hide();
									$('.point-content, .point-history, .point-balance', $('#ajax-edit-points-form')).show();
								}
							}
					)
				}
				
                function editUser(id) {
                    
                    $.blockUI({
                        message:$('#ajax-edit-user'),
                        css: {width: '650px', marginLeft: '50%', left: '-275px', top: '20px', border: '2px solid #999999', cursor: 'default'},
                        overlayCSS: {backgroundColor:'#fff', opacity: '0.8'}
                    });
                    
                    if (typeof(id) == 'undefined') { // new user insert
                        var data = {};
                        data.name = '';
                        data.company = '';
                        data.position = '';
                        data.telephone = '';
                        data.dealer_no = '';
						data.existing_dealer_no = '';
                        data.email = '';
                        data.last_login = '';
                        data.password = '';
                        data.category_fk = '';
                        data.state = '';
                        data.postcode = '';
                        data.new_user = true;
						data.pricebook_fk = '';//pricebook fk
                        populateInsertForm(data);
                    } else {
                        $.getJSON('http://<?php echo $_SERVER['SERVER_NAME'];?>/account/ajax_get_user/'+id, function(data){
                            selected_user = data.userid;
							data.existing_dealer_no = data.dealer_no;
                            populateInsertForm(data);
                        });
                    }
                }
                
                function populateInsertForm(data) {
                    
                    var states = ["Select your state", "NSW", "VIC", "QLD", "ACT", "WA", "SA", "NT", "TAS"];
                    
                    var categories = [];
                    <? foreach ($permissions as $perm) { ?>
                    categories[<?= $perm['link'] ?>] = '<?= $perm['title'] ?>';
                    <? } ?>
					
					var pricebook_cats = [];
                    <? foreach ($pricebook_cats as $pbc) { ?>
                        pricebook_cats[<?= $pbc['id'] ?>] = '<?= $pbc['dealer_type'] ?>';
                   <? } ?>
					
					var point_history = '';
					if (!data.new_user && data.userid) {
						point_history = '<a href="#" onclick="viewUserPoints('+ data.userid +'); return false;">View Point History</a>';
					}
                    
                    var table = '<table cellspacing="0" cellpadding="4"><tbody>';
                    table += '<tr><td>Name</td><td><input type="text" name="name" id="edit_name" value="'+data.name+'" /></td></tr>';
                    table += '<tr><td>Company</td><td><input type="text" name="company" id="edit_company" value="'+data.company+'" /> &nbsp; '+point_history+'</td></tr>';
                    table += '<tr><td>Position</td><td><input type="text" name="position" id="edit_position" value="'+data.position+'" /></td></tr>';
                    table += '<tr><td>Contact No.</td><td><input type="text" name="telephone" id="edit_telephone" value="'+data.telephone+'" /></td></tr>';
                    table += '<tr><td>Dealer No</td><td><input type="text" name="dealer_no" id="edit_dealer_no" value="'+data.dealer_no+'" /></td></tr>';
                    table += '<tr><td>Email</td><td><input type="text" name="email" id="edit_email" value="'+data.email+'" /></td></tr>';
                    table += '<tr><td>Last Login</td><td>'+data.last_login+'</td></tr>';
                     table += '<tr><td>Password</td><td><input type="text" name="password" id="edit_password" value="" />';
                    
                    if (!data.new_user) {
                        table += '<input type="checkbox" name="update_user_password" id="update_user_password" /> Tick to update user password.';
                    }
                    
                    table += '</td></tr>';
                    
                    table += '<tr><td>Category</td><td><select name="category_fk" id="edit_category_fk">';
                    if (data.category_fk == 181) categories[181] = 'Administrator'; 
                    for (var n in categories) {
                        if (n == data.category_fk) {
                            checked_status = ' selected="selected"';
                        } else {
                            checked_status = '';
                        }
                        table += '<option value="'+n+'"'+checked_status+'>'+categories[n]+'</option>';
                    }
                    table += '</select></td></tr>';
					
					// pricebook dealer types
                    table += '<tr><td>Pricebook Category</td><td><select name="pricebook_fk" id="edit_pricebook_fk">';
                    table += '<option value="">Select one category</option>';
					table += '<option value="0">view all</option>';
                    //if (data.category_fk == 181) categories[181] = 'Administrator';
                    for (var n in pricebook_cats) {
                        if (n == data.pricebook_fk) {
                            checked_status = ' selected="selected"';
                        } else {
                            checked_status = '';
                        }
                        
                        table += '<option value="'+n+'"'+checked_status+'>'+pricebook_cats[n]+'</option>';
                    }
                    table += '</select></td></tr>';
                    
                    //end of price book dealer types
                    
                    table += '<tr><td>State</td><td><select name="state" id="edit_state">';
                    for (var i in states) {
                        if (states[i] == data.state) {
                            checked_status = ' selected="selected"';
                        } else {
                            checked_status = '';
                        }
                        table += '<option value="'+states[i]+'"'+checked_status+'>'+states[i]+'</option>';
                    }
                    table += '</select></td></tr>';
                    table += '<tr><td>Postcode</td><td><input type="text" name="postcode" id="edit_postcode" value="'+data.postcode+'" />';
                    table += '<tr><td>Notify</td><td><input type="checkbox" name="new_user_email" id="edit_new_user_email" checked="checked" /> Send Email Notification</td></tr>';
                    
                    if (data.new_user == true) {
                        table += '<input type="hidden" name="new_user" value="1" />';
                    } else if (data.userid) {
				        table += '<input type="hidden" name="userid" value="'+data.userid+'" />';
					}
					
					table += '<input type="hidden" name="existing_dealer_no" value="'+data.existing_dealer_no+'" />';
                    
                    table += '</tbody></table>';
                    $('#ajax-edit-user .user-content').slideUp(200, function(){
                        $(this).html(table).slideDown();
                    })
                    $('#ajax-edit-user .controls').slideDown();
                }
                
                function insertUpdateUser(){
                    $.post(
                        'http://<?php echo $_SERVER['SERVER_NAME'];?>/account/ajax_add_edit_user/',
                        $('#ajax_user_edit').serialize(),
                        function(data) {
							if (typeof(data) == 'object') {
								if (data.error) {
									$('#ajax-edit-user .controls .errors').css('color', 'red').html(data.errormsg).not(':visible').slideDown(500);
								} else {
									$('#ajax-edit-user .controls .errors').css('color', 'green').html(data.msg).not(':visible').slideDown(500);
									setTimeout(cancelEditBlock, 800);
									window.location.reload(true);
								}
							} else {
								alert('Error retrieving data from the server!');
								setTimeout(cancelEditBlock, 400);
							}
                        },
                        "json"
                    );
                }
                
                function cancelEditBlock() {
					$.unblockUI();
					$('#ajax-edit-user .user-content').html('<p>Please Wait... Loading Content</p>');
					$('#ajax-edit-user .controls .category-select').val(0);
					$('#ajax-edit-user .controls .errors').html(' ');
					selected_user = 0;
				}
                
			</script>
			<input type="hidden" name="dealerMod" value="true" />

<div id="approve-user">
    <form name="ajax_user_approve" method="post">
    <div class="user-content">
        <p>Please wait... Loading Content</p>
    </div>
    <div class="controls">
        <p class="errors"></p>
        Category <select name="user_category" class="category-select" style="width:150px;">
        <option value="0">Uncategorised</option>
        <? foreach ($permissions as $perm) { ?>
        <option value="<?= $perm['link'] ?>"><?= $perm['title'] ?></option>
        <? } ?>
        </select>
		<!-- price book category -->
		
         &nbsp;&nbsp;Pricebook category <select name="user_pb_category" class="pb-category-select" style="width:150px;">
		 <option value="0">Uncategorised</option>
		 <? foreach ($pricebook_cats as $pb_cate) { ?>
		 <option value="<?= $pb_cate['id'] ?>"><?= $pb_cate['dealer_type'] ?></option>
		 <? } ?>
         </select><br /><br /><br />
         		
		<!-- end of pricebook category-->
        <input type="button" onclick="approveUser();" value="Approve" /> OR <input type="button" onclick="rejectUser();" value="Rreject" /> OR
        <input type="button" onclick="cancelBlock();" value="Cancel" />
        <div class="reject-user">
            <textarea id="rejected-text"></textarea>
            <input type="button" onclick="deleteUser();" value="Email this message and delete user" />
        </div>
    </div>
    </form>
</div>

<div id="ajax-edit-user">
    <form name="ajax_user_edit" id="ajax_user_edit" method="post">
		<div class="user-content">
			<p>Please wait... Loading Content</p>
		</div>
		<div class="controls">
			<p class="errors"></p>
			
			<input type="button" onclick="insertUpdateUser();" value="Save" /> OR <input type="button" onclick="cancelEditBlock();" value="Cancel" />
		</div>
    </form>
	
	<div id="ajax-edit-points">
		<form name="ajax_edit_points" id="ajax-edit-points-form" method="post" onsubmit="return false;">
			<div class="point-content">
				<p class="point-balance">
					Current point balance <span>0</span> points.
				</p>
				<p class="add-points">
					Add / Remove points
					&nbsp;
					<input type="text" name="points" class="point-val" value="" size="4" />
					&nbsp;
					<select name="tx_type" class="point-option">
						<option value="">Select Option</option>
						<option value="1">Credit</option>
						<option value="2">Debit</option>
					</select>
					&nbsp;
					<input type="text" name="point_comments" class="point-val" value="Comments" id="point-add-remove-comments" size="20" />
					<input type="button" onclick="addUserPoints();" value="Update" />
					<input type="hidden" name="userid" value="" class="points-user-id" />
				</p>
				<p class="close-points">
					<input type="button" onclick="closeUserPoints();" value="close" />
				</p>
			</div>
			<p class="point-processing">
				Processing... please wait!
			</p>
			<div class="point-history">
				<table border="0" cellpadding="0" cellspacing="0" class="point-history-table">
					<thead>
						<th>Type</th>
						<th>Debits</th>
						<th>Credits</th>
						<th>Date</th>
						<th>Details</th>
					</thead>
					<tbody></tbody>
				</table>
<H1>ASSHOLE</H1>
<?php print_r($_SERVER);?>