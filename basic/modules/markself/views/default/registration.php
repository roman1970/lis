<script>
    function reg(){
        var log = $("#logg").val();
        var pswd = $("#pswd").val();

        //Валидация
        if (log === "" ) {
            alert("Введите имя");
            return false;
        }

        if (pswd === "") {
            alert("Введите псевдоним");
            return false;
        }

        $.ajax({
            type: "GET",
            url: "/markself/default/registration/",
            data: "name="+log+"&pseudo="+pswd,
            success: function(html){
                //$('#logg').trigger('reset');
                //$('#pswd').trigger('reset');
                $("#res").html(html);
            }

        });
    }
</script>

<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = 'Регистрация';
?>


<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">


                <p class="form">Введите Имя</p>
                <input type='text' class="form-control" id="logg"/>
                <p class="form">Введите Псевдоимя</p>
                <input type='text' class="form-control" id="pswd" />

                <button class="button" id="reg" onclick="reg()" >Зарегистрироваться</button>

                <div id="res" class="form"></div>
            </div>
        </div>

    </div>
</div>
