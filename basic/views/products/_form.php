<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


$this->title = $model->isNewRecord ? 'Добавить товар' : 'Редактировать товар';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php

            echo Nav::widget([
                'options' => ['class' => 'nav nav-sidebar'],
                'items' => [

                    //['label' => 'Добавить страницу', 'url' => ['/articles/addpage/'.$model->id]],

                ],
            ]);

            ?>

        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'name')->textInput()  ?>

            <?= $form->field($model, 'cat_id')->dropDownList(ArrayHelper::map(\app\models\Categories::find()->where(['site_id' => 11])->all(),'id','name'),
                ['prompt' => 'Выбрать категорию'])
             //@TODO site_id - текущий ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 5, 'cols' => 5, 'id' => 'my-textarea-id'])  ?>
            <?= $form->field($model, 'price')->textInput()  ?>

            <?= $form->field($uploadImg, 'img')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

