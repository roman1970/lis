<?php

use app\assets\LandberryAsset;
use app\components\Helper;
use yii\helpers\Html;

LandberryAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Наши проекты</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <!--[if lt IE 9]>
        <script src="../html5shim.googlecode.com/svn/trunk/html5.js" tppabs="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,100italic,100,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>


        <?php $this->head() ?>

    </head>

    <body>
    <?php $this->beginBody() ?>


    <!-- Preloader -->

    <div id="mask">

        <div id="loader">

        </div>

    </div>

    <!-- End Preloader -->



    <!-- Home Section -->

    <section id="home" class="parallax">

        <div class="parallax-overlay-light">

            <div class="container">

                <div class="hero">

                    <!-- Home Slider -->

                    <div class="home-slider">

                        <ul class="slides">

                            <li>

                                <h1><span>ОЧЕНЬ ИНТЕРЕСНО</span></h1>

                            </li>

                            <li>

                                <h1><span>ИНФОРМ-АГЕНСТВО</span></h1>

                            </li>

                            <li>

                                <h1><span>"ДРУГАЯ СТОРОНА ЗЕМЛИ"</span></h1>

                            </li>

                        </ul>

                    </div>

                    <!-- End Home Slider -->




                </div>

            </div>

        </div>

    </section>

    <!-- End Home Section -->



    <!-- Header -->

    <header class="navbar navbar-default topnav" role="banner">

        <div class="container">

            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">

                    <span class="sr-only">Меню</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                </button>

                <a class="navbar-brand" href="#home" id="logo">
                    <?= Helper::echoImg('@app/themes/landberry/images/logo1.png') ?>
                   <?php // <img src="@app/themes/landberry/images/logo1.png" width="133" alt="WP Media"></a> ?>

            </div>

            <div class="collapse navbar-collapse" id="navigation">

                <ul id="nav" class="nav navbar-nav navbar-right">

                    <li class=""><a href="#about">О НАС</a></li>
                    <li><a href="#works">ПРОЕКТЫ</a></li>
                    <li><a href="#contact">КОНТАКТЫ</a></li>

                </ul>


            </div>

        </div>

    </header>

    <!-- End Header -->



    <!-- About Section -->

    <section id="about" class="section">

        <div class="container">

            <div class="title col-md-8 col-sm-10 col-xs-12">

                <h1><img src="../images/logo.png" alt="WP Media"></h1>

            </div>

            <!-- About Text -->

            <div class="promo-line">

                <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class="row">

                        <div class="promo right animated hiding" data-animation="fadeInLeft">

                            <div class="col-lg-10 col-md-10 col-sm-11 col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-sm-12 promo-icon-box">

                                <div class="promo-icon">

                                    <i class="fa fa-user"></i>

                                </div>

                            </div>

                            <div class="col-lg-10 col-md-10 col-sm-11 col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-sm-12">

                                <h4>Кто мы</h4>

                                <p>
                                    КОМАНДА РАЗРАБОТЧИКОВ

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class="row">

                        <div class="promo animated hiding" data-animation="fadeInRight">

                            <div class="col-md-10 col-sm-11 promo-icon-box">

                                <div class="promo-icon">

                                    <i class="fa fa-rocket"></i>

                                </div>

                            </div>

                            <div class="col-md-10 col-sm-11">

                                <h4>ЧТО МЫ ДЕЛАЕМ</h4>

                                <p>Мы занимаемся разработкой полезных, информативных сайтов с уникальной информацией. пользовательский опыт. </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- End About Section -->

    <?= $content ?>



    <script>
        (function (window) {
            var elem = document.querySelector('#year');
            elem.appendChild(document.createTextNode((new Date).getFullYear()));
        })(window);

        $('.for-event-akula').on('click', function(){

            $.ajax({
                type: 'POST',
                url: 'send.php',
                data: $("#contact-us").serialize(),
                success: function(data) {

                    $('#contact-us').hide();
                    $('.form-sent').show();

                }
            });


        });
    </script>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>