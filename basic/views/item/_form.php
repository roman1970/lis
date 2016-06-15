<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


$this->title = $model->isNewRecord ? 'Добавить айтем' : 'Редактировать айтем';
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



                ],
            ]);

            ?>

        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'title')->textInput()  ?>

            <?= $form->field($model, 'source_id')->dropDownList(ArrayHelper::map(\app\models\Source::find()->all(),'id','title'),
                ['prompt' => 'Выбрать источник'])  ?>

            <?= $form->field($model, 'text')->textarea(['rows' => 5, 'cols' => 5, 'id' => 'my-textarea-id'])  ?>
            <?= $form->field($model, 'tags')->textInput()  ?>
            <?= $form->field($uploadFile, 'file')->fileInput() ?>
            <?= $form->field($uploadImg, 'img')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
