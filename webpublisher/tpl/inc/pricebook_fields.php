<?php 

$sql = "SELECT * FROM nec_pricetable_fields";
$result = dbq($sql);

?>
<style>
table.fields tr td {
	padding: 2px 4px 2px 0px;
}
</style>
<input type="hidden" name="currid" value="5746" />
<tr><td colspan="4">
	<h1>Edit Pricebook Fields</h1>
	<table class="fields" style="width:60%" border="0" cellspacing="2" cellpadding="2">
	<tr>
		<td><input name="field[1]" style="width:16em;" value="<?php echo $result[0]['title'];?>" placeholder="CAT."/></td>
		<td><input name="field[2]" style="width:16em;" value="<?php echo $result[1]['title'];?>" placeholder="Status"/></td>
		<td><input name="field[3]" style="width:16em;" value="<?php echo $result[2]['title'];?>" placeholder="Code"/></td>
		<td><input name="field[4]" style="width:16em;" value="<?php echo $result[3]['title'];?>" placeholder="Image"/></td>
	</tr><tr>
		<td><input name="field[5]" style="width:16em;" value="<?php echo $result[4]['title'];?>" placeholder="RES"/></td>
		<td><input name="field[6]" style="width:16em;" value="<?php echo $result[5]['title'];?>" placeholder="Chipset"/></td>
		<td><input name="field[7]" style="width:16em;" value="<?php echo $result[6]['title'];?>" placeholder="Product Description"/></td>
		<td><input name="field[8]" style="width:16em;" value="<?php echo $result[7]['title'];?>" placeholder="WTY"/></td>
	</tr><tr>
		<td><input name="field[18]" style="width:16em;" value="<?php echo $result[17]['title'];?>" placeholder="Color"/></td>
		<td><input name="field[19]" style="width:16em;" value="<?php echo $result[18]['title'];?>" placeholder="Notes"/></td>		
		<td><input name="field[20]" style="width:16em;" value="<?php echo $result[19]['title'];?>" placeholder="SCR Size"/></td>
		<td><input name="field[10]" style="width:16em;" value="<?php echo $result[9]['title'];?>" placeholder="KEY PARTNER"/></td>
		
	</tr><tr>
		<td><input name="field[11]" style="width:16em;" value="<?php echo $result[10]['title'];?>" placeholder="PRO AV"/></td>
		<td><input name="field[12]" style="width:16em;" value="<?php echo $result[11]['title'];?>" placeholder="GOV'T"/></td>
		<td><input name="field[13]" style="width:16em;" value="<?php echo $result[12]['title'];?>" placeholder="WHOLESALE 1"/></td>
		<td><input name="field[14]" style="width:16em;" value="<?php echo $result[13]['title'];?>" placeholder="WHOLESALE 2"/></td>
	</tr><tr>
		<td><input name="field[15]" style="width:16em;" value="<?php echo $result[14]['title'];?>" placeholder="EDUCATION"/></td>
		<td><input name="field[16]" style="width:16em;" value="<?php echo $result[15]['title'];?>" placeholder="DEALER"/></td>
		<td><input name="field[17]" style="width:16em;" value="<?php echo $result[16]['title'];?>" placeholder="RRP"/></td>
	</tr>
  
	</table>        
</td></tr>
