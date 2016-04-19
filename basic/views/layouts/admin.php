<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="/js/syntaxhighlighter/scripts/shCore.js"> </script>
    <script src="/js/syntaxhighlighter/scripts/shBrushJScript.js"></script>
    <script src="/js/syntaxhighlighter/scripts/shBrushPhp.js"></script>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Панель администратора',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Nav::widget([
            'options' => ['class' => 'nav nav-tabs'],
            'items' => [
            ['label' => 'Сайты', 'url' => ['/qpsites/index']],
            ['label' => 'Категории', 'url' => ['/categories/index']],
            ['label' => 'Контент', 'url' => ['/articles/index']],
            ['label' => 'Товары', 'url' => ['/products/index']],
            ['label' => 'Пользователи', 'url' => ['/rbac/role/index']],
            ['label' => 'Страны', 'url' => ['/countries/index']],
            ['label' => 'Источники', 'url' => ['/source/index']],
            ['label' => 'Авторы', 'url' => ['/author/index']],
            ['label' => 'CodeHelp', 'url' => ['/jstests/index']],
            ['label' => 'Тесты', 'url' => ['/testing/index']],
            ['label' => 'Diary', 'url' => ['/diary/default/index']],
            ['label' => 'Репертуар', 'url' => ['/repertuar/default/index']],
            ['label' => 'КХЛ', 'url' => ['/khl/default/index']],
            ],
        ]);
        ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; qpLIS <?= date('Y') ?></p>

        <p class="pull-right">Все права защищены</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
