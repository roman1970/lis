<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


$this->title = $model->isNewRecord ? 'Добавить Карточку' : 'Редактировать Карточку';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar big-font">
            <p>&#223; c&#807</p>
            <p>ʌ, ə, æ, i, e, o, u</p>
            <p>ɑ:, ə:, i:, ɔ:, u:, &#596, u&#776, o&#776, a&#776, &#248, &#214, &#339, &#227</p>
            <p>ɑɪ, au, eɪ, əu, ɛə, ɪə, ɔɪ, uə</p>
            <p>f, h, k, p, s, ʃ, t, θ, ʧ
                b, d, g, ʒ, ʤ, ð, v, z,
                l, m, n, ŋ, r, j, w</p>


        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['id' => 'deutschitem-form']); ?>

            <?= $form->field($model, 'd_word')->textInput()  ?>
           
            <?= $form->field($model, 'd_phrase')->textInput()  ?>

            <?= $form->field($model, 'd_word_translation')->textInput()  ?>
            
            <?= $form->field($model, 'd_phrase_translation')->textInput()  ?>

            <?php /* $form->field($model, 'd_word_transcription')->textInput()  */?>
           
            <?php /* $form->field($model, 'd_phrase_transcription')->textInput()  */?>
            
            
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
<style>
    .big-font{
        font-size: 20px;
    }
</style>

