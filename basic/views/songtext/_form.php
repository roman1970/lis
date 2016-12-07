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


        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['id' => 'authors-form']); ?>

            <?= $form->field($model, 'title')->textInput()  ?>

            <?= $form->field($model, 'text')->textarea(['rows' => 5, 'cols' => 5, 'id' => 'my-textarea-id'])  ?>

            <?php echo $form->field($model, 'source_title')->widget(
                AutoComplete::className(), [
                'clientOptions' => [
                    'source' => $sources,
                    'minLength'=>'3',
                    'autoFill'=>true
                ],
                'options'=>[
                    'class'=>'form-control',
                    'value'=> $model->isNewRecord ? '' : \app\models\Source::findOne($model->source_id)->title
                ]
            ]);
            ?>

            <?= $form->field($model, 'link')->textInput()  ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

