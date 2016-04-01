<?php

use app\assets\AppAsset;
use yii\bootstrap\Nav;

AppAsset::register($this);
?>

<div class="col-sm-3 col-md-2 sidebar" xmlns="http://www.w3.org/1999/html">
    <p>Оценки последней недели</p>
    <?= \app\components\LastMarksWidget::widget(['user_id' => (isset($user->id)) ? $user->id : 1]) ?>
    <p>Твой общий средний балл</p>
    <?php $averball = \app\models\MarkIt::getAverageForUser(['user_id' => (isset($user->id)) ? $user->id : 1]); ?>
    <?php if($averball >= 4) : ?>
        <p style="color: #40ff36"> <?=$averball?> </p>
    <?php else : ?>
        <p style="color: red"> <?=$averball?> </p>
    <?php endif; ?>
    <p>Твои соперники</p>
    <?= \app\models\MarkIt::getThisGroupUsersAverageMark(1)?>



</div>

<div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Твоя оценка за вчера</h1>

    <?php if($avmark >= 4) : ?>
    <h1 style="color: #40ff36"> <?=$avmark?> </h1>
    <?php else : ?>
    <h1 style="color: red"> <?=$avmark?> </h1>
    <?php endif; ?>
