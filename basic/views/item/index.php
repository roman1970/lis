<script>
    var stats2Config = {"tournament":"pWn0oS7f","tournamentStage":"OIkCTfCm","statsTabsConfig":{"16":{"name":"\u0422\u0430\u0431\u043b\u0438\u0446\u0430 Live","url":"live","sortKey":1},"1":{"name":"\u0422\u0430\u0431\u043b\u0438\u0446\u0430","url":"table","sortKey":2,"items":{"1":{"name":"\u0418\u0442\u043e\u0433\u043e","url":"overall","sortKey":1},"2":{"name":"\u0414\u043e\u043c\u0430","url":"home","sortKey":2},"3":{"name":"\u0412 \u0433\u043e\u0441\u0442\u044f\u0445","url":"away","sortKey":3}}},"5":{"name":"\u0424\u043e\u0440\u043c\u0430","url":"form","sortKey":3,"items":{"5":{"name":"\u0418\u0442\u043e\u0433\u043e","url":"overall","has_sub_items":true,"sortKey":1},"8":{"name":"\u0414\u043e\u043c\u0430","url":"home","has_sub_items":true,"sortKey":2},"9":{"name":"\u0412 \u0433\u043e\u0441\u0442\u044f\u0445","url":"away","has_sub_items":true,"sortKey":3}}},"6":{"name":"\u0411\u043e\u043b\u044c\u0448\u0435\/\u043c\u0435\u043d\u044c\u0448\u0435","url":"over_under","sortKey":4,"items":{"6":{"name":"\u0418\u0442\u043e\u0433\u043e","url":"overall","has_sub_items":true,"sortKey":1},"17":{"name":"\u0414\u043e\u043c\u0430","url":"home","has_sub_items":true,"sortKey":2},"18":{"name":"\u0412 \u0433\u043e\u0441\u0442\u044f\u0445","url":"away","has_sub_items":true,"sortKey":3}}},"7":{"name":"\u0421\u0435\u0440\u0438\u0438","url":"streaks","sortKey":5},"-1":{"name":"\u0421\u0435\u0442\u043a\u0430","url":"draw","sortKey":6},"13":{"url":"ht_ft","name":"HT\/FT","title":"\u0422\u0430\u0439\u043c\/\u043c\u0430\u0442\u0447","sortKey":7,"items":{"13":{"name":"\u0418\u0442\u043e\u0433\u043e","url":"overall","sortKey":1},"14":{"name":"\u0414\u043e\u043c\u0430","url":"home","sortKey":2},"15":{"name":"\u0412 \u0433\u043e\u0441\u0442\u044f\u0445","url":"away","sortKey":3}}},"10":{"name":"\u0411\u043e\u043c\u0431\u0430\u0440\u0434\u0438\u0440\u044b","url":"top_scorers","sortKey":8}},"statsOverUnderTypes":{"8":{"sort":0,"name":0.5,"default_tab_order":1},"1":{"sort":1,"name":1.5,"default_tab_order":0},"2":{"sort":2,"name":2.5,"default_tab_order":2},"3":{"sort":3,"name":3.5,"default_tab_order":0},"4":{"sort":4,"name":4.5,"default_tab_order":0},"5":{"sort":5,"name":5.5,"default_tab_order":0},"6":{"sort":6,"name":6.5,"default_tab_order":0},"7":{"sort":7,"name":7.5,"default_tab_order":0}}};

    console.log(stats2Config);
</script>
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
            ['label' => 'Items', 'url' => ['/item/index']],
            ['label' => 'Без аудио', 'url' => ['/item/list-no-audio']],
            ['label' => 'КВН без аудио', 'url' => ['/item/list-kvn-no-audio']],
            ['label' => 'Сформировать плейлист', 'url' => ['/item/add-playlist']],
            ['label' => 'Выбрать плейлист', 'url' => ['/item/choose-playlist']],
            ['label' => 'В работе', 'url' => ['/item/in-work']],
            ['label' => 'Репертуар', 'url' => ['/item/show-repertoire']],

        ],
    ]);

    /*
    <!-- Информер RedDay.RU (Новосибирск)-->
    <a href="http://redday.ru/moon/" target="_new">
        <img src="http://redday.ru/informer/i_moon/245/bl.png" width="150" height="190" border="0" alt="Фазы Луны на RedDay.ru (Новосибирск)" />
    </a>
    <!-- / Информер RedDay.RU-->
    */
    ?>

</div>

<div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Items</h1>
    <?php  //var_dump($articles); exit; ?>
    <?= GridView::widget([
        'dataProvider' => $items,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            'tags',
            'text',


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