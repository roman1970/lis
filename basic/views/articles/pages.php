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
                ['label' => 'Создать новый контент', 'url' => ['/articles/create']],
                ['label' => 'Показать контент', 'url' => ['/articles/index']],
                //['label' => 'Добавить страницу', 'url' => ['/articles/addpage/'.$model->id]],

            ],
        ]);

        ?>

    </div>

    <div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Контент</h1>
<?php  //var_dump($articles); exit; ?>
<?php if(isset($content)) : ?>

    <?= GridView::widget([
        'dataProvider' => $content,
        //'filterModel' => $searchModel,
        'columns' => [
            'minititle',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {update} {load-article-pictures}',
                'buttons' =>
                    [
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['deletepage','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Уверены, что хотите удалить страницу?'),
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
                        },
                        'load-article-pictures' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-camera"></span>', Url::toRoute(['load-article-pictures','id' => $model->id]), [
                                'title' => Yii::t('yii', 'Загрузить фото страницы'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }

                    ]
            ]
        ],
    ]); ?>

<?php endif; ?>