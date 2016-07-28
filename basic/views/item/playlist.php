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
<div class="col-sm-6 col-md-6 ">
    <h1 class="page-header">Все</h1>
    <?php  //var_dump($pl); exit; ?>
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
                            return Html::a('<span class="glyphicon glyphicon-minus"></span>', Url::toRoute(['pl-remove','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Удалить плейлиста'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        },
                        'update' => function ($url, $model) use ($pl) {
                           //var_dump(\Yii::$app->controller); exit;
                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', Url::toRoute(['pl-add','id' => $model->id, 'pl' => $pl]), [
                                'title' => Yii::t('yii', 'Добавить в плейлист'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        },


                    ]
            ]
        ],
    ]); ?>

</div>

<div class="col-sm-6 col-md-6 ">
    <h1 class="page-header"><?= Html::a(\app\models\Playlist::find()->where(['id' => $pl])->one()->name, Url::toRoute(['pl-sort','id' => $pl]),['title' => 'Создать очередь']) ?></h1>
    <?php  //var_dump($pl); exit; ?>
    <?= GridView::widget([
        'dataProvider' => $new_items,
        //'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            'tags',


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}  ',
                'buttons' =>
                    [
                        'delete' => function ($url, $model) use ($pl){
                            return Html::a('<span class="glyphicon glyphicon-minus"></span>', Url::toRoute(['pl-remove','id' => $model->id, 'pl' => $pl]), [
                                'title' => Yii::t('yii', 'Удалить из плейлиста'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        },


                    ]
            ]
        ],
    ]); ?>
</div>