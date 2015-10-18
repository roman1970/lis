<?php

use app\assets\Russia2018Asset;
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;

Russia2018Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="language" content="ru" />

    <script>

        function Chempionat(id){

            $("#base").load("tec_chemp.php", {id: id});
        }

    </script>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div id="wrapper">

    <div id="head">

        <div id="logo"><span style="font-size:40px; color:white;">М</span>ИРОВОЙ<span style=" position: relative; top:22px; left: 5px; padding: 0;"></span> ФУТБОЛ ПЕРЕД ЧЕМПИОНАТОМ МИРА -2018</div>

        <div id="fam">В цифрах</div>

    </div>

    <div id="cont">
        <div id="menu">
            <ul>
                <li id="chemps"><a href="#" >Чемпионаты</a> </li>
                <li>&diams;</li>
                <li id="commands"><a href="#" >Команды </a> </li>
                <li> &diams;</li>
                <li id="match"><a href="#" >Матчи </a></li>
                <li> &diams;</li>
                <li id="player"><a href="#" >Игроки</a> </li>
                <li>&diams;</li>
                <li id="nakaz"><a href="#">Наказания</a></li>
                <li>&diams;</li>
                <li id="gols"><a href="#" >Голы</a></li>
            </ul>
        </div>

        <div id="practice">
            <p><span style="font-size:22px; color:white;">Ч</span>ЕМПИОНАТЫ МИРА</p>
            <ul>
                <li><span> &rsaquo; </span><a onclick="Chempionat(1)" style="cursor: pointer;">I Уругвай - 1930</a></li>
                <li><span> &rsaquo; </span>II Италия - 1934</li>
                <li><span> &rsaquo; </span>III Франция - 1938</li>
                <li><span> &rsaquo; </span>IV Бразилия - 1950</li>
                <li><span> &rsaquo; </span>V Швейцария - 1954</li>
                <li><span> &rsaquo; </span>VI Швеция - 1958</li>
                <li><span> &rsaquo; </span>VII Чили - 1962</li>
                <li><span> &rsaquo; </span>VIII Англия - 1966</li>
                <li><span> &rsaquo; </span>IX Мексика - 1970</li>
                <li><span> &rsaquo; </span>X ФРГ - 1974</li>
                <li><span> &rsaquo; </span>XI Аргентина - 1978</li>
                <li><span> &rsaquo; </span>XII Испания - 1982</li>
                <li><span> &rsaquo; </span>XIII Мексика - 1986</li>
                <li><span> &rsaquo; </span>XIV Италия - 1990</li>
                <li><span> &rsaquo; </span>XV США - 1994</li>
                <li><span> &rsaquo; </span>XVI Франция - 1998</li>
                <li><span> &rsaquo; </span>XVII Япония-Корея - 2002</li>
                <li><span> &rsaquo; </span>XVIII Германия - 2006</li>
                <li><span> &rsaquo; </span>XIX ЮАР - 2010</li>
                <li style="border-bottom: none;"><span> &rsaquo; </span><a onclick="Chempionat(20)" style="cursor: pointer;">XX Бразилия - 2014</a></li>
            </ul>
        </div>

        <!--       <div id="ques">
                   <p><span style="font-size:22px; color:white;">H</span>AVE A<span style="font-size: 22px; color:white;"> Q</span>UESTION</p>


                   <form action="#" method="post">

                       <input class="aer" name="name" type="text" value="name"/><br />
                       <input class="aer" name="email" type="text" value="E-mail"/><br />
                       <input class="aer"  name="phone" type="text"  value="phone"/><br />
                       <textarea class="mes"  name="massage" rows="3" cols="7" > Message</textarea><br />
                       <input class="rad" name="disclaim" type="radio" /> I have read the <a href="#"> disclaimer</a>

                       <button class="button" type="submit" >Submit &rarr;</button>



                   </form>
               </div>
-->
        <div id="tele">
            <p style="vertical-align: baseline; "><span style="font-size:22px; color:white;">R</span>EQUEST A<span style="font-size: 22px; color:white;"> C</span>ALL
            </p>

            <form action="#" method="post">
                <table>

                    <tr>
                        <td class="left">
                            <span > Name:  </span>
                        </td>
                        <td class="right"  >
                            <input class="aer" name="nam" type="text" />
                        </td>
                    </tr>

                    <tr>
                        <td class="left">
                            <span >Phone: </span>
                        </td>
                        <td class="right"  >
                            <input class="aer" name="mail" type="text" />
                        </td>
                    </tr>

                    <tr>
                        <td class="left">
                            <span >Matter: </span>
                        </td>
                        <td class="right"  >
                            <select class="aer" name='matter'>
                                <option selected="selected">Family Low</option>
                                <option value='Дзержинский'>Дзержинский</option>
                                <option value='Железнодорожный'>Железнодорожный</option>


                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="left">
                            <span >Call me: </span>
                        </td>
                        <td class="right"  >
                            <select class="aer" name='matter'>
                                <option selected="selected">Now/ASAP</option>
                                <option value='Дзержинский'>Дзержинский</option>
                                <option value='Железнодорожный'>Железнодорожный</option>


                            </select>
                        </td>


                    </tr>


                </table>
            </form>

            <button class="button" type="submit" >Call me</button>
        </div>


        <div id="testimon">
            <p><span style="font-size:22px; color:white;">T</span>ESTIMONIALS</p>





            <div id="con"><MARQUEE behavior=scroll direction=up height=120
                                   loop=-1 scrollamount=1 scrolldelay=100 >
                    Хотя назначение этого алгоритма — поиск, его
                    можно применять и для сортировки. Фактически он
                    очень напоминает метод сортировки простым включе-
                    нием, но поскольку вместо массива используется де-
                    рево, то пропадает необходимость передвигать ком-
                    поненты, находящиеся выше места включения. Сор-
                    тировку с помощью дерева можно запрограммировать
                    почти столь же эффективно, как и наилучшие из из-
                    вестных методов сортировки массивов

                </MARQUEE>


            </div>


            <button class="button" type="submit" >Veiw all</button>
        </div>

        <div id="proud">

            <p style="vertical-align: baseline; "><span style="font-size:22px; color:white;">P</span>ROUDLY<span style="font-size: 22px; color:white;"> S</span>ERVING
            </p>

            <table width="250">

                <tr>
                    <td class="left">
                        Россия
                    </td>
                    <td class="right">
                        Россия
                    </td>
                </tr>

                <tr>
                    <td class="left">
                        Корея
                    </td>
                    <td class="right"  >
                        Корея
                    </td>
                </tr>

                <tr>
                    <td class="left">
                        Япония
                    </td>
                    <td class="right"  >
                        Япония
                    </td>
                </tr>

                <tr>
                    <td class="left">
                        Северная Ирландия
                    </td>
                    <td class="right"  >
                        Северная Ирландия
                    </td>


                </tr>

                <tr>
                    <td class="left">
                        Англия
                    </td>
                    <td class="right"  >
                        Англия
                    </td>
                </tr>

                <tr>
                    <td class="left">
                        Косово
                    </td>
                    <td class="right"  >
                        Косово
                    </td>
                </tr>

                <tr>
                    <td class="left">
                        Ирландия
                    </td>
                    <td class="right"  >
                        Ирландия
                    </td>
                </tr>

                <tr>
                    <td class="left">
                        Германия
                    </td>
                    <td class="right"  >
                        Германия
                    </td>


                </tr>


                <tr>
                    <td class="left">
                        Франция
                    </td>
                    <td class="right"  >
                        Франция
                    </td>


                </tr>

            </table>

        </div>

        <div id="footer">
            <table width="1025">

                <tr>
                    <td class="left">
                        Россия
                    </td>
                    <td class="cen">
                        Россия
                    </td>
                    <td class="right">
                        Россия
                    </td>
                </tr>


            </table>
        </div>

        <!--   <div id="stat">
               <img src="img/images/statuia.jpg" />

           </div>
        -->

        <div id="base">
            Текст, кототототото
        </div>
    </div>
</div>


    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
