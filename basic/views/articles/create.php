<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\grid\GridView;

AppAsset::register($this);
?>
    <div class="col-sm-3 col-md-2 sidebar">
        <?php

        echo Nav::widget([
            'options' => ['class' => 'nav nav-sidebar'],
            'items' => [
                ['label' => 'Контент', 'url' => ['/articles/index']],
                ['label' => 'Редактировать', 'url' => ['/articles/update']],

            ],
        ]);

        ?>

    </div>

    <div class="col-sm-9 col-md-10 main">
        <h1 class="page-header">Новый контент</h1>

        <?php $this->render('_form', [
            'model' => $model,
        ]); ?>

    </div>
