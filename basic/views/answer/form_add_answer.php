<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="site-login">

    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['answer/update', 'questId' => $model->id]),
                'options' => [
                    'data-pjax' => '1'
                ],
                'id' => 'answersUpdateForm'
            ]); ?>

            <?= $form->field($model, 'body')->textInput()  ?>

            <h4>Ответы</h4>
            <table style="width: 100%">
            <?php $i=0; foreach ($model->answers as $key => $answer): $i++; ?>
                <tr>
                    <td><?= $i.') '?></td>
                    <td style="width: 80%"> <?= $form->field($answer, "[$key]body") ?> </td>
                    <td> <?= $form->field($answer, "[$key]true") ?> </td>
                </tr>
            <?php endforeach ?>
            </table>
            <?= Html::a('Добавить ответ', Url::toRoute(['answer/add', 'questId' => $model->id]), [
                'class' => 'btn btn-success',
            ]) ?>

            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>