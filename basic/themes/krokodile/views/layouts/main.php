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

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container">
    <header>
        <div class="logo">
            <h1 class="main_title">КРОКОДИЛ ЕВГЕНА</h1>
        </div>
        <p>Выпуск №1</p>
    </header>

    <?=$content?>
</div>

<footer>
    <div class="container"></div>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
