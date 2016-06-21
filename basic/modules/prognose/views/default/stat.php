<script>
    var bounce = new Bounce();
    bounce.rotate({
        from: 0,
        to: 90
    });

    bounce.applyTo(document.querySelectorAll(".balll"));
</script>
<div class="col-sm-4 col-md-3 sidebar" xmlns="http://www.w3.org/1999/html">
    <p>Оценки последней недели</p>
    <?= \app\components\LastMarksWidget::widget(['user_id' => (isset($user->id)) ? $user->id : 1]) ?>
    <p>Твой общий средний балл</p>
    <?php $averball = \app\models\MarkIt::getAverageForUser(['user_id' => (isset($user->id)) ? $user->id : 1]); ?>
    <?php if($averball >= 3.5) : ?>
        <p style="color: #40ff36"> <?=$averball?> </p>
    <?php else : ?>
        <p style="color: red"> <?=$averball?> </p>
    <?php endif; ?>
    <p>Чемпионат</p>

    <?= \app\components\UserAvgMarkWidget::widget(['user_id' => (isset($user->id)) ? $user->id : 1, 'group_id' => 1]) ?>



</div>

<div class="col-sm-8 col-md-9 main">
    <h1 class="page-header">Твоя оценка за вчера</h1>
    <div class="balll">
        <?php if($avmark >= 3.5) : ?>
            <h1 style="color: #40ff36; font-size: 200px;" > <?=$avmark?> </h1>
        <?php else : ?>
            <h1 style="color: red;font-size: 200px;" > <?=$avmark?> </h1>
        <?php endif; ?>

    </div>


