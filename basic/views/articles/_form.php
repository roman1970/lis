<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


$this->title = 'Добавить контент';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>



    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['id' => 'create-form']); ?>

            <?= $form->field($model, 'title')->textInput()  ?>
            <?= $form->field($model, 'site_id')->dropDownList(ArrayHelper::map(\app\models\Qpsites::find()->all(),'id','title'),
                ['prompt' => 'Выбрать сайт']) ?>
             <?= $form->field($model, 'cat_id')->dropDownList(ArrayHelper::map(\app\models\Categories::find()->all(),'id','name'),
                ['prompt' => 'Выбрать категорию'])  ?>
            <?= $form->field($model, 'text')->textarea()  ?>


            <div class="form-group">
                <?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
</div>
