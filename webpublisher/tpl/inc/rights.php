<tr class="rights">
<td colspan="4">&nbsp;</td>
</tr>
<tr class="rights"> 
  <td>
  <label><?= $lang[54] ?></label><br /> 
    <select name="viewRights[]" class="width-100pct textfield" size="3" multiple="multiple"> 
      <? foreach ($groups as $row) { ?> 
      <option value="<?= $row['id'] ?>"<? if (isset ($_POST['viewRights'])) {if (in_array ($row['id'], $_POST['viewRights'])) echo ' selected="selected"';} elseif (! isset ($_POST['title']) && ereg ("({$row['id']})", $record['viewRights'])) echo ' selected="selected"'; ?>> 
      <?= $row['title'] ?> 
      </option> 
      <? } ?> 
    </select></td> 
  <td><label><?= $lang[55] ?></label><br /> 
    <select name="createRights[]" class="width-100pct textfield" size="3" multiple="multiple"> 
      <? foreach ($groups as $row) { ?> 
      <option value="<?= $row['id'] ?>"<? if (isset ($_POST['createRights'])) {if (in_array ($row['id'], $_POST['createRights'])) echo ' selected="selected"';} elseif (! isset ($_POST['title']) && ereg ("({$row['id']})", $record['createRights'])) echo ' selected="selected"'; ?>> 
      <?= $row['title'] ?> 
      </option> 
      <? } ?> 
    </select></td> 
  <td><label><?= $lang[56] ?></label><br /> 
    <select name="editRights[]" class="width-100pct textfield" size="3" multiple="multiple"> 
      <? foreach ($groups as $row) { ?> 
      <option value="<?= $row['id'] ?>"<? if (isset ($_POST['editRights'])) {if (in_array ($row['id'], $_POST['editRights'])) echo ' selected="selected"';} elseif (! isset ($_POST['title']) && ereg ("({$row['id']})", $record['editRights'])) echo ' selected="selected"'; ?>> 
      <?= $row['title'] ?> 
      </option> 
      <? } ?> 
    </select></td> 
  <td><label><?= $lang[57] ?></label><br /> 
    <select name="deleteRights[]" class="width-100pct textfield" size="3" multiple="multiple"> 
      <? foreach ($groups as $row) { ?> 
      <option value="<?= $row['id'] ?>"<? if (isset ($_POST['deleteRights'])) {if (in_array ($row['id'], $_POST['deleteRights'])) echo ' selected="selected"';} elseif (! isset ($_POST['title']) && ereg ("({$row['id']})", $record['deleteRights'])) echo ' selected="selected"'; ?>> 
      <?= $row['title'] ?> 
      </option> 
      <? } ?> 
    </select></td> 
</tr> 
