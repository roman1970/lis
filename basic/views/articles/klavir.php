<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="site-login">
  

<div class="row">
    
    <div class="col-lg-12">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'minititle')->textInput()  ?>
        
        
            <?= $form->field($model, 'body')->textarea(['rows' => 5, 'cols' => 5, 'id' => 'input', 'onFocus' => 'runTime()', 'onkeyup' => 'calcSign(event.keyCode)'])  ?>


        <div class="form-group">
            <?= Html::submitButton('Готово', ['class' => 'btn btn-primary', 'name' => 'create-button', 'onClick' => 'result()']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="alert alert-success">

           Time: <p id="sho"></p>
           Sign: <p id="shoSign"></p>
    </div>


</div>
</div>
<script>

    var i = 0;
    var words = 0;
    var intervalID;
    var singInSecond;

    function runTime() {
        //идентификатор нужен для останова функции
        intervalID = setInterval(function () {
             i++;
             var sho = document.getElementById('sho');
             sho.innerHTML = i;
             //console.log(sho.innerHTML);
         }, 1000)
    }

    function calcSign(keyCode) {
        //if(keyCode == 8) sign--;
        if(keyCode == 32) words++;
        var shoSingn = document.getElementById('shoSign');
        shoSingn.innerHTML = words;
    }

    function result() {
        clearInterval(intervalID);
        singInSecond = words / (i / 60);
        alert('Ваша скорость составила: ' + singInSecond.toFixed(1) + ' слов в минуту');

    }

</script>


