<script>

    function login(){
        var name = $("#logg").val();
        var pseudo = $("#pswd").val();

        //Валидация
        if (name  === "" ) {
            alert("Введите имя");
            return false;
        }

        if (pseudo === "") {
            alert("Введите псевдоним");
            return false;
        }
        //$("#login").hide();


        $.ajax({
            type: "GET",
            url: "/rockncontroll/default/login/",
            data: "name="+name+"&pseudo="+pseudo,
            success: function(user){
                if(user){
                    window.location = 'choosegroup/'+user;
                }
                 else {
                    $('#logg').trigger('reset');
                    $('#pswd').trigger('reset');
                    alert("Такого пользователя нет");

                }
                //$.cookie('username', user, { expires: 7 });
               // var test = $.cookie('username'); // получение кук

            }

        });
    }

</script>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>


<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
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
                <p class="form">Имя</p>
                <input type='text' class="form-control" id="logg" placeholder="Введите имя"/>
                <p class="form">Псевдоимя</p>
                <input type='text' class="form-control" id="pswd" placeholder="Введите псевдоним"/>

                <button class="btn" id="login" onclick="login()" >Войти</button>
                <div id="res"></div>
            </div>
        </div>

    </div>
</div>
