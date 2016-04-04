<?php if ($marks) :
    foreach ($marks as $mark) : ?>

        <?php if($mark->avg >= 4) : ?>
            <p style="color: #40ff36"><?=\app\models\MarkUser::findOne($mark->user_id)->name.' -- '?>  <?=round($mark->avg, 1)?></p>

        <?php else : ?>
            <p style="color: red"> <?=\app\models\MarkUser::findOne($mark->user_id)->name.' -- '?>  <?=round($mark->avg, 1)?> </p>
        <?php endif; ?>


    <?php endforeach; ?>
<?php endif; ?>