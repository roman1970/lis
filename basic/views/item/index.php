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
<div class="col-sm-3 col-md-2 sidebar">
    <?php

    echo Nav::widget([
        'options' => ['class' => 'nav nav-sidebar'],
        'items' => [
            ['label' => 'Создать', 'url' => ['/item/create']],
            ['label' => 'Редактировать', 'url' => ['/item/update']],
            ['label' => 'Без аудио', 'url' => ['/item/list-no-audio']],

        ],
    ]);

    ?>
    <!-- Информер RedDay.RU (Новосибирск)-->
    <a href="http://redday.ru/moon/" target="_new">
        <img src="http://redday.ru/informer/i_moon/245/bl.png" width="150" height="190" border="0" alt="Фазы Луны на RedDay.ru (Новосибирск)" />
    </a>
    <!-- / Информер RedDay.RU-->

</div>

<div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Items</h1>
    <?php  //var_dump($articles); exit; ?>
    <?= GridView::widget([
        'dataProvider' => $items,
        //'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            'tags',


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {update} ',
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
                        'pages' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', Url::toRoute(['pages','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Посмотреть страницы'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }

                    ]
            ]
        ],
    ]); ?>
</div>