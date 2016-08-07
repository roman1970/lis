<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\KrokodileAsset;

KrokodileAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/jquery-ui-git.js"></script>

    <?= Html::csrfMetaTags() ?>
  
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container">
    <header>
        <div class="logo">
            <h1 class="main_title">Today <?=date('d M Y', time()) ?></h1>
        </div>
     

    </header>

    <?= Nav::widget([
        'options' => ['class' => 'nav nav-pills nav-stacked nav-justified'],
        'items' => [
            ['label' => 'СЪЕЛ', 'url' => ['eat'], 'class' => 'panel panel-primary'],
            ['label' => 'КУПИЛ', 'url' => ['bye']],
            ['label' => 'СДЕЛАЛ', 'url' => ['done']],
            ['label' => 'ЗАМЕР', 'url' => ['measure']],
            ['label' => 'ЗНАНИЯ', 'url' => ['knowledge']],

        ],
    ]);
    ?>

    <?=$content?>
</div>

<footer>
    <div class="container"></div>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
