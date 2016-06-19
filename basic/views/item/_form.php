<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\jui\AutoComplete;
use app\models\Tag;

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

            <?php
            //фомируем список автокомплита
            $listdata = Tag::find()
                ->select(['name as label'])
                ->asArray()
                ->all();
            ?>

        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'title')->textInput()  ?>

            <?= $form->field($model, 'source_id')->dropDownList(ArrayHelper::map(\app\models\Source::find()->all(),'id','title'),
                ['prompt' => 'Выбрать источник'])  ?>

            <?= $form->field($model, 'text')->textarea(['rows' => 5, 'cols' => 5, 'id' => 'my-textarea-id'])  ?>
            <?php  $form->field($model, 'tags')->textInput()  ?>
            <?php echo $form->field($model, 'tags')->widget(
                AutoComplete::className(), [
                'clientOptions' => [
                    'source' => $listdata,
                    'minLength'=>'3',
                    'autoFill'=>true
                ],
                'options'=>[
                    'class'=>'form-control'
                ]
            ]);
            ?>
            <?= $form->field($model, 'audio_link')->textInput()  ?>
            <?= $form->field($uploadFile, 'file')->fileInput() ?>
            <?= $form->field($uploadImg, 'img')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
