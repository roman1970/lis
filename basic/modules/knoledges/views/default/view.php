<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\widgets\Pjax;

$article_content_id = 1;
?>
<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#new_note").on("pjax:end", function() {
            $.pjax.reload({container:"#notes"});
        });
    });'
);
?>
<div class="single">

		<div class="mb20">
           <span class="day"> <?= $title ?></span>  <div class="source"> <?= $author ?> - <?= $source ?> </div>
		</div>

	<h1 class="single__title index-tit mt0 mb10 rbt-c upper">

		<span><?php foreach ($contents as $article) :
                $article_content_id = $article->id; ?>
           <?= app\components\KnoledgesPagination::widget([
                'pagination' => $pages,
            ]);
            ?>

               <div class="blue"> <?= $article->minititle ?> </div>
                  <?php if($article->audio) : ?>
                    <audio controls="controls" class="audio">
                        <source src='<?=Url::to($article->audio)?>' type='audio/mpeg'>
                    </audio>
                <?php endif; ?>

                <?= $article->body ?>


            <?= app\components\KnoledgesPagination::widget([
                'pagination' => $pages,
            ]);
            ?>
            <?php endforeach; ?>
        </span>
	</h1>

</div>
<aside>
    <?php /*DatePicker::widget(['name' => 'date']) */ ?>

    <?= \app\components\CommentsWidget::widget(['article_id' => $article_content_id,
        'module_path' => \Yii::$app->view->theme->baseUrl]) ?>
    <?php Pjax::begin(['id' => 'my-pjax']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>


        <?= $form->field($comment, 'name')->textInput(); ?>
        <?= $form->field($comment, 'body')->textarea(['rows' => 5, 'cols' => 5, 'id' => 'my-textarea-id']) ?>


        <?= \yii\helpers\Html::submitButton('Комментировать', ['class' => 'btn btn-primary']);?>
        <?php ActiveForm::end();?>
    <?php Pjax::end(); ?>
        <?php /*
        $form = ActiveForm::begin(/*[
            'id' => 'login-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
            'template' => '{label}<div class="col-sm-10">{input}</div><div class="col-sm-10">{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
            ],
        ]);
        //var_dump($comment);
        $form->field($comment, 'body')->textInput();
        ActiveForm::end();
       */ ?>



</aside>
