<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\LandberryAsset;
use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;

LandberryAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Интернет-решения</title>
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
    <style>
        .has-error .help-block, .control-label {
            color: #f7ffe4;
        }
    </style>

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
                            <h1><span>ЛЮБЫЕ ИНТЕРНЕТ-РЕШЕНИЯ: </span></h1>
                        </li>
                        <li>
                            <h1><span>САЙТЫ </span></h1>
                        </li>
                        <li>
                            <h1><span>ИНТЕРНЕТ-МАГАЗИНЫ </span></h1>
                        </li>
                        <li>
                            <h1><span>КОРПОРАТИВНЫЕ ПРИЛОЖЕНИЯ </span></h1>
                        </li>
                        <li>
                            <h1><span>ЛЭНДИНГИ </span></h1>
                        </li>
                        <li>
                            <h1><span>ПАРСЕРЫ </span></h1>
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

           <?php /* <a class="navbar-brand" href="#home" id="logo"><img src="images/logo1.png" width="133" alt="WP Media"></a> */ ?>

        </div>

        <div class="collapse navbar-collapse" id="navigation">

            <ul id="nav" class="nav navbar-nav navbar-right">
                <?php echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                //['label' => 'Контакт', 'url' => ['/site/contact']],
                Yii::$app->user->isGuest ?
                ['label' => 'Войти', 'url' => ['/user/security/login']] :
                ['label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
                'url' => ['/user/security/logout'],
                'linkOptions' => ['data-method' => 'post']],
                ],
                ]);
                ?>

                <li class=""><a href="#about">О СЕБЕ</a></li>
                <li><a href="#works">РАБОТЫ</a></li>
                <li><a href="#numbers">ЦЕНЫ</a></li>
                <li><a href="#services">ЗАКАЗ</a></li>
                <li><a href="#advertisers">КОМПАНИЯМ</a></li>
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


        <!-- About Text -->

        <div class="promo-line">

            <?php /*

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
 */ ?>

            <div class="col-md-8 col-sm-10 col-xs-12">

                <div class="row">

                    <div class="promo animated hiding" data-animation="fadeInRight">

                        <div class="col-md-10 col-sm-11 promo-icon-box">

                            <div class="promo-icon">

                                <i class="fa fa-comment"></i>

                            </div>

                        </div>

                        <div class="col-md-10 col-sm-11" >
                            <div id="slidebox">

                                <img src="images/roma_zek.png" alt="roma">


                            </div>

                            <h4>Всем привет!<br> Меня зовут Роман</h4>


                            <p id="hi">

                                Хочу предложить Вам свои услуги в веб-разработке и реализации любых идей в этой сфере.<br>
                                Как правило использую стэк HTML5-CSS(bootstrap)-JS(Jquery)-PHP(Yii2.0)-MySQL<br>
                                Ниже приведены примеры работ, собранные в системе тестирования решений, с помощью которой<br>
                                я и осуществляю работу с клиентами.<br>
                            </p>

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

            <h1><strong>МОИ РАБОТЫ</strong></h1>

            <hr>

        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/soccer.jpg" alt="">

                    <a href="http://soccer.qplis.ru" target="_blank" class="team-overlay">

                        <span class="top">Любителям футбольной статистики</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>SOCCER.QPLIS.RU</h3>
                    <p>Статистика любого футбольного матча</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/bard.jpg" alt="">

                    <a href="http://bardzilla.qplis.ru" target="_blank" class="team-overlay">

                        <span class="top">Есть творческие талантливые люди</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>BARDZILLA.QPLIS.RU</h3>

                    <p>Любителям оригинальной авторской песни</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/oceny_site.jpg" alt="">

                    <a href="http://berries.qplis.ru" target="_blank" class="team-overlay">

                        <span class="top">Дневник для оценки своих действий</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>BERRIES.QPLIS.RU</h3>

                    <p>Мой сын использует эту систему для поддержания себя в форме</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">

            <div class="team animated hiding" data-animation="fadeInUp" data-delay="0">

                <div class="team-photo">

                    <img src="images/wealth.jpg" alt="">

                    <a href="http://oppositions.qplis.ru" target="_blank" class="team-overlay">

                        <span class="top">Сайт-листинг с интересными фактами</span>

                        <span class="bottom">Перейти на сайт</span>

                    </a>

                </div>

                <div class="team-inner">

                    <h3>OPPOSITIONS.QPLIS.RU</h3>

                    <p>Великие противостояния</p>

                </div>

            </div>

        </div>

</div>

</section>

<!-- Numbers Section -->

<section id="numbers" class="parallax">

    <div class="parallax-overlay">

        <div class="container">

            <h3 class="center up"><span>ЦЕНЫ И СТАВКИ</span></h3>

            <div class="col-md-3 col-sm-3 col-xs-12">

                <div class="counter animated hiding rbc" data-animation="fadeInDown" data-delay="0">

                    <div class="value-box"><span class="value" data-from="0" data-to="3">3</span> 000 </div>
                    <p>руб/страница</p>
                    <small>АДАПТИВНАЯ ВЕРСТКА</small>

                </div>

            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">

                <div class="counter animated hiding rbc" data-animation="fadeInDown" data-delay="500">

                    <div class="value-box"><span class="value" data-from="0" data-to="5">6</span> 000</div>
                    <p>руб</p>
                    <small>САЙТ-ВИЗИТКА ИЛИ ЛЭНДИНГ</small>

                </div>

            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">

                <div class="counter animated hiding rbc" data-animation="fadeInDown" data-delay="1000">

                    <div class="value-box"><span class="value" data-from="0" data-to="15">15</span> 000</div>
                    <p>руб</p>
                    <small>САЙТ-КОНТЕНТНИК</small>

                </div>

            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">

                <div class="counter animated hiding rbc" data-animation="fadeInDown" data-delay="2000">

                    <div class="value-box"><span class="value" data-from="0" data-to="25">25</span> 000</div>
                    <p>руб</p>
                    <small>ИНТЕРНЕТ-МАГАЗИН</small>

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

            <h1>Вам не придётся сразу платить деньги</h1>

            <hr>

            <p> "ПРЕДОПЛАТА" в размере 20% осуществляется после того, как 40% работы уже сделано и ВЫ ВИДИТЕ РЕЗУЛЬТАТ</p>

            <br>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12 service-box">

            <div class="service animated hiding" data-animation="fadeInUp" data-delay="0">

                        <span class="fa-stack fa-4x">

                            <i class="fa fa-circle fa-2x fa-stack-2x"></i>

                            <i class="fa fa-star fa-stack-1x service-icon"></i>

                        </span>


                <h3>ШАГ 1</h3>

                <p>Свяжитесь со мной любым доступным для Вас способом (смотри <a href="#contact">КОНТАКТЫ</a>)</p>

            </div>

        </div>



        <div class="col-md-3 col-sm-6 col-xs-12 service-box">

            <div class="service animated hiding" data-animation="fadeInUp" data-delay="300">

                        <span class="fa-stack fa-4x">

                            <i class="fa fa-circle fa-2x fa-stack-2x"></i>

                            <i class="fa fa-star fa-stack-1x service-icon"></i>

                        </span>

                <h3>ШАГ 2</h3>

                <p>Если у Вас нет Технического Задания - не беда!
                    Совместными усилиями мы оформим его и утвердим сроки выполнения,
                 договорившись, на каком этапе следует внести предоплату.</p>

            </div>

        </div>




        <div class="col-md-3 col-sm-6 col-xs-12 service-box">

            <div class="service animated hiding" data-animation="fadeInUp"
                 data-delay="600">

                         <span class="fa-stack fa-4x">

                            <i class="fa fa-circle fa-2x fa-stack-2x"></i>

                            <i class="fa fa-star fa-stack-1x service-icon"></i>

                        </span>


                <h3>ШАГ 3</h3>

                <p>Вы получаете ссылку на тестовый домен и следите за выполнением работы.
                    Если Вам что-то не нравится, дорабатываем и переделываем...</p>

            </div>

        </div>


        <div class="col-md-3 col-sm-6 col-xs-12 service-box">

            <div class="service animated hiding" data-animation="fadeInUp" data-delay="900">

                       <span class="fa-stack fa-4x">

                            <i class="fa fa-circle fa-2x fa-stack-2x"></i>

                            <i class="fa fa-star fa-stack-1x service-icon"></i>

                        </span>


                <h3>ШАГ 4</h3>

                <p>Оплата за выполненную работу производится после выполнения всех пунктов ТЗ
                    и публикации проекта на домене заказчика.</p>

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

            <h1>КОМПАНИЯМ</h1>

            <hr>

            <h2> Предлагаю свои услуги web-программиста компаниям,
                которым требуется поддержка или разработка сайтов и внутренних систем и сервисов.
                Знатокам предлагаю ознакомиться с примерами кода из Системы Тестированния Решений,
                разработанной на Yii2.0.


        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">

            <!-- Pricing Table -->

            <div class="plan animated hiding selected" data-animation="fadeInUp" data-delay="0">

                <div class="plan-heading">

                    <h3>ГЕО-ПОГОДНЫЙ ПАРСЕР ДЛЯ РАЗНЫХ API</h3>

                    <br><br>

                    <div class="hexagon">

                        <a href="https://github.com/roman1970/lis/blob/master/basic/commands/WeatherController.php">
                            <i class="fa fa-umbrella"></i>
                        </a>

                    </div>

                </div>

                <ul>


                    <li><a href="https://github.com/roman1970/lis/blob/master/basic/commands/WeatherController.php">ССЫЛКА НА GITHUB</a></li>


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


                    <h3>ВЬЮХА САЙТА ФУТБОЛЬНОЙ СТАТИСТИКИ</h3>

                    <br><br>

                    <div class="hexagon">

                        <a href="https://github.com/roman1970/lis/blob/master/basic/modules/russia2018/views/default/index.php">
                            <i class="fa fa-futbol-o"></i>
                        </a>

                    </div>

                </div>

                <ul>

                    <li><a href="https://github.com/roman1970/lis/blob/master/basic/modules/russia2018/views/default/index.php">ССЫЛКА НА GITHUB</a></li>

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

                    <h3>КАСТОМНЫЙ ПАГИНАТОР ДЛЯ ЛИСТИНГА</h3>

                    <br><br>

                    <div class="hexagon">

                        <a href="https://github.com/roman1970/lis/blob/master/basic/components/KnoledgesPagination.php">
                            <i class="fa fa-book"></i>
                        </a>

                    </div>

                </div>

                <ul>

                    <li><a href="https://github.com/roman1970/lis/blob/master/basic/components/KnoledgesPagination.php">ССЫЛКА НА GITHUB</a></li>


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

            <h1>В ЧЁМ ЖЕ ПРЕИМУЩЕСТВА?</strong></h1>

            <hr>


            <br />

            <p><strong>&#10004; Недорого, но качественно</strong></p>

            <p><strong>&#10004; Бесплатная поддержка</strong></p>

            <p><strong>&#10004; Утром - стулья, вечером - деньги</strong></p>


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

            <h1 style="color: rgb(98, 116, 206); font-weight: 800;">КОНТАКТЫ</h1>

        </div>

    </div>


    <!-- Contact Details -->

    <div class="contact-details">

        <div class="container">

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="detail">

                    <i class="fa fa-skype"></i>

                    <span>roman.4ernyshev</span>

                </div>

            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="detail">

                    <i class="fa fa-phone"></i>

                    <span>+7 913 924-73-88</span>

                </div>

            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="detail last">

                    <i class="fa fa-envelope"></i>

                    <span>r0man4ernyshev@gmail.com</span>

                </div>

            </div>

        </div>

    </div>

    <!-- End Contact Details -->

    <?= $content ?>



</section>


<!-- Footer -->

<footer>

    <div class="container">



        <!-- Copyright -->
        <p class="center grey">&copy; qpLIS <?= date('Y') ?></p>
        <!-- End Copyright -->

    </div>

</footer>

<!-- End Footer -->


<?php $this->endBody() ?>
<?php /*
<script>

    $('.letter').on('click', function(){

                $(".form-sent").show();
            });



</script>

 */ ?>
</body>
</html>

<?php $this->endPage() ?>