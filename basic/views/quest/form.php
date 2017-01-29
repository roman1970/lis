<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\jui\AutoComplete;

?>
    <div class="site-login">
        <h4>Добавить вопрос</h4>
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">

            </div>
            <div class="col-lg-10">
                <?php
                //фомируем список автокомплита
                $caters = \app\models\Categories::find()
                    ->select(['title as label'])
                    ->asArray()
                    ->all();
                ?>
                <?php $form = ActiveForm::begin(['id' => 'quest-form']); ?>

                    <?= $form->field($model, 'body')->textInput()  ?>
                    <?php echo $form->field($model, 'cat_title')->widget(
                        AutoComplete::className(), [
                        'clientOptions' => [
                            'source' => $caters,
                            'minLength'=>'3',
                            'autoFill'=>true
                        ],
                        'options'=>[
                            'class'=>'form-control'
                        ]
                    ]);
                    ?>
                
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
