<?php

use app\assets\Russia2018Asset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;

Russia2018Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="language" content="ru" />
        <?php /*<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="/themes/russia2018/js/jQuery-autoComplete-master/jquery.auto-complete.js"></script>
 */?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/jquery-ui-git.js"></script>


        <link href="css/flags.css" rel="stylesheet">

        <?php $this->head() ?>
    </head>

    <body>
       
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => 'Твой прогноз',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Зарегистрироваться', 'url' => ['default/registration']],
                ['label' => 'Войти', 'url' => ['default/login']]
            ],
        ]);
        NavBar::end();

        ?>

        <?= $content ?>


    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
