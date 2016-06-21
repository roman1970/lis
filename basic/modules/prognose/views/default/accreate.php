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
        $("#login").hide();


        $.ajax({
            type: "GET",
            url: "/markself/default/login/",
            data: "name="+name+"&pseudo="+pseudo,
            success: function(user){

                window.location = 'choosegroup/'+user;
                $.cookie('username', user, { expires: 7 });
                // var test = $.cookie('username'); // получение кук

            }

        });
    }

</script>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->params['breadcrumbs'][] = 'Вход';
if(isset($name)) echo $name;
?>


<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">

                <p class="form">Имя</p>
                <input type='text' class="form-control" id="name" placeholder="Введите название оцениваемого действия"/>
                <p class="form">Псевдоимя</p>
                <input type='text' class="form-control" id="pswd" placeholder="Введите псевдоним"/>

                <button class="btn" id="login" onclick="login()" >Войти</button>
                <div id="res"></div>
            </div>
        </div>

    </div>
</div>
