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
            ['label' => 'Создать', 'url' => ['/articles/create']],
            ['label' => 'Редактировать', 'url' => ['/articles/update']],

        ],
    ]);

    ?>

</div>

<div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Контент</h1>
  <?php  //var_dump($articles); exit; ?>
    <?= GridView::widget([
        'dataProvider' => $articles,
        //'filterModel' => $searchModel,
        'columns' => [
                'id',
                'title',
                'alias',


        ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete} {update} {pages}',
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
<?php /*
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($cats as $cat) : ?>

                <tr>
                    <td><?=$cat->title?></td>
                    <td><?=$cat->alias?></td>
                    <td><?=$cat->name?></td>
                    <td><?=$cat->lft?></td>
                    <td>  <a class="edit" href="update?id=<?=$cat->id?>" title="редактировать"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="del" href="delete?id=<?=$cat->id?>" title="удалить"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
 */