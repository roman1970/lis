<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


$this->title = $model->isNewRecord ? 'Добавить страницу' : 'Редактировать страницу';
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
                    ['label' => 'Добавить страницу', 'url' => ['/articles/addpage/'.$model->id]],

                ],
            ]);

            ?>

        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'minititle')->textInput()  ?>

            <?= $form->field($upload, 'file')->fileInput() ?>
            <?= $form->field($model, 'source_id')->dropDownList(ArrayHelper::map(\app\models\Source::find()->all(),'id','title'),
                ['prompt' => 'Выбрать источник'])  ?>
            <?= $form->field($model, 'body')->widget(Widget::classname(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 300,
                    'pastePlainText' => true,
                    'buttonSource' => true,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ],
                    //'imageManagerJson' => Url::to(['/articles/images-get']),
                    'imageUpload' => Url::to(['/articles/image-upload']),

                    //'fileManagerJson' => Url::to(['/uploads/files-get']),
                    //'fileUpload' => Url::to(['/uploads/file-upload'])
                ]

            ]);?>




            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
