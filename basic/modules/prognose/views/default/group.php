<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\grid\GridView;
use yii\helpers\Url;

AppAsset::register($this);
//var_dump($user); exit;
?>
<div class="col-sm-3 col-md-2 sidebar">
    <?php

    echo Nav::widget([
        'options' => ['class' => 'nav nav-sidebar'],
        'items' => [
            ['label' => 'Создать', 'url' => ['/default/grcreate']],
            ['label' => 'Редактировать', 'url' => ['/default/grupdate']],

        ],
    ]);

    ?>

</div>

<div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Список матчей</h1>

    <table class="table table-striped">
        <tbody>

        <?php foreach ($match_list as $match) :  ?>

            <?php
            $model = new \app\models\Totpredict();
            $form = \yii\widgets\ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <tr>
                <td><?= $form->field($model, 'date')->textInput(['value' => $match->date])  ?></td>
                <td><?= $match->tournament ?></td>
                <td><?= $match->host ?></td>
                <td><?= $match->guest ?></td>
                <td><?= $form->field($model, 'host_g')->textInput()  ?></td>
                <td><?= $form->field($model, 'guest_g')->textInput()  ?></td>
                <td>
                    <?= Html::submitButton('Прогноз!',['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
                    <a href="/khl/default/match/<?= $match->id?>"> <span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
            </tr>
            <?php \yii\widgets\ActiveForm::end(); ?>

        <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    /*
     * GridView::widget([
        'dataProvider' => $groups,
        //'value' => $user,
        //'filterModel' => $searchModel,
        'columns' => [
            'name',
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
                                'title' => Yii::t('yii', 'Список действий'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }

                    ]
            ]
        ],
    ]);
 */ ?>
</div>
