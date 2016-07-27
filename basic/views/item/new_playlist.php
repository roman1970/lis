<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\jui\AutoComplete;
use app\models\Tag;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


?>
<div class="site-login">
    <h1 class="text-center">Плэйлист</h1>

    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">

        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($playlist, 'name')->textInput()  ?>


            <div class="form-group">
                <?= Html::submitButton($playlist->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>