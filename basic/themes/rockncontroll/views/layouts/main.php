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

    <?= Html::csrfMetaTags() ?>
  
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<style type="text/css">
    body{
        background: rgb(119, 165, 179);
    }

    table{
        width: 100%;
    }

     .table_data > tbody > tr > td{
         padding: 0;
         width: 20%;
         color: currentColor;
         font-size: 15px;
     }

    header{
        background-color: rgb(92, 184, 92);
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
