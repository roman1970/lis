<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


$this->title = $model->isNewRecord ? 'Добавить Автора' : 'Редактировать Автора';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">


        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['id' => 'authors-form']); ?>

            <?= $form->field($model, 'name')->textInput()  ?>

            <?= $form->field($model, 'status')->dropDownList([0, 1, 2])->label('0 - неопубликованно, 1 - музыка, 2 - книга');  ?>

            <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map(\app\models\Country::find()->all(),'id','name'),
                ['prompt' => 'Выбрать страну'])  ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

