<div id="path">
  <p>
  <a href="."><?= $lang[4] ?></a>
  <? if (isset ($path)) foreach ($path as $row) if ($row[0] != 0) { ?>
  / <a href=".?id=<?= $row[0] ?>"><? if ($row[1] != '') echo htmlspecialchars ($row[1]); else echo $lang[5]; ?></a>
  <? } ?>
  <!--
  <? //print_r($path) ?>
  -->
  </p> 
</div>
<hr />
