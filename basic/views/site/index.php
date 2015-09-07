<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать в административную часть!</h1>


        <p><a class="btn btn-lg btn-success" href="<?=  Yii::$app->user->isGuest ? '/user/security/login' : '/user/security/logout' ?>">Войти</a></p>
    </div>


</div>
