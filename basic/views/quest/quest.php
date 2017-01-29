<?php
use yii\widgets\Pjax;
?>
<?php var_dump($model); ?>

<?php Pjax::begin(['enablePushState' => false]); ?>
<?= $this->render('answers', ['model' => $model]) ?>
<?php Pjax::end(); ?>
