<div id="header"> 
  <div> 
    <div> 
      <div> 
        <div> 
          <div> 
            <h1><?= $lang[0] ?></h1> 
<? if (isset ($user)) { ?>
            <p><strong><a href="."><?= $user['title'] ?></a></strong> (<?= $user['group'] ?>) &nbsp;|&nbsp; <a href=".?signout=1"><?= $lang[3] ?></a></p> 
<? } else { ?>
            <p>&nbsp;</p> 
<? } ?>
          </div> 
        </div> 
      </div> 
    </div> 
  </div> 
</div>
<hr /> 
