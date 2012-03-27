<? require ('tpl/header.php'); ?>
<script type="text/javascript" src="assets/js/tablesort.min.js"></script>
<script type="text/javascript" src="assets/js/tablesort.pager.js"></script>
<style>
table {
	width:100%;
}
table, td {
	border-collapse:collapse;
}
th {
	background:#666;
	color:#fff;
	padding:6px;
	border:1px solid #555;
	/*border-bottom:2px solid #555;*/
    text-align:left;
	cursor:pointer;
}
tr.odd {
    background-color:#c3cfd4;
}
td {
	border:1px solid #999;
	padding:4px;
}
#approve-user {
    display:none;
}
#approve-user .controls {
    display:none;
}
#approve-user .controls .errors {
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
#approve-user .user-content table {
    width:580px;
    margin-left:10px;
    margin-bottom:10px;
}
#approve-user .user-content td {
    text-align:left;
}
.margin-top-0 {
	margin-top:0;
}
#pager td, #pager table {
border: none;
}
#pager a {
display: block;
width: 35px;
text-align: center;
}
.pagesize {
width: 50px;
}
.paging {
width: 155px;
text-align: center;
}
.nav {
width: 35px;
}
.search {
text-align: right;
}
.uncat {
color: #FF0000;
}
</style>
<div class="padding20px">
    <h2 class="margin-top-0">User Management - List</h2>
	<div id="pager" class="pager">
		<form action="./usermgmt/" method="get" enctype="application/form-data">
			<table cellspacing="0" cellpadding="0" border="0" >

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
					<td class="search"><input type="text" size="30" name="search" value="Search..." onFocus="if(this.value == 'Search...'){this.value = ''}" onBlur="if(this.value == ''){this.value = 'Search...'}" /> <input type="submit" name="submit" value="Search" /></td>
				</tr>
			</table>
		</form>
	</div>
	<table border="0" cellpadding="4" cellspacing="0" class="user-table">
		<thead>
		<tr>
			<th>Dealer No</th>
			<th>Name</th>
			<th>Company</th>
			<th>Contact No</th>
			<th>Email</th>
			<th>State</th>
			<th>Category</th>
            <th>Options</th>
		<tr>
		</thead>
		<tbody>
	<? 
	if (is_array($users) && count($users) > 0) foreach ($users as $user) {?>
		<tr>
			<td><?= $user['dealer_no'] ?></td>
			<td><?= $user['name'] ?></td>
			<td><?= $user['company'] ?></td>
			<td><?= $user['telephone'] ?></td>
			<td><?= $user['email'] ?></td>
			<td><?= $user['state'] ?></td>
			<td class="cat-class"><?php if($user['category_name'] == ''){ echo '<span class="uncat">Awaiting approval</span>'; } else { echo $user['category_name']; } ?></td>
            <td><? if ($user['approved'] == '0') { ?><a href="account/register/<?= $user['userid'] ?>" rel="<?= $user['userid'] ?>" class="approve-this-user">Approve</a><? } else { ?><a href="account/register/<?= $user['userid'] ?>">Edit</a><? } ?> </td>
		</tr>
	<? } else { ?>
		<tr>
			<td style="padding: 20px 0;" colspan="8" align="center">Your search returned no results</td>
		</tr>
	<? } ?>
		</tbody>
	</table>
	<?
	if(is_array($users) && count($users) > 0){
		echo '<script type="text/javascript" language="javascript">'."\n";
		echo '$(function(){'."\n";
		echo '$(".user-table").tablesorter({widthFixed: true, widgets: ["zebra"]}).tablesorterPager({container: $("#pager"), positionFixed: false});'."\n";
		echo '});'."\n";
		echo '</script>';
	}
	?>
</div>
<div id="approve-user">
    <form name="ajax_user_approve" method="post">
    <div class="user-content">
        <p><img src="assets/img/indicator.gif" alt="Please Wait.." /> Loading Content</p>
    </div>
    <div class="controls">
        <p class="errors"></p>
        Category <select name="user_category" class="category-select">
        <option value="0">Uncategorised</option>
        <? foreach ($this->login_model->categories as $cat_id => $cat_name) { ?>
        <option value="<?= $cat_id ?>"><?= $cat_name ?></option>
        <? } ?>
        </select>
        <input type="button" onclick="approveUser();" value="Approve" /> OR <input type="button" onclick="rejectUser();" value="Reject" /> OR
        <input type="button" onclick="cancelBlock();" value="Cancel" />
        <div class="reject-user">
            <textarea id="rejected-text"></textarea>
            <input type="button" onclick="deleteUser();" value="Email this message and delete user" />
        </div>
    </div>
    
    </form>
</div>
<script>

$('.user-table tr').hover(
	function(){
		$(this).css('background-color', '#efefef');
	},
	function(){
		$(this).css('background-color', '');
	}
);
$(function(){
    $('.approve-this-user').each(function(){
        $(this).click(function(){
            getApproval($(this).attr('rel'));
            return false;
        });
    });
});
var selected_user = 0;
function getApproval(id) {
    $.blockUI({
        message:$('#approve-user'),
        css: {width: '600px', marginLeft: '50%', left: '-250px', top: '25%', border: '2px solid #005595', cursor: 'default'},
        overlayCSS: {backgroundColor:'#6c97ba', opacity: '0.9'}
    });
    $.getJSON('account/ajax_get_user/'+id, function(data){
        selected_user = data.userid;
        var table = '<table cellspacing="0" cellpadding="4"><tbody>';
        table += '<tr><td>Name</td><td>'+data.name+'</td></tr>';
        table += '<tr><td>Company</td><td>'+data.company+'</td></tr>';
        table += '<tr><td>Dealer No</td><td>'+data.dealer_no+'</td></tr>';
        table += '<tr><td>Email</td><td>'+data.email+'</td></tr>';
        table += '<tr><td>Telephone</td><td>'+data.telephone+'</td></tr>';
        table += '<tr><td>State</td><td>'+data.state+'</td></tr>';
        table += '</tbody></table>';
        $('#approve-user .user-content').slideUp(200, function(){
            $(this).html(table).slideDown();
        })
        $('#approve-user .controls').slideDown();
    });
}
function cancelBlock() {
    $.unblockUI();
    $('#approve-user .user-content').html('<p><img src="assets/img/indicator.gif" alt="Please Wait.." /> Loading Content</p>');
    $('#approve-user .controls .category-select').val(0);
    $('#approve-user .controls .errors').html(' ');
    $('#approve-user .controls .reject-user:visible').slideUp();
    selected_user = 0;
}
function approveUser() {
    //console.log($('#approve-user .controls .category-select').val());
    selected_cat = $('#approve-user .controls .category-select').val();
    if (selected_cat == 0 || selected_user == 0) {
        $('#approve-user .controls .errors').html('You must select a category before approving this user!').not(':visible').slideDown();
    } else {
		if (selected_cat == 1) {
			if (!window.confirm('Are sure you want to add this user as an administrator?')) return false;
		}
        $.getJSON('account/ajax_approve_user/'+selected_user+'/'+selected_cat, function(data){
            if (data.error == false) {
                $('#approve-user .controls .errors').html(' ').css('color', 'green').html('User successfully approved!').not(':visible').slideDown();
                el_td = $('td a[rel='+selected_user+']').parent();
                el_td.html(' ');
                el_td.html('<a href="account/register/'+selected_user+'">Edit</a>');
                el_td.siblings('.cat-class').html(data.category);
                setTimeout(cancelBlock, 1000);
            } else {
                console.log(data);
            }
        });
    }
}
function rejectUser() {
    msg = 'Dear user,\n\nYour application to obtain an account for the NEC dealer Intranet has been unsuccessful.\n\n';
    msg += 'Pease accept our apologies for any inconveniences caused.\n\nAdministrator\nNEC Dealer Intranet\n';
    msg = $('#rejected-text').val(msg);
    $('#approve-user .controls .reject-user:not(:visible)').slideDown();
}
function deleteUser() {
    msg = $('#rejected-text').val();
    $.post('account/ajax_delete_user', {id: selected_user, email: msg}, function(data){
        if (data == 'YES') {
            $('#approve-user .controls .reject-user:visible').slideUp();
            $('#approve-user .controls .errors').html(' ').css('color', 'green').html('User successfully deleted!').not(':visible').slideDown();
            $('td a[rel='+selected_user+']').parent().parent().slideUp();
            setTimeout(cancelBlock, 1000);
        }
    });
}
</script>
<? require ('tpl/footer.php'); ?>