<?php

/* @var $this \yii\web\View */
/* @var $content string */


use app\assets\LandberryAsset;
use yii\helpers\Html;

LandberryAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Интернет-издательство «Акула Пераhfhf»</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

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

                            <h1><span>АКУЛА ПЕРА</span></h1>

                        </li>

                        <li>

                            <h1><span>ИНТЕРНЕТ-ИЗДАТЕЛЬСТВО</span></h1>

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
                <?= Html::img('/images/logo1.png') ?>
             <?php //  <img src="@app/themes/landberry/images/logo1.png" width="133" alt="WP Media"></a> ?>

        </div>

        <div class="collapse navbar-collapse" id="navigation">

            <ul id="nav" class="nav navbar-nav navbar-right">

                <li class=""><a href="#about">О НАС</a></li>
                <li><a href="#works">ПРОЕКТЫ</a></li>
                <li><a href="#advertisers">АГЕНСТВАМ</a></li>
                <li><a href="#promote">ПРЕЙМУЩЕСТВА</a></li>
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

            <h1><img src="images/logo.png" alt="WP Media"></h1>

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

                            <p>Интернет-издательство «Акула Пера» занимается созданием и развитием более 60-ти веб-проектов различных тематик с общей посещаемостью около 500 000 в сутки

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

                            <p>Мы&nbsp;занимается развитием собственных контентных

                                проектов, привлекаем активную целевую аудиторию и&nbsp;обеспечиваем уникальный пользовательский опыт. </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- End About Section -->



<!-- Works Section -->

<section id="works" class="section">

    <div class="container">

        <div class="title col-md-12 col-sm-12 col-xs-12">

            <h1>САМЫЕ <strong>ПОПУЛЯРНЫЕ ПРОЕКТЫ</strong></h1>

            <hr>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/projects/kuking.jpg" alt="">

                    <a href="http://kuking.net" target="_blank" class="team-overlay">

                        <span class="top">30000 уникальных посетителей<br>в день</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>KUKING</h3>

                    <p>Проект по женской тематике</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/projects/sonnik.jpg" alt="">

                    <a href="http://sonnik-online.net" target="_blank" class="team-overlay">

                        <span class="top">60000 уникальных посетителей<br>в день</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>SONNIK-ONLINE</h3>

                    <p>Проект по гороскопам</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/projects/uk.jpg" alt="">

                    <a href="http://uznai-kak.ru" target="_blank" class="team-overlay">

                        <span class="top">40000 уникальных посетителей<br>в день</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>УЗНАЙ КАК!</h3>

                    <p>Проект по женской тематике</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/projects/8lap.jpg" alt="">

                    <a href="http://8lap.ru" target="_blank" class="team-overlay">

                        <span class="top">45000 уникальных посетителей<br>в день</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>8 ЛАП</h3>

                    <p>Проект по животным</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/projects/snynet.jpg" alt="">

                    <a href="http://сны.net" target="_blank" class="team-overlay">

                        <span class="top">50000 уникальных посетителей<br>в день</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>СНЫ.НЕТ</h3>

                    <p>Проект по гороскопам</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/projects/yod.jpg" alt="">

                    <a href="http://yod.ru" target="_blank" class="team-overlay">

                        <span class="top">15000 уникальных посетителей<br>в день</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>YOD.RU</h3>

                    <p>Проект по женской тематике</p>

                </div>

            </div>

        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/projects/pinetka.jpg" alt="">

                    <a href="http://pinetka.com" target="_blank" class="team-overlay">

                        <span class="top">10000 уникальных посетителей<br>в день</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>PINETKA</h3>

                    <p>Проект по женской тематике</p>

                </div>

            </div>

        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/projects/misseva.jpg" alt="">

                    <a href="http://misseva.ru" target="_blank" class="team-overlay">

                        <span class="top">15000 уникальных посетителей<br>в день</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>MISSEVA</h3>

                    <p>Проект по женской тематике</p>

                </div>

            </div>

        </div>


    </div>

</section>

<!-- End Works Section -->



<!-- Numbers Section -->

<section id="numbers" class="parallax">

    <div class="parallax-overlay">

        <div class="container">

            <h3 class="center up"><span>[</span> В <b>цифрах</b> <span>]</span></h3>

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="counter animated hiding rbc" data-animation="fadeInDown" data-delay="0">

                    <div class="value-box"><span class="value" data-from="0" data-to="6">5</span>00 000</div>
                    <img src="images/line.png" alt="">
                    <small>уникальных пользователей в сутки</small>

                </div>

            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="counter animated hiding rbc" data-animation="fadeInDown" data-delay="500">

                    <div class="value-box"><span class="value" data-from="0" data-to="100">60</span></div>
                    <img src="images/line.png" alt="">
                    <small>сайтов самых разных тематик</small>

                </div>

            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="counter animated hiding rbc" data-animation="fadeInDown" data-delay="1000">

                    <div class="value-box"><span class="value" data-from="0" data-to="36">45</span> 000 000</div>
                    <img src="images/line.png" alt="">
                    <small>просмотров в месяц</small>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- End Numbers Section -->



<!-- Services Section -->

<section id="services" class="section">

    <div class="container">

        <div class="title col-md-12 col-sm-12 col-xs-12">

            <h1>ТЕМАТИЧЕСКАЯ <strong>РЕКЛАМНАЯ КАМПАНИЯ</strong></h1>

            <hr>

            <p>Интернет-издательство «Акула Пера» располагает обширным спектром проектов самых разных тематик для размещения специализированной рекламы. </p>

            <br>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12 service-box">

            <div class="service animated hiding" data-animation="fadeInUp" data-delay="0">

                        <span class="fa-stack fa-4x">

                            <i class="fa fa-circle fa-2x fa-stack-2x"></i>

                            <i class="fa fa-github-square fa-stack-1x service-icon"></i>

                        </span>

                <h3>ДОМАШНИЕ ЖИВОТНЫЕ</h3>

                <p>8 000 000 просмотров в месяц</p>

            </div>

        </div>



        <div class="col-md-3 col-sm-6 col-xs-12 service-box">

            <div class="service animated hiding" data-animation="fadeInUp" data-delay="300">

                        <span class="fa-stack fa-4x">

                            <i class="fa fa-circle fa-2x fa-stack-2x"></i>

                            <i class="fa fa-star fa-stack-1x service-icon"></i>

                        </span>

                <h3>АСТРОЛОГИЯ И ГОРОСКОПЫ</h3>

                <p>12 500 000 просмотров в месяц</p>

            </div>

        </div>




        <div class="col-md-3 col-sm-6 col-xs-12 service-box">

            <div class="service animated hiding" data-animation="fadeInUp"
                 data-delay="600">

                        <span class="fa-stack fa-4x">

                            <i class="fa fa-circle fa-2x fa-stack-2x"></i>

                            <i class="fa fa-glass fa-stack-1x service-icon"></i>

                        </span>

                <h3>ЖЕНСКИЕ ПОРТАЛЫ</h3>

                <p>6 000 000 просмотров в месяц</p>

            </div>

        </div>


        <div class="col-md-3 col-sm-6 col-xs-12 service-box">

            <div class="service animated hiding" data-animation="fadeInUp" data-delay="900">

                        <span class="fa-stack fa-4x">

                            <i class="fa fa-circle fa-2x fa-stack-2x"></i>

                            <i class="fa fa-heartbeat fa-stack-1x service-icon"></i>

                        </span>

                <h3>МЕДИЦИНА</h3>

                <p>3 500 000 просмотров в месяц</p>

            </div>

        </div>




        <div class="clearfix"></div>
        <!--
                <div class="text-center">
                    <a href="" class="btn btn-custom animated hiding" data-animation="fadeInLeft" data-delay="900">
                        Узнать подробнее
                    </a>


                    <a href="" class="btn btn-custom btn-gray animated hiding" data-animation="fadeInLeft" data-delay="900">
                        Узнать стоимость траффика
                    </a>
                </div>
          -->
    </div>

</section>

<!-- End Services Section -->



<!-- Pricing Section -->

<section id="advertisers" class="section">

    <div class="container">

        <div class="title col-md-12 col-sm-12 col-xs-12">

            <h1><strong><span>[</span></strong> АГЕНТСТВАМ <strong><span>]</span></strong></h1>

            <hr>

            <p>На наших порталах вы можете провести полноценную имиджевую кампанию любой тематики. C помощью демографического

                таргетинга AdRiver мы можем предложить вам показ рекламы только на определённую аудиторию. </p>

        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <!-- Pricing Table -->

            <div class="plan animated hiding selected" data-animation="fadeInUp" data-delay="0">

                <div class="plan-heading">

                    <h3>ЖЕНСКИЙ ТРАФИК</h3>

                    <br><br>

                    <div class="hexagon">

                        <i class="fa fa-venus"></i>

                    </div>

                </div>

                <ul>

                    <!--  <li><strong>ЭФФЕКТИВНОСТЬ</strong> ТАРГЕТИРОВАНИЯ

                           ПОДТВЕРЖДЕНА ИССЛЕДОВАНИЯМИ

                           TNS</li> -->

                    <li>ОСНОВНАЯ ЧАСТЬ ЦЕЛЕВЫХ ПОСЕТИТЕЛЕЙ

                        <strong>ЖЕНЩИНЫ</strong></li>

                    <li>БОЛЕЕ <strong>6 МИЛЛИОНОВ</strong> ПРОСМОТРОВ В МЕСЯЦ</li>

                    <li><strong>2 МИЛЛИОНА</strong> ПОКАЗОВ - МОСКВА</li>

                    <li><strong>2 МИЛЛИОНА</strong> ПОКАЗОВ - САНКТ-ПЕТЕРБУРГ</li>

                </ul>
                <!--
                            <div class="buy-now">

                                <a href="" class="btn btn-custom">Узнать подробнее</a>

                            </div>
                -->
            </div>

            <!-- End Pricing Table -->

        </div>


        <div class="col-md-4 col-sm-4 col-xs-12">

            <!-- Pricing Table -->

            <div class="plan animated hiding" data-animation="fadeInUp" data-delay="1000">

                <div class="plan-heading">

                    <h3>Медицина</h3>

                    <br><br>

                    <div class="hexagon">

                        <i class="fa fa-medkit"></i>

                    </div>

                </div>

                <ul>

                    <li>ПРОДВИЖЕНИЕ <strong>клиники/лекарства/услуг</strong></li>
                    <li>В <strong>ПАКЕТНОЕ ПРЕДЛОЖЕНИЕ</strong> ВХОДИТ: РАЗМЕЩЕНИЕ МЕДИЙНЫХ БАННЕРОВ, СОЗДАНИЕ СПЕЦРАЗДЕЛОВ НА САЙТАХ, ПРИВЛЕЧЕНИЕ ЦЕЛЕВОГО ТРАФИКА И Т.П.</li>


                    <li><strong>2,5 МИЛЛИОНА</strong> ПОСЕТИТЕЛЕЙ В МЕСЯЦ</li>

                    <li>БОЛЬШЕ <strong>25%</strong> ИЗ МОСКВЫ </li>

                    <li><strong>10%</strong> - САНКТ-ПЕТЕРБУРГ</li>

                </ul>
                <!--
                            <div class="buy-now">

                                <a href=""  class="btn btn-custom">Узнать подробнее</a>

                            </div>
                -->
            </div>

            <!-- End Pricing Table -->

        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <!-- Pricing Table -->

            <div class="plan animated hiding" data-animation="fadeInUp" data-delay="500">

                <div class="plan-heading">

                    <h3>ЭЗОТЕРИКА</h3>

                    <br><br>

                    <div class="hexagon">

                        <i class="fa fa-mars"></i>

                    </div>

                </div>

                <ul>


                    <li>ПРИВЛЕЧЕНИЕ ТОЛЬКО ЦЕЛЕВОГО ТРАФИКА</li>
                    <li>БОЛЕЕ 12,5 МИЛЛИОНОВ ПРОСМОТРОВ В МЕСЯЦ</li>
                    <li>69% — РОССИЯ</li>
                    <li>27% — СНГ</li>


                </ul>
                <!--
                            <div class="buy-now">

                                <a href="" class="btn btn-custom">Узнать подробнее</a>

                            </div>
                -->
            </div>

            <!-- End Pricing Table -->

        </div>


    </div>

</section>

<!-- End Pricing Section -->



<!-- Begin Contact Section-->

<section id="promote" class="section section-dark">

    <div class="container animated hiding" data-animation="fadeInRight" data-delay="300">

        <div class="title col-md-12 col-sm-12 col-xs-12">

            <h1>НАШИ <strong>ПРЕИМУЩЕСТВА</strong></h1>

            <hr>


            <br />

            <p><strong>Мы гарантируем:</strong> </p>


            <p><strong>&#10004; точный охват Вашей целевой аудитории</strong></p>

            <p><strong>&#10004; высокая активность аудитории</strong></p>

            <p><strong>&#10004; распространение информации о ваших проектах</strong></p>

            <p><strong>&#10004; рост лояльности к вашему бренду/товару/услуге</strong></p>

            <br>

            <!--     <div class="text-center">

                     <a href="" class="btn btn-custom">Узнать подробнее</a>


                     <a href="#" class="btn btn-custom btn-gray">Обзоры проведенных конкурсов</a>

                 </div>

        -->

        </div>

    </div>

</section>

<!-- End Contact Section-->





<!-- Begin Contact Section-->

<section id="contact" class="section">

    <div class="container">

        <div class="title col-xs-12">

            <h1><strong><span>[</span></strong> КОНТАКТЫ <strong><span>]</span></strong></h1>

        </div>

    </div>



    <!-- Contact Details -->

    <div class="contact-details">

        <div class="container">

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="detail">

                    <i class="fa fa-skype"></i>

                    <span>grishkovd</span>

                </div>

            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="detail">

                    <i class="fa fa-phone"></i>

                    <span>+7 383 2928455</span>

                </div>

            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="detail last">

                    <i class="fa fa-envelope"></i>

                    <span>adv@akulapera.com</span>

                </div>

            </div>

        </div>

    </div>

    <!-- End Contact Details -->



    <div class="container">

        <div class="col-sm-12">

            <!-- Contact Form -->

            <div id="contact-form">

                <div class="form-sent">

                    <div class="alert alert-success">

                        <strong>Ваше сообщение отправлено.</strong> Спасибо!

                    </div>

                </div>

                <form method="post" action="" id="contact-us"> <!-- contact.php -->

                    <div class="col-md-5 col-sm-5 col-xs-12 animated hiding" data-animation="slideInLeft">

                        <div class="form-group">

                            <input type="text" name="fullname" class="form-control input-lg" placeholder="Имя">

                        </div>

                        <div class="form-group" style="display: none">

                            <input type="text" name="name" class="form-control input-lg" placeholder="Имя">

                        </div>

                        <div class="form-group">

                            <input type="email" name="email" class="form-control input-lg" placeholder="Email">

                        </div>

                        <div class="form-group">

                            <input type="text" name="phone" class="form-control input-lg" placeholder="Телефон">

                        </div>



                    </div>

                    <div class="col-md-7 col-sm-7 col-xs-12 animated hiding" data-animation="slideInRight">

                        <div class="form-group">

                            <textarea name="message" class="form-control input-lg" placeholder="Сообщение"></textarea>

                        </div>

                    </div>

                    <input type="submit" class="btn btn-custom up animated hiding for-event-akula" value="Отправить" data-animation="fadeInUpBig">
                    <input type="hidden" name="hash" value="contact" />
                </form>

            </div>

            <!-- End Contact Form -->

        </div>

    </div>

</section>

<!-- End Contact Section-->



<!-- Footer -->

<footer>

    <div class="container">



        <!-- Copyright -->
        <p class="center grey">2013 — 2015 <span id="year"></span> &copy; AKULA-PERA. All rights reserved.</p>
        <!-- End Copyright -->

    </div>

</footer>

<!-- End Footer -->





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