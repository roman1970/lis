<?php
use yii\helpers\Html;
?>
<h2>You want information?</h2>
<div class="block"> 
<?= HTML::a('Отчёт 2014', \yii\helpers\BaseUrl::toRoute(\Yii::$app->getModule('diary')->fourteenUrl[0]."?year=2014"), 
        ['title' => "", 'style' => 'text-decoration: none;']) ?> </div>
<div class="block"> 
<?= HTML::a('Отчёт 2015', \yii\helpers\BaseUrl::toRoute(\Yii::$app->getModule('diary')->fourteenUrl[0]."?year=2015"), 
    ['title' => "", 'style' => 'text-decoration: none;']) ?> 
</div>