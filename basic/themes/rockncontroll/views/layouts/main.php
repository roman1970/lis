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
<style type="text/css">
    body{
        background: rgb(119, 165, 179);
    }
    header{
        background-color: rgb(109, 188, 65);;
        border-radius: 5%;
    }
</style>

<div class="container">
    

    <?=$content?>
</div>

<footer>
    <div class="container"></div>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
