<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="site-login">
  

<div class="row">
    
    <div class="col-lg-12">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'minititle')->textInput()  ?>
        
        
            <?= $form->field($model, 'body')->textarea(['rows' => 5, 'cols' => 5, 'id' => 'input', 'onFocus' => 'runTime()', 'onkeyup' => 'calcSign()'])  ?>


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
    var sign = 0;
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

    function calcSign() {
        sign++;
        var shoSingn = document.getElementById('shoSign');
        shoSingn.innerHTML = sign;
    }

    function result() {
        clearInterval(intervalID);
        singInSecond = sign / i;
        alert('Ваша скорость составила: ' + singInSecond + 'знаков в секунду');

    }

</script>


