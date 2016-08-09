<?php
use yii\bootstrap\Nav;
?>
<header>
    <div class="logo">
        <h1 class="main_title">Today <?=date('d M Y', time()) ?></h1>
    </div>


</header>


<?= Nav::widget([
    'options' => ['class' => 'nav nav-pills nav-stacked nav-justified'],
    'items' => [
        ['label' => 'СЪЕЛ', 'url' => ['eat'], 'class' => 'panel panel-primary'],
        ['label' => 'КУПИЛ', 'url' => ['bye']],
        ['label' => 'СДЕЛАЛ', 'url' => ['done']],
        ['label' => 'ЗАМЕР', 'url' => ['measure']],
        ['label' => 'ЗНАНИЯ', 'url' => ['knowledge']],

    ],
]);
?>