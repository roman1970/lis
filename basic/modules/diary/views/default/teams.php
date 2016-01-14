<?php

?> <p><?= $country ?></p>
<div class="glyphicon glyphicon-bell"></div> Выберите команду </br>
    <?php if(isset($teams)) { 
        foreach ($teams as $key => $team) { ?> 
<div class="football-mod"> <?= $team ?> </div>
    <?php };
    } else { ?>
<div class="football-mod"> Команд нет </div>        
<?php }?>