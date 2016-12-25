<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\assets\AppAsset;
use yii\grid\GridView;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;

AppAsset::register($this);
?>
<div class="col-sm-3 col-md-2 sidebar">
    <?php




    echo Nav::widget([
        'options' => ['class' => 'nav nav-sidebar'],
        'items' => [
            ['label' => 'Создать', 'url' => ['/source/create']],
            ['label' => 'Редактировать', 'url' => ['/source/update']],

        ],
    ]);

    ?>

</div>

<div class="col-sm-9 col-md-10 main">


    <?= GridView::widget([
        'dataProvider' => $sources,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',

            [
                'label' => 'Автор',
                'value' => function($sources){
                    return $sources->author->name;
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {update}',
                'buttons' =>
                    [
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Удалить'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Редактировать'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        },


                    ]
            ]
        ],
    ]); ?>
</div>