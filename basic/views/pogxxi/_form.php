<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


$this->title = $model->isNewRecord ? 'Добавить текст' : 'Редактировать текст';
$this->params['breadcrumbs'][] = $this->title;

//фомируем список автокомплита

$sources = \app\models\Source::find()
    ->select(['title as label'])
    ->asArray()
    ->all();

?>


<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">

          <p><?= $model->year ?>-<?= $model->month ?>-<?= $model->date ?></p>

        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['id' => 'authors-form']); ?>

            <?= $form->field($model, 'title')->textInput()  ?>

            <?= $form->field($model, 'max_temp')->textInput()  ?>

            <?= $form->field($model, 'min_temp')->textInput()  ?>

            <?= $form->field($model, 'prim')->textarea(['rows' => 5, 'cols' => 5, 'id' => 'my-textarea-id'])  ?>

            

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

