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
            <?php
            //фомируем список автокомплита
            $data = \app\models\Source::find()
                ->select(['title as label'])
                ->asArray()
                ->all();
            //var_dump($data); exit;
            ?>

        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'minititle')->textInput()  ?>

            <?= $form->field($upload, 'file')->fileInput() ?>

            <?php echo $form->field($model, 'source_title')->widget(
                \yii\jui\AutoComplete::className(), [
                'clientOptions' => [
                    'source' => $data,
                    'minLength'=>'3',
                    'autoFill'=>true
                ],
                'options'=>[
                    'class'=>'form-control'
                ]
            ]);
            ?>
            <?php if(!$redactor) :   ?>
                <?= $form->field($model, 'body')->textarea(['rows' => 5, 'cols' => 5, 'id' => 'my-textarea-id'])  ?>
            <?php else : ?>

            <?= $form->field($model, 'body')->widget(Widget::classname(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 300,
                    'pastePlainText' => true,
                    //'buttons' => ['html', 'formatting', 'bold', 'italic'],
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

            <?php endif; ?>


            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
