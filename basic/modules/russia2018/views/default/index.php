<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
?>
<script>


    $(document).ready(function() {
        var host = $("#host");
        var guest = $("#guest");
        var limit = $("#limit");
        var bet = $("#bet");
        var country = $("#country");
        var country_limit = $("#country_limit");
        var country_bet = $("#country_bet");
        var hoster = $("#hoster");
        var guester = $("#guester");


        var k = false;
        $("#statusMess").ajaxSuccess(
            function() {
                if (k == true) {
                    $("#send").hide();
                    $(this).text("Сообщение удачно отправлено!");
                }
            }
        );
        $("#send").click(
            function() {

                sendMess(limit.val(), host.val(), bet.val());
            });

        $("#choose_country").click(
            function() {
                getCont(country.val(),country_limit.val(),country_bet.val());
            }
        );

        $("#two_teams").click(
            function() {
                getMatches(hoster.val(),guester.val());
            }
        );


        $("#statusMess").ajaxError(
            function() {

                $(this).text("Сообщение не отправлено!");
                $("#send").show();
            }
        );
        $("#send").ajaxStart(
            function() {
                if (k === true) {
                    $(this).hide();
                    k = false;
                }
            });




    });

    function sendMess(limit, host,  bet) {


        //Валидация
        if (host === "" && guest === "") {
            alert("Введите хотя бы одну команду");
            return false;
        }

        if (host === "") {
            host = "UIU";
        }


        $.ajax({
            type: "GET",
            url: "russia2018/default/strateg/",
            data: "host="+host+"&limit="+limit+"&bet="+bet,
            success: function(html){
                $("#base").html(html);
            }

        });

        $.ajax({
            type: "GET",
            url: "russia2018/default/strategu/",
            data: "host="+host+"&limit="+limit+"&bet="+bet,
            success: function(html){
                $("#bets").html(html);
            }

        });


    }





    function getMatches(hoster, guester){
        if(hoster === "") {
            alert("Введите хозяина");
            return false;
        }
        if(guester === "") {
            alert("Введите гостя");
            return false;
        }
        $.ajax({
            type: "GET",
            url: "russia2018/default/match/",
            data: "hoster="+hoster+"&guester="+guester,
            success: function(html){
                $("#base").html(html);
            }

        });

        $.ajax({
            type: "GET",
            url: "russia2018/default/matchu/",
            data: "hoster="+hoster+"&guester="+guester,
            success: function(html){
                $("#bets").html(html);
            }

        });

    }



    function getCont(country,country_limit,country_bet){
        if (country === "") {
            alert("Введите страну");
            return false;
        }


        $.ajax({
            type: "GET",
            url: "russia2018/default/country/",
            data: "country="+country+"&country_limit="+country_limit+"&country_bet="+country_bet,
            success: function(html){
                $("#base").html(html);
            }

        });

        $.ajax({
            type: "GET",
            url: "russia2018/default/countryu/",
            data: "country="+country+"&country_limit="+country_limit+"&country_bet="+country_bet,
            success: function(html){
                $("#bets").html(html);
            }

        });

    }

    function getTour(i) {
        var tournament = $(".tour"+i).html();
        $.ajax({
            type: "GET",
            url: "russia2018/default/tournament/",
            data: "tournament="+tournament,
            success: function(html){
                $("#base").html(html);
            }

        });
        $.ajax({
            type: "GET",
            url: "russia2018/default/tournamentu/",
            data: "tournament="+tournament,
            success: function(html){
                $("#bets").html(html);
            }

        });
    }


</script>


<div id="wrapper">


    <div id="head" >


            <div id="fam"><h3>Футбольные матчи мира 2014-2018</h3>

                    <span>Страна</span><input type='text' class="aer" id="country" size="35" placeholder="Первые буквы страны и кол-во последних матчей>"/>
                    <input type='text' class="aer" id="country_limit" size="1" placeholder="10"/>
                    <input type='hidden' class="aer" id="country_bet" size="30"/>
                    <button class="button glyphicon glyphicon-search" id="choose_country" ></button><br>


                    <span>Команда</span><input type='text' class="aer" id="host" size="35" placeholder="Команда и кол-во последних матчей>"/>
                    <input type='text' class="aer" id="limit" size="1" placeholder="10"/>
                    <input type='hidden' class="aer" id="bet" size="30"/>
                    <button class="button glyphicon glyphicon-search" id="send" ></button>

                    <p>Матч</p>

                    <input type='text' class="aer" id="hoster"  size="20"/> - <input type='text' class="aer" id="guester"  size="20"/>
                    <button class="button glyphicon glyphicon-search" id="two_teams"  ></button>
                <div id="bets">
                    <p>Если поставить на один исход во всех этих матчах</p>
                    <table id="bet" cellpadding="0" >
                        <tr>
                            <td class="left_bet">На хозяев</td>
                            <td class="center_bet">На ничью</td>
                            <td class="right_bet">На гостей</td>

                        </tr>
                    </table>
                    <p>Можно было бы выиграть (- проиграть) *ставка</p>
                    <table id="bet" cellpadding="0" >
                        <tr>
                            <td class="left_bet_cyph"><?=$bet_h ?></td>
                            <td class="center_bet_cyph"><?=$bet_n ?></td>
                            <td class="right_bet_cyph"><?=$bet_g ?></td>
                        </tr>
                    </table>
                </div>

            </div>


    </div>

    <?php /*

    <div id="cont" class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">

                <div id="practice" class="tele">
                    <p style="vertical-align: baseline; "><span style="font-size:22px; color:white;">С</span>ТРАНА</p>


                    <form action="#" method="post">

                            <span>Страна:</span><br /> <input type='text' class="aer" id="country" size="30"/><br />
                            <span>Количество последних матчей:</span> <br /><input type='text' class="aer" id="country_limit" size="30"/></p><br />
                            <span>Ставка:</span><br /> <input type='text' class="aer" id="country_bet" size="30"/><br />
                        <span style="font-size: 10px;">руб</span><br />

                    </form>

                    <button class="button" id="choose_country" type="submit" >Применить</button>


                   <br />


                </div>

                <div class="tele">
                    <p style="vertical-align: baseline; "><span style="font-size:22px; color:white;">К</span>ОМАНДА</p>

                    <form action="#" method="post">

                        <span>Команда:</span><br /><input type='text' class="aer" id="host"  size="30"/><br />

                        <span>Количество последних матчей</span>: <br /><input type='text' class="aer" id="limit" size="30"/></p><br />
                        <span>Ставка:</span><br /> <input type='text' class="aer" id="bet" size="30"/><br>
                        <span style="font-size: 10px;">руб</span><br />


                    </form>

                    <button class="button" id="send" type="submit" >Применить</button>
                </div>

                    <div class="tele">
                        <p style="vertical-align: baseline; "><span style="font-size:22px; color:white;">К</span>ОМАНДА</p>

                        <form action="#" method="post">

                            <span>Команда:</span><br /><input type='text' class="aer" id="host"  size="30"/><br />

                            <span>Количество последних матчей</span>: <br /><input type='text' class="aer" id="limit" size="30"/></p><br />
                            <span>Ставка:</span><br /> <input type='text' class="aer" id="bet" size="30"/><br>
                            <span style="font-size: 10px;">руб</span><br />


                        </form>

                        <button class="button" id="send" type="submit" >Применить</button>
                    </div>




                <div id="proud">

                        <p style="vertical-align: baseline; "><span style="font-size:22px; color:white;">М</span>АТЧ</p>

                        <form action="#" method="post">

                            <span>Команда хозяин:</span><br /><input type='text' class="aer" id="hoster"  size="30"/><br />
                            <span>Команда гость:</span><br /><input type='text' class="aer" id="guester"  size="30"/><br />

                        </form>

                        <button class="button" id="two_teams" type="submit" >Найти</button>

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

            </div>
        </div>

 */ ?>
        <div id="base">

                <?php $r=0; foreach ($matchs as $match) : ?>
                    <div class="view">


                        <p id="match_date">
                            <?php echo $match->date; ?>
                        </p>


                        <p id="match_tour" onclick="getTour(<?=$r?>)" class="tour<?=$r?>">
                            <?php echo $match->tournament; ?>
                        </p>


                        <table id="mems_match" cellpadding="0" >
                            <tr>
                                <td class="left"><?php echo $match->host; ?></td>
                                <td class="center"><?php echo $match->gett; ?>:<?php echo $match->lett; ?> </td>
                                <td class="right"><?php echo $match->guest; ?></td>

                            </tr>
                        </table>

                        <?php if($match->prim) : ?>
                            <p class="prim"><?=$match->prim ?></p>
                        <?php endif; ?>
                        <table id="mems_goal" cellpadding="0" >
                            <tr>
                                <td class="left"><?php echo $match->goalH_str(); ?><?php echo $match->redCardH_str(); ?><?php echo $match->penMissH_str(); ?></td>
                                <td class="center"></td>
                                <td class="right"><?php echo $match->goalG_str(); ?><?php echo $match->redCardG_str(); ?><?php echo $match->penMissG_str(); ?></td>

                            </tr>
                        </table>

                        <?php if($match->getCoachH() != '' || $match->getCoachG() != '') : ?>

                            <table id="coach" cellpadding="0" >
                                <tr>
                                    <td class="left"><?php echo $match->getCoachH(); ?></td>
                                    <td class="center">тренер</td>
                                    <td class="right"><?php echo $match->getCoachG(); ?></td>

                                </tr>
                            </table>

                        <?php endif; ?>

                        <?php if($match->getKeeperH() != '' || $match->getKeeperG() != '') : ?>

                            <table id="coach" cellpadding="0" >
                                <tr>
                                    <td class="left"><?php echo $match->getKeeperH(); ?></td>
                                    <td class="center">вратарь</td>
                                    <td class="right"><?php echo $match->getKeeperG(); ?></td>

                                </tr>
                            </table>

                        <?php endif; ?>

                        <?php if($match->ud_h != 0 && $match->ud_g != 0) : ?>

                        <table id="ud" cellpadding="0" >
                            <tr>
                                <td class="left"><?php echo $match->ud_h; ?></td>
                                <td class="center">удары</td>
                                <td class="right"><?php echo $match->ud_g; ?></td>

                            </tr>
                        </table>

                        <?php endif; ?>

                        <?php if($match->falls_h != 0 && $match->falls_g != 0) : ?>

                            <table id="falls" cellpadding="0" >
                                <tr>
                                    <td class="left"><?php echo $match->yellCardCount_h(); ?><?php echo $match->falls_h; ?></td>
                                    <td class="center">фолы</td>
                                    <td class="right"><?php echo $match->falls_g; ?><?php echo $match->yellCardCount_g(); ?></td>

                                </tr>
                            </table>

                        <?php endif; ?>


                        <table id="stavki" cellpadding="0" >
                            <tr>
                                <td class="left"></td>
                                <td class="center"> ставки </td>
                                <td class="right"></td>

                            </tr>
                        </table>
                        <table id="stavki" cellpadding="0" >
                            <tr>
                                <td class="left"><?php echo $match->bet_h; ?></td>
                                <td class="center"><?php echo $match->bet_n; ?> </td>
                                <td class="right"><?php echo $match->bet_g; ?></td>

                            </tr>
                        </table>


                    </div>

                <?php $r++; endforeach; ?>


        </div>
        <?php /*
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3">
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

                </div>
            </div>
        </div>
        */ ?>

</div>



