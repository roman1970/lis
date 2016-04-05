<?php if ($marks) : $i = 0; ?>
    <p style="color: #f7ffe4">имя - ср оценка - кол действий  </p>

    <?php foreach ($marks as $mark) :  ?>


        <?php if($mark->avg >= 4) : ?>
            <p style="color: #40ff36"><?= $i+1 ?>. <?=\app\models\MarkUser::findOne($mark->user_id)->name?> - <?=round($mark->avg, 2)?> - <?=$mark->cnt ?></p>

        <?php else : ?>
            <p style="color: red"><?= $i+1 ?>. <?=\app\models\MarkUser::findOne($mark->user_id)->name?> - <?=round($mark->avg, 2)?> - <?=$mark->cnt ?></p>
        <?php endif; $i++; ?>


    <?php endforeach; ?>
<?php endif; ?>