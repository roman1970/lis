<?php

use app\assets\BardzillaAsset;
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;

BardzillaAsset::register($this);
//@TODO Предусмотреть переход по клику на меню на блок с контентом для мобильной версии
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <title>Бард, который перевернул ЗИЛ</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='yandex-verification' content='77c8a3e22c60e2cb' />
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
<div id="wrapper_cont" >


        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-2">
                <div id="rom"> </div>
                <div id="footer">
                    <p>    Copyright &copy;<?=date('Y')?> Б'КПЗ <br/>

                    </p>
                </div>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-6">
                <p id='play'>О! Здравствуй, Мой Дорогой Гость! Ты забрёл ко мне случайно?<br />
                    Не спеши закрыть бездверие моей пещеры <br />
                    Почитай, посмотри, послушай...<br />
                    Что? Твой указательный палец невольно тянется к виску?<br />
                    Твой грустный рот растягивается в ненормальную ухмылку? <br />
                    Ты в недоумении и никак не можешь выйти из этого состояния?  <br />
                    За все эти вопросы Тебе, Мой Дорогой Гость,<br />
                    ответит Король Анормального - Бард, который перевернул ЗИЛ! <br />
                    <br />

                </p>

            </div><!-- /.col-lg-4 -->
            <div class="col-lg-2">
                <div id="mish" >
                </div>

                <div id="footerr">
                    <p  id="site">
                        <a href="https://play.google.com/store/music/album/Бард_который_перевернул_ЗИЛ_зато_очень_недорого?id=Bqxvew7e7qbnwea7eqnjvr53ybu&hl=ru">Вы можете нам помочь купив наши альбомы за символическую цену</a>
                        </a>
                        <br/>

                    </p>
                </div>


            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->

</div>

    <div style="display: none">
        <!-- counter.1gb.ru -->
        <script language="javascript" type="text/javascript">
            cgb_js="1.0"; cgb_r=""+Math.random()+"&r="+
            escape(document.referrer)+"&pg="+
            escape(window.location.href);
            document.cookie="rqbct=1; path=/"; cgb_r+="&c="+
            (document.cookie?"Y":"N");
        </script><script language="javascript1.1" type="text/javascript">
            cgb_js="1.1";cgb_r+="&j="+
            (navigator.javaEnabled()?"Y":"N")</script>
        <script language="javascript1.2" type="text/javascript">
            cgb_js="1.2"; cgb_r+="&wh="+screen.width+
            'x'+screen.height+"&px="+
            (((navigator.appName.substring(0,3)=="Mic"))?
                screen.colorDepth:screen.pixelDepth)</script>
        <script language="javascript1.3" type="text/javascript">
            cgb_js="1.3"</script>
        <script language="javascript"
                type="text/javascript">cgb_r+="&js="+cgb_js;
            document.write("<a href='http://www.1gb.ru?cnt=92760'>"+
            "<img src='http://counter.1gb.ru/cnt.aspx?"+
            "u=92760&"+cgb_r+
            "&' border=0 width=88 height=31 "+
            "alt='1Gb.ru counter'><\/a>")</script>
        <noscript><a href='http://www.1gb.ru?cnt=92760'>
                <img src="http://counter.1gb.ru/cnt.aspx?u=92760"
                     border=0 width="88" height="31" alt="1Gb.ru counter"></a>
        </noscript>
        <!-- /counter.1gb.ru -->
    </div>

</div>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter33103768 = new Ya.Metrika({
                    id:33103768,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/33103768" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
