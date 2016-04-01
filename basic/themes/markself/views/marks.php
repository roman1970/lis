<?php if ($marks) :
    foreach ($marks as $data=>$mark) : ?>


        <?php if($mark >= 4) : ?>
            <p style="color: #40ff36"><?=$data." - ".$mark?></p>
        <?php elseif($mark == 0) : continue; ?>
        <?php else : ?>
            <p style="color: red"> <?=$data." - ".$mark?> </p>
        <?php endif; ?>


    <?php endforeach; ?>
<?php endif; ?>