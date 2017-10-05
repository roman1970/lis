<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>

<div class="container">

    <div class="col-sm-12">

        <!-- Contact Form -->

        <?php //if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <?php \yii\widgets\Pjax::begin(['id' => 'my-pjax']); ?>
        <?php if (isset($success)): ?>
             <div class="form-sent" style="display: block">

                <div class="alert alert-success">

                    <strong>Ваше сообщение отправлено.</strong> Спасибо!

                </div>

            </div>


        <?php else : ?>


        <?php $form = ActiveForm::begin(['id' => 'conta-form', 'action' => ['/plis'], 'options' => ['data-pjax' => true]]); ?>

                <div class="col-md-5 col-sm-5 col-xs-12 animated hiding" data-animation="slideInLeft">

                    <div class="form-group">

                        <?= $form->field($model, 'name')->textInput(['class' => 'form-control input-lg', 'placeholder' => 'Имя'])->label(false)  ?>

                    </div>


                    <div class="form-group">

                        <?= $form->field($model, 'email')->textInput(['class' => 'form-control input-lg', 'placeholder' => 'Email'])->label(false)  ?>


                    </div>


                    <div class="form-group">

                        <?php /*$form->field($model, 'subject')->textInput(['class' => 'form-control input-lg', 'placeholder' => 'Subject'])->label(false)  */?>

                    </div>

                    <?php /* $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                        'captchaAction' => 'site/captcha',
                    ]) */ ?>



                </div>

                <div class="col-md-7 col-sm-7 col-xs-12 animated hiding" data-animation="slideInRight">

                    <div class="form-group">

                        <?= $form->field($model, 'body')->textArea(['class' => 'form-control input-lg', 'placeholder' => 'Сообщение'])->label(false)  ?>

                    </div>

                </div>

                <div class="form-group">

                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-custom up animated hiding letter', 'value' => 'Отправить', 'data-animation' => 'fadeInUpBig']) ?>

                </div>




        <?php ActiveForm::end(); ?>

        <?php endif; ?>

        <?php \yii\widgets\Pjax::end(); ?>

        <!-- End Contact Form -->

    </div>

</div>

