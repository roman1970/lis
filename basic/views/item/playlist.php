<script>
    $(document).ready(function() {

    });

    function changeQue(id){
        var que = $("#que_"+id).val();

       // alert(id);

        $.ajax({
            type: "GET",
            url: "changeq",
            data: "que="+que+"&id="+id,
            success: function(html){

                $("#change-que_"+id).hide();
                $("#que_"+id).hide();
                $("#req_"+id).html(html).show();

            }

        });

    }

</script>

<style>
    .form-control{
        color: black;
    }
</style>

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

            [
                'attribute' => 'radio_que',
                'value' => function ($model, $key, $index, $column) {
                    //  var_dump($model); var_dump($key); exit;
                    return Html::input('text', 'radio_que', $model->radio_que, ['id' => 'que'.'_'.$model->id, 'class' => 'form-control']).
                    Html::button('Изменить', ['id' => 'change-que'.'_'.$model->id, 'onClick' => "changeQue($model->id)", 'class' => 'btn btn-primary']).
                    Html::tag('p', $model->id, ['style' => 'display: none', 'id' => 'req'.'_'.$model->id]);
                    },
                'format' => 'raw',
              //  'filter' => ArrayHelper::map(Groups::find()->all(), 'id', 'title')
            ],


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