<?php  use miloschuman\highcharts\Highcharts; ?>

<script>
    var arr = [];
    $(document).ready(function() {
       // alert($.cookie('the_cookie'));

        if($.cookie('the_cookie') === 'the_value') {
            $.ajax({
                type: "GET",
                url: "/rockncontroll/default/login/",
                data: "name=рома&pseudo=папа",
                success: function(html){
                    $("#rechange").html(html);
                }

            });
        }


      
    });

   
    function login(){
  //  $.cookie('the_cookie', 'the_value', { expires: 90 });

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
            success: function(html){
                    $("#rechange").html(html);
                    $.cookie('name', name+pseudo, { expires: 7 });

                }

            });

    }

</script>
<style>
    .alert
    {
        padding: 0;
    }
</style>

<header>
    <div class="logo">
       <h1 style="font-size: 35px"> <?=$denzhisni?>-<?=date('z-W-M-d-D', time()+3*60*60) ?></h1>
        <?php //phpinfo();/*<p id="radio"></p>*/ ?>
        <!--Div that will hold the pie chart
        <div id="vis_div" style="width: 100%; height: 200px;"></div>-->
    </div>
</header>
<div class="container">
    <div id="rechange">
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
    <div id="summary"></div>

    
    
</div>

<script>


    /*setInterval(function () {
     $.ajax({
     type: "GET",
     url: "rockncontroll/default/rand-item/",
     success: function(html){
     $("#rand_item").html(html);
     h = html;
     }

     });

     }, 20000);
     */


    /*setTimeout(function run() {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/show-current-radio-tracks/",
            success: function(html){
                $("#radio").html(html);
            }

        });
        setTimeout(run, 10000);

    }, 10000);
    */



        
</script>
