
<hr>
<div id="menu">

<?php  foreach ($tests as $test): ?>

    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'day-params')"><?= $test->name ?></button>

<?php endforeach; ?>
    
</div>
    