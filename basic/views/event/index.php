<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\grid\GridView;
use yii\helpers\Url;

AppAsset::register($this);
?>

<div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Контент</h1>
    <?php  //var_dump($events); exit; ?>
    <?= GridView::widget([
        'dataProvider' => $events,
        //'filterModel' => $searchModel,
        'columns' => [
            'id',
            'text',


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{photo}',
                'buttons' =>
                    [
                        'photo' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-camera"></span>', Url::toRoute(['add-img','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Добавить фото'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        },
                    ]
            ]
        ],
    ]); ?>
</div>