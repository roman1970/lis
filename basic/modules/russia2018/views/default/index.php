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
        var from = $("#w0");
        var to = $("#w1");
        var choices;
        var log = $("#log");
        var key = $("#key");


        var k = false;
        $("#statusMess").ajaxSuccess(
            function() {
                if (k == true) {
                    $("#send").hide();
                    $(this).text("Сообщение удачно отправлено!");
                }
            }
        );

        $("#reload").click(
            function () {
                location.reload();
            }
        );


        $("#send").click(
            function() {
                sendMess(limit.val(), host.val(), bet.val(), from.val(), to.val());
                $("#bets").hide();
                $("#teams_data").show();
                $('body').animate({
                    scrollTop: 460
                }, 400);


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
        
        $("#doit").click(
            function () {
                //alert(log.val());
                doPrognose(log.val(),key.val());
                $("#prognose-block").hide();
                $("#statistic").show();

            }
        );

        $("#two_teams_strict").click(
            function() {
                getMatchesStrict(hoster.val(),guester.val());
                $("#teams_data").hide();
                $("#bets").show();
                $('body').animate({
                    scrollTop: 460
                }, 400);
            }
        );

        $("#progn").click(
            function () {
                $("#log-block").show();
                $("#progn").hide();
                $("#team").hide();
                $("#match").hide();
                $("#bets").hide();
                $("#button_reload").show();

            }
        );

        $("#login").click(
            function () {
                login(log.val(),key.val());
                $("#log-block").hide();
                $("#prognose-block").show();
            }
        );

        $("#show_stat").click(
            function () {
                login(log.val(),key.val());
                $("#log-block").hide();
                $("#show_stat").hide();
                $("#prognose-block").show();
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


        $("#country").click(
            function() {
                $("#planet").animate({top: "+=600"}, 10000);
            });
        $("#host").click(
            function() {
                $("#planet").animate({top: "-=600"}, 10000);
            });
        $("#hoster").click(
            function() {
                $("#planet").animate({left: "+=700", top: "+=600"}, 10000);

            });
        $("#guester").click(
            function() {
                $("#planet").animate({left: "-=700", top: "-=600"}, 10000);
            });

        $('#hoster').autoComplete({
            minChars: 3,
            source: function(term, suggest){
                term = term.toLowerCase();
                $.getJSON( "russia2018/default/teams/", function( data ) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i=0;i<choices.length;i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json" );

            }
        });

        $('#guester').autoComplete({
            minChars: 3,
            source: function(term, suggest){
                term = term.toLowerCase();
                $.getJSON( "russia2018/default/teams/", function( data ) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i=0;i<choices.length;i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json" );

            }
        });

        $('#host').autoComplete({
            minChars: 3,
            source: function(term, suggest){
                term = term.toLowerCase();
                $.getJSON( "russia2018/default/teams/", function( data ) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i=0;i<choices.length;i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json" );

            }
        });


    });



    function sendMess(limit, host, bet, from, to) {
       

        if (host === "") {
            host = "UIU";
        }


        $.ajax({
            type: "GET",
            url: "russia2018/default/strateg/",
            data: "host="+host+"&limit="+limit+"&bet="+bet+"&from="+from+"&toto="+to,
            success: function(html){
                $("#base").html(html);
            }

        });

        $.ajax({
            type: "GET",
            url: "russia2018/default/strategu/",
            data: "host="+host+"&limit="+limit+"&bet="+bet+"&from="+from+"&toto="+to,
            success: function(html){
                $("#teams_data").html(html);
            }

        });


    }

    function login(login,key) {
        if(login === "") {
            alert("Введите свой логин");
            return false;
        }
        if(key === "") {
            alert("КЛЮЧ!!!???");
            return false;
        }

        $.ajax({
            type: "GET",
            url: "russia2018/default/login/",
            data: "login="+login+"&pseudo="+key,
            success: function(html){
                $("#base").html(html);
            }

        });
    }


    function getMatches(hoster, guester){
        if(hoster === "" && guester === "") {
            alert("Введите хотя бы одну команду");
            return false;
        }
        if(guester === "") {
           guester = "null"
        }
        if(hoster === ""){
            hoster = "null"
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

    function getMatchesStrict(hoster, guester){
        if(hoster === "" && guester === "") {
            alert("Введите хотя бы одну команду");
            return false;
        }
        if(guester === "") {
            guester = "null"
        }
        if(hoster === ""){
            hoster = "null"
        }
        $.ajax({
            type: "GET",
            url: "russia2018/default/matchstrict/",
            data: "hoster="+hoster+"&guester="+guester,
            success: function(html){
                $("#base").html(html);
            }

        });

        $.ajax({
            type: "GET",
            url: "russia2018/default/matchstrictu/",
            data: "hoster="+hoster+"&guester="+guester,
            success: function(html){
                $("#bets").html(html);
            }

        });

    }
    
    function doPrognose(login, key) {
        $.ajax({
            type: "GET",
            url: "russia2018/default/prognose/",
            data: "login="+login+"&pseudo="+key,
            success: function(html){
                $("#base").html(html);

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
<style>
    .jumbotron {
        background-color: rgb(7, 63, 50);
        box-shadow: inset rgba(250,250,250,250) -8px 8px 8px, inset rgba(255,255,255,255) 8px 3px 8px, rgba(0,0,0,0) 3px 3px 8px -3px;
        padding: 20px;

    }
    .jumbotron h3{
        color: white;
    }
    .container {
        max-width: 720px;
        padding-top: 20px;
    }
    .hasDatepicker{
        display: block;
        width: 50%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: rgb(85, 85, 85);
        background-color: rgb(255, 255, 255);
        background-image: none;
        border: 1px solid rgb(204, 204, 204);
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }

    .table > tbody > tr > td {
        /*background-color: rgb(18, 82, 50);*/
        color: white;
        text-align: center;
    }
    .table {
        border-radius: 5px;
    }

    #log-block{
        display: none;
    }

    p{
        color: white;
    }

    .fa-2x{
        font-size: 1em;
    }

    @media (min-width: 1200px)
        .container {
            max-width: 720px;
        }

</style>


    <div class="container">
        <canvas id="planet" width="285" height="285" >
        </canvas>


        <div class="jumbotron" >

            <form class="form-inline" role="form" id="team">
                <h3>Матчи футбольной команды</h3>
                <?php /*
                <div class="form-group">

                    <input type='hidden' class="aer" id="country_bet" size="30"/>
                    <p><input type="text" class="form-control" id="country"  placeholder="Название страны или региона">
                        <button type="button" class="btn btn-success" id="choose_country">Показать</button>
                    </p>
                    <div id="outputbox">
                        <p id="outputcontent"></p>
                    </div>
                </div>

                */ ?>
                <div class="form-group">


                    <input type='hidden' class="aer" id="bet" size="30"/>
                    <p>
                        <input type="text" class="form-control" id="host"  placeholder="Название команды">
                         <?= \yii\jui\DatePicker::widget([
                            'name'  => 'from_date',
                            'value'  => '2016-07-01',
                            'dateFormat' => 'dd.MM.yyyy',
                            'options' => ['title' => 'Начало периода']
                            //'inline' => true,
                            //'containerOptions' => ['width' => '100']
                        ]);
                        ?>
                        <?= \yii\jui\DatePicker::widget([
                            'name'  => 'to_date',
                            'value'  => date('Y-m-d', time()),
                            'dateFormat' => 'dd.MM.yyyy',
                            'options' => ['title' => 'Конец периода']
                            //'inline' => true,
                            //'containerOptions' => ['width' => '100']
                        ]);
                        ?>
                        <button type="button" class="btn btn-success" id="send" >Показать</button>
                    </p>
                </div>
            </form>

            <form class="form-inline" role="form" id="match">
                <div class="form-group">
                    <h3>Статистика футбольных матчей</h3>
                    <p>
                        <input type="text" class="form-control" id="hoster"  placeholder="Хозяин">
                        <input type="text" class="form-control" id="guester"  placeholder="Гость">

                       <?php /*<button type="button" class="btn btn-success" id="two_teams" >Поиск</button></p> */ ?>
                        <button type="button" class="btn btn-success" id="two_teams_strict" >Поиск</button>
                        </p>
                </div>
            </form>

            <p><?= (isset($user)) ? "Привет, ".var_dump($user) : ""?></p>
            
            <button type="button" class="btn btn-success" id="progn" >Сделай прогноз</button>

            <div id="log-block">
                <h3>Заполните форму</h3>
                <input type="text" class="form-control" id="log"  placeholder="login">
                <input type="text" class="form-control" id="key"  placeholder="Введи свой ключ">
                <button type="button" class="btn btn-success" id="login" >Войти прогнозистом</button>
                <button type="button" class="btn btn-success" id="registration" >Зарегистрироваться</button>

                <p id="response"></p>
            </div>
            
            <div id="prognose-block" style="display: none">
                <h3>Сделай прогноз</h3>

                <button type="button" class="btn btn-success" id="doit" >Прогнозировать</button>
            </div>

            <div id="statistic" style="display: none">
                <button type="button" class="btn btn-success" id="show_stat" >Статистика</button>
            </div>

            <div id="button_reload" style="display: none">
                <button type="button" class="btn btn-success" id="reload">Выйти из прогнозов</button>
            </div>


        </div>

        <div class="view" id="teams_data" style="display: none">
        </div>
        <div class="view" id="bets" style="display: none">
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
        <div class="row marketing" id="base">

                <?php $r=0; foreach ($matchs as $match) : ?>
                    <div class="view">


                        <p id="match_date">
                            <?php echo $match->date; ?>
                        </p>


                        <p id="match_tour" onclick="getTour(<?=$r?>)" class="tour<?=$r?>" title="Все матчи <?=$match->tournament?>">
                            <?php echo $match->tournament; ?>
                        </p>


                        <table id="mems_match" cellpadding="0" >
                            <tr>
                                <td class="left" title="Состав: <?=$match->getSost_h()?>" style="cursor: pointer"><?php echo \app\components\Helper::cutAfterBracket($match->host); ?></td>
                                <td class="center"><?php echo $match->gett; ?>:<?php echo $match->lett; ?> </td>
                                <td class="right" title="Состав: <?=$match->getSost_g()?>" style="cursor: pointer"><?php echo \app\components\Helper::cutAfterBracket($match->guest); ?></td>

                            </tr>
                        </table>

                        <?php if($match->prim) : ?>
                            <p class="prim"><?=$match->prim ?></p>
                        <?php endif; ?>
                        <?php if($match->goul_h || $match->goul_g) : ?>
                        <table id="mems_goal" cellpadding="0" >
                            <tr>
                                <td class="left"><?php echo $match->goalH_str(); ?>

                                    <?php echo $match->redCardH_str(); ?>

                                    <?php echo $match->penMissH_str(); ?>
                                </td>
                                <td class="center"><span class="fa fa-futbol-o fa-2x"></span></td>
                                <td class="right"><?php echo $match->goalG_str(); ?>

                                    <?php echo $match->redCardG_str(); ?>

                                    <?php echo $match->penMissG_str(); ?>
                                </td>

                            </tr>
                        </table>
                        <?php endif; ?>
                        <?php if($match->substit_h || $match->substit_g) : ?>
                        <table class="substit" cellpadding="0" >
                            <tr>
                                <td class="left"><?php $match->substitH_str(); ?></td>
                                <td class="center"><span class="glyphicon glyphicon-resize-horizontal"></span></td>
                                <td class="right"><?php $match->substitG_str(); ?></td>

                            </tr>
                        </table>
                        <?php endif; ?>

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

                        <?php if($match->bet_h != 0 && $match->bet_n != 0 && $match->bet_g != 0) : ?>


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

                        <?php endif; ?>

                        <p class="info">
                            <?php $match->getInfo(); ?>
                        </p>


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

