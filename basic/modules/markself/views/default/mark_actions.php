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
                ['label' => 'Создать новое действие', 'url' => ['/default/accreate']],
                //['label' => 'Показать контент', 'url' => ['/articles/index']],
                //['label' => 'Добавить страницу', 'url' => ['/articles/addpage/'.$model->id]],

            ],
        ]);

        ?>

    </div>

    <div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Оцениваемые действия</h1>
<?php  //var_dump($articles); exit; ?>
<?php if(isset($actions)) : ?>

    <?= GridView::widget([
        'dataProvider' => $actions,
        //'filterModel' => $searchModel,
        'columns' => [
            'name',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {update}',
                'buttons' =>
                    [
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['deletepage','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Уверены, что хотите удалить действие?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['updatepage','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Update'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }

                    ]
            ]
        ],
    ]); ?>

<?php endif; ?>