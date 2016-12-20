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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    

    <?= Html::csrfMetaTags() ?>
  
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<style type="text/css">
    .btn-success {
        color: rgb(255, 255, 255);
        background-color: rgb(62, 149, 137);
        border-color: rgb(62, 149, 137);
    }
    .btn-success:hover{
        background-color: rgb(42, 83, 109);
        border-color: rgb(62, 90, 149);
    }

    .alert-success {
        color: rgb(231, 228, 214);
        background-color: rgb(42, 83, 109);
        border-color: rgb(62, 90, 149);
    }

    body{
        background: rgb(42, 83, 109);
        font-family: "Verdana", "sans-serif";
    }

    table{
        width: 100%;
    }

     .table_data > tbody > tr > td{
         padding: 0;
         width: 16.66%;
         color: currentColor;
         font-size: 14px;
     }

    header{
        background-color: rgb(62, 149, 137);
        border-radius: 5%;
        color: white;
    }
    .alert > p {

        text-align: center;
    }
    @media(min-width:1199px) {
        .container {
            width: 1100px;

        }
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
