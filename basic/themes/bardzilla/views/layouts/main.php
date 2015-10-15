<?php

use app\assets\BardzillaAsset;
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;

BardzillaAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <title>Бард, который перевернул ЗИЛ</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?=$this->theme->getUrl('Img/favicon.ico')?>" tvpe="imaqe/x-icon" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,400italic,700&subset=cyrillic-ext,latin' rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/bounce.js-0.8.2/bounce.min.js"></script>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div id="wrapper" >
    <div id="logo" class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div id="phot_h">
                Бард, который перевернул ЗИЛ и его друзья
               <?php /* <img src="<?=$this->theme->getUrl('Img/teatr_nov_1.png')" alt="Бард, который перевернул ЗИЛ" width="1100" height="100" /> */?>
            </div>

            <div id="phrase"></div>
        </div>


    </div>
</div>
    <?= $content ?>
<div id="wrapper" >
    <div class="cont row">
        <div class="col-md-3 ">
                <div id="rom"> </div>
                <div id="footer">
                    <p>    Copyright &copy;2014 Б'КПЗ <br/>

                    </p>
                </div>
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12">


            <p id='play'>О! Здравствуй, Мой Дорогой Гость! Ты забрёл ко мне случайно?<br />
                    Не спеши закрыть бездверие моей пещеры <br />
                    Почитай, посмотри, послушай...<br />
                    Что? Твой указательный палец невольно тянется к виску?<br />
                    Твой грустный рот растягивается в ненормальную ухмылку? <br />
                    Ты в недоумении и никак не можешь выйти из этого состояния?  <br />
                    За все эти вопросы Тебе, Мой Дорогой Гость,<br />
                    ответит Король Анормального - Бард, который перевернул ЗИЛ! <br />
                    <br />

            <?php /*

                    <iframe  width="560" height="315" src="//www.youtube.com/embed/Li_Odfte4nY"  allowfullscreen></iframe>
            */ ?>

            </p>


            <p id="main">

            </p>



        </div>


        <div class="col-md-3 " >
            <div id="mish" >
            </div>

            <div id="footerr">
                <p  id="site">  <a href="#">  Закажи оригинальный <br/>
                            сайт </a>
                    <br/>
                </p>
            </div>


        </div>

    </div>
</div>

    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
