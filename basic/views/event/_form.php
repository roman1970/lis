<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;


?>
<div class="site-login">
    <div class="site-login">
        <h1 class="text-center">Добавить картинку событию </h1>
        <p style="font-size: 12px"><?= $model->text ?></p>

    <div class="row">

        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


            <?= $form->field($uploadImg, 'img')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

