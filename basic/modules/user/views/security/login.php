<script>
    function login(){
        var log = $("#logg").val();
        var pswd = $("#pswd").val();
        alert(log);
        //Валидация
        if (log === "" ) {
            alert("Введите логин");
            return false;
        }

        if (pswd === "") {
            alert("Введите пароль");
            return false;
        }
        alert("khjkg");
        //$("#song").show();
        //$("#song").load("security/login");
        /*$.ajax({
            method: "POST",
            url: "security/login",
            data: { login: log, password: pswd }
        })
            .done(function( msg ) {
                alert( "Data Saved: " + msg );
            });
        /*

        if (!last) {y = document.getElementById("song");
            var last = y.lastChild;
            last.parentNode.removeChild(last);
        }

        $("#count_").ajaxSuccess(function() { //убираем количество после голосования
            $(this).text(name);
            $(this).hide();

        });
        */

    }
</script>

<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View                   $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module           $module
 */

$this->title = Yii::t('user', 'Вход');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php
                /* $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>

                <?= $form->field($model, 'login', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]) ?>

                <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'id' => 'pswd']])->passwordInput()->label(Yii::t('user', 'Пароль') . ($module->enablePasswordRecovery ? ' (' . Html::a(Yii::t('user', 'Забыли пароль?'), ['/user/recovery/request'], ['tabindex' => '5']) . ')' : '')) ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>

                <?= Html::submitButton(Yii::t('user', 'Вход'), ['class' => 'btn btn-primary btn-block', 'tabindex' => '3', 'onclick' => 'login()']) ?>

                <?php ActiveForm::end();

                */
                ?>

                <input type='text' class="form-control" id="logg" />
                <input type='password' class="form-control" id="pswd" />

                <button class="button glyphicon glyphicon-search" id="choose_country" onclick="login()" ></button><br>
                <div id="song"></div>
            </div>
        </div>
        <?php if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Не получили сообщение с подтверждением регистрации?'), ['/user/registration/resend']) ?>
            </p>
        <?php endif ?>
        <?php if ($module->enableRegistration): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Если у Вас нет аккаунта, зарегистрируйтесь!'), 'http://qplis.ru/user/registration/register') ?>
            </p>
        <?php endif ?>
        <?= Connect::widget([
            'baseAuthUrl' => ['/user/security/auth'],
        ]) ?>
    </div>
</div>
