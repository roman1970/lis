<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
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
            ['label' => 'Создать', 'url' => ['/author/create']],
            ['label' => 'Редактировать', 'url' => ['/author/update']],

        ],
    ]);

    ?>

</div>

<div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Авторы</h1>
    <?php  //var_dump($articles); exit; ?>
    <?= GridView::widget([
        'dataProvider' => $authors,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {update} {edit_sources}',
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
                        'edit_sources' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-book"></span>', Url::toRoute(['songtext/artist-texts','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Редактировать источники'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        },


                    ]
            ]
        ],
    ]); ?>
</div>