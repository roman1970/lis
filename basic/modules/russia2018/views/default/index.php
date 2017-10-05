<?php
$remain_time = (mktime(13,0,0,6,14,2018)-time());
$days = round(($remain_time)/(60*60*24));


function affOfDayByNumber($days){
    $rest_1 = (int)substr($days, -1);
    $rest_2 = (int)substr($days, -2);
    if($rest_1 == 0 || ($rest_1 > 4 && $rest_1 <=9) || ($rest_2 >=10 && $rest_2 <= 20)){
        return 'дней';
    }
    elseif ($rest_1 == 1 ) return 'день';
    else return 'дня';
}

?>

<style>
    * {margin: 0; padding: 0;} /* обнуляем отступы - делаем контент по центру страницы */
    body{

        background: rgb(4, 26, 33);

    }

    ::-webkit-scrollbar{
        width:3px;
    }

    #blinkingText1{
        /* position: absolute;
         left: 47%;
         top: 100px;*/
        font-size: 15px;
    }


    #wrapper{
        background: #002211;
        margin: 0 auto;
        width: 900px;
        height: 1700px;
    }

    #head {
        background: url(../images/tablo.png) 0 0 no-Fepeat;
        /* background-repeat: no-repeat;*/
        /* position: relative;*/
        height: 600px;
        width: 900px;
    }

    #top{
        height: 30px;
        /*background:url(img/images/top_01.jpg) no-repeat;*/
    }


    #logo {
        position: absolute;
        font-family: Times New Roman;
        font-size: 30px;
        text-shadow: black 0px 2px 0px;
        color: white;
        left: 320px;
        top: 0px;
        letter-spacing: 2px;
    }

    #logo span {
        color: #e0bd69;
    }

    #fam {
        /*position: absolute;*/
        font-family: Arial;
        font-size: 18px;
        text-align: center;
        text-shadow: black 0px 1px 0px;
        color: #e0bd69;
        /* left: 276px;
         top: 62px;*/
        letter-spacing: 5px;
        padding-top: 80px;
    }

    #fam p {
        padding-top: 15px;
        margin: 0;
    }

    #fam span{
        font-size: 10px;
    }

    #fam form{
        vertical-align: baseline;
    }

    .view {
        width: 97%;
        max-width:900px;
        margin: 1em auto;
        padding: 1em;
        /*border-radius: 10px;*/
        /*background: rgb(16, 56, 10) radial-gradient(circle at 0 0, rgba(8, 21, 11, 0.65), rgba(6, 47, 7, 0.35));*/
        box-shadow:
            inset rgba(250,250,250,.9) -8px 8px 8px,
            inset rgba(255,255,255,.9) 8px 3px 8px,
            rgba(0,0,0,.8) 3px 3px 8px -3px;
        background:
            repeating-linear-gradient(
                transparent,transparent 21px, rgb(100,100,100) 22px
            ),
            repeating-linear-gradient(
                90deg,
                transparent,transparent 21px, rgb(100,100,100) 22px
            );
    }

    #tel{
        position: relative;
        font-family: Arial;
        font-size: 18px;


        left: 970px;
        top:18px;
    }

    #online {
        background: #07b6ef;
        position: absolute;
        font-family: Arial;
        font-size: 10px;
        height: 19px;
        width: 114px;
        left: 1042px;
        top: 6px;
        border-radius:10px;
        color: white;
        text-shadow: #048bcb 2px 2px 1px;
        /*vertical-align: bottom; вертикальное выравнивание не понадобилось - центр задали paddingом в #online p*/



    }

    #online p{
        padding-top: 2px;
        text-align: center;

    }

    #ptic{
        position: absolute;
        left: 1035px;
        top: 4px;
    }

    #flag{
        position: absolute;
        left: 1187px;
        top: 8px;
        color: white;
        font-size: 8px;
        font-family: Arial;

    }

    #stick{
        position: absolute;
        left: 1170px;
        top: 4px;
        color: #07b6ef;
    }


    #strel {
        position: absolute;
        left: 1258px;
        top: 10px;
    }

    #lang p{
        position: absolute;
        left: 1210px;
        color: white;
        font-size: 12px;
        font-family: Arial;
        top: 7px;
    }

    #cont {

        position: relative;

        height: 1128px;
        width: 1499px;
    }

    #menu {
        /*background:url(img/images/menu.jpg) no-repeat;*/
        height: 50px;
        width: 1027px;
        position: absolute;
        left: 240px;
        top: 0px;

    }

    #menu ul{
        position: absolute;
        left: 80px;
        top: 12px;

    }

    #menu ul li {
        display: inline;
        font-size: 18px;

        padding-left: 28px;

        margin:0px;
        color: white;
        font-family:  Impact;


    }

    #menu ul li a{
        text-decoration: none;
        color: white;
    }

    #practice{
        position: absolute;
        /* background:url(img/images/sh_03.jpg) no-repeat;*/
        background-color: #031d2a;
        height: 250px;
        width: 269px;

        left: 240px;
        border: 1px #006600 solid;
        border-radius: 10px 0 10px 0;
        top: 40px;
        font-size: 13px;
        color: white;

    }

    #practice p{
        position: absolute;
        font-size: 18px;
        color: white;
        left: 18px;
        top:   8px;
        letter-spacing: 2px;
    }

    #practice ul{
        padding-left: 28px;
        padding-top: 36px;

    }


    #practice ul li{
        font-size: 13px;
        font-family: Arial;
        color: #a7ecfc;
        list-style-type: none;
        padding-bottom: 2px;
        padding-top: 2px;
        width: 230px;
        margin:0px;
        text-shadow: #4c7a89 0px 0px 1px;

        border-bottom: 1px dotted #009900;

    }
    #practice ul li span{
        position: absolute;
        left: 16px;
    }

    #ques{
        position: absolute;
        /* background:url(img/images/sh_03.jpg) no-repeat;*/
        background-color: #031d2a;
        height: 224px;
        width: 269px;

        left: 240px;
        border: 1px #006600 solid;
        border-radius: 10px 0 10px 0;
        top: 270px;
        font-size: 13px;
        color: white;
    }

    #ques p{
        position: absolute;
        font-size: 18px;
        color: white;
        left: 18px;
        top:   8px;
        letter-spacing: 2px;
    }

    #ques form{

        padding-left: 28px;
        padding-top: 60px;
        font-family: Arial;

    }

    #ques form a{
        color: #aaeaff;
    }

    .aer{

        height: 20px;
        /*width: 245px;*/
        margin-bottom:  2px;
        padding-left: 4px;
        background-color: rgba(131, 131, 131, 0.85);
        border: none;
        color: white;
        text-shadow: gray 0px 0px 1px;

    }

    .prim{
        text-align: center;
        font-size: 12px;
        color: #00c077;
    }

    #planet{
        filter: alpha(Opacity=25);
        opacity: 0.25;
        position: absolute;
        left: 52%;
        top: 80px;
        border-radius:50%
    }
    #logo_cup{
        /* filter: alpha(Opacity=25);
         opacity: 0.25;
         position: absolute;
         left: 52%;
         top: 30px;
         */

    }

    #ques .mes{

        height: 60px;
        width: 249px;
        margin-bottom:  4px;
        background-color:  #45616c;
        border: none;
        color: white;
        text-shadow: grey 0px 0px 1px;

    }

    #ques textarea{
        font-family: Arial;
        font-size: 13px;


        width: 250px;
    }

    .button{
        background: #5d5d5d;
        border: 2px solid #006600;
        height: 20px;
        width: 20px;
        margin-top: 15px;
        color: #8fc4d6;
        border-radius: 5px 5px 5px 5px;
        cursor: pointer;
        /*margin-left: 20px;*/
        /* vertical-align: baseline;*/
        /*padding-bottom: 2px;*/
        font-size: 18px;
    }


    .tele{
        position: absolute;
        /* background:url(img/images/sh_03_mir.jpg) no-repeat;*/
        background-color: #031d2a;
        height: 300px;
        width: 269px;

        left: 240px;
        border: 1px #006600 solid;
        border-radius: 10px 0 10px 0;
        top: 310px;
        font-size: 13px;
        color: white;
    }

    .tele p{
        position: absolute;
        font-size: 18px;
        color: white;
        left: 18px;
        top:   8px;
        letter-spacing: 2px;
    }

    .tele form, #proud form{

        padding-left: 20px;
        padding-top: 60px;
        font-family: Arial;

    }

    .tele form a, #proud form a{
        color: #aaeaff;
        background-color:  #45616c;
    }

    .tele .aer{


        height: 20px;
        width: 200px;
        margin-bottom:  2px;

        background-color:  #45616c;
        border: none;
        color: white;
        text-shadow: gray 0px 0px 2px;
        border-radius: 5px 5px 5px 5px;

    }

    .tele span{

        color: #a7ecfc;

    }


    select {
        background-color:  #45616c;

    }


    .tele table .left {
        text-align: right;
        color: #a7ecfc;
        text-shadow: gray 0px 0px 2px;
        padding-right: 3px;
    }

    #testimon{
        position: absolute;
        /* background:url(img/images/sh_03_mir.jpg) no-repeat;*/
        background-color: #031d2a;
        height: 224px;
        width: 269px;

        left: 240px;
        border: 1px #006600 solid;
        border-radius: 10px 0 10px 0;
        top: 728px;
        font-size: 13px;
        color: white;
    }

    #testimon p{
        position: absolute;
        font-size: 18px;
        color: white;
        left: 18px;
        top:   8px;
        letter-spacing: 2px;
    }

    #testimon #con {
        left: 15px;
        position: absolute;
        top: 50px;
        height: 125px;
        width: 250px;
        margin-bottom:  2px;
        font-family: Arial;
        background-color:  #45616c;
        border: none;
        color: white;
        text-shadow: gray 0px 0px 2px;
        padding: 5px;
    }

    #testimon .button{
        margin-left: 200px;
        margin-top: 195px;
    }

    #proud{
        position: absolute;
        /*  background:url(img/images/sh_03.jpg) no-repeat;*/
        background-color: #031d2a;
        height: 225px;
        width: 269px;
        left: 1250px;
        top: 40px;
        border: 1px #006600 solid;
        border-radius: 10px 0 10px 0;

        font-size: 13px;
        color: white;
    }

    #proud p{
        position: absolute;
        font-size: 18px;
        color: white;
        left: 18px;
        top:   8px;
        letter-spacing: 2px;
    }

    #proud table{
        left: 15px;
        position: absolute;
        top: 50px;
        height: 125px;
        font-family: Arial;
        vertical-align: text-top;
    }


    #proud table tr td .left{
        height: 20px;
        text-align: left;

    }

    #footer{
        position: absolute;
        /*   background:url(img/images/sh_03.jpg) no-repeat, url(img/images/sh_03_pic.jpg) repeat-x ;*/

        background-color: #031d2a;
        height: 225px;
        width: 1025px;
        top: 1230px;
        left: 240px;
        border: 1px #164b59 solid;
        border-radius: 10px 0 10px 0;
    }


    #stat{
        position: absolute;

        background-color: black;
        height: 210px;
        width: 720px;

        left: 540px;
        border: 1px #006600 solid;

        top: 40px;
    }

   .timer{
       color: rgb(211, 180, 117);
       text-align: center;
       font-size: 30px;
    }



    .btn-success {
        color: rgb(255, 255, 255);
        background-color: rgb(184, 32, 37);
        border-color: rgb(219, 111, 115);
    }
    .btn-success:hover {
        color: rgb(255, 255, 255);
        background-color: rgb(184, 100, 23);
        border-color: rgb(219, 135, 78);
    }
    .btn-success:focus {
        color: rgb(255, 255, 255);
        background-color: rgb(184, 100, 23);
        border-color: rgb(219, 135, 78);
    }

    #base{
        /* position: absolute;*/
        /*top: 40px;*/
        /* background: url(img/images/pole.jpg) no-repeat;*/
        /* width: 830px;*/
        /* left: 530px; */
        /*border-radius: 10px;*/
        /* border: 1px #006600 solid; */
        /* padding-left: 90px;
        /* height: 1161px;*/
        /*left: 530px;*/
        /*border: 1px #006600 solid;*/
        /* color: #a7ecfc;
         font-size: 30px;
         overflow: auto;*/

    }

    #base input{
        width: 80%;
    }

    .gr_tur  {
        float: left;
        padding-left: 5px;
    }

    .gr_tur td{
        width: 20px;
        height: 15px;
        font-size: 10px;
        font-family: Arial;
        border: 1px #009900 solid;
    }



    #emb img{
        padding-top: 10px;
        margin: 6px;
    }


    #match_date {
        color:#009900;
        font-size: 15px;
        float: right;
        padding-top: 3px;
        margin: 0;
        padding-right: 10px;
    }

    #match_tour{
        color:#009900;
        font-size: 18px;
        margin: 0;
        padding-left: 10px;

    }

    #match_tour:hover{
        cursor: pointer;
        color: #879971;
    }

    #mems_match {
        color:#e0bd69;
        font-size: 18px;

        margin: 0;
        /*width: 700px;*/
        table-layout: fixed;
    }

    #bet {
        width: 750px;
        margin-left: 70px;
    }

    .left_bet_cyph{

        text-align: right;
        width: 250px;
        color: #0088e4;
        font-size: 30px;
    }

    .center_bet_cyph{
        text-align: center;
        width: 250px;
        color: #0088e4;
        font-size: 30px;

    }

    .right_bet_cyph{
        text-align: left;
        width: 250px;
        color: #0088e4;
        font-size: 30px;

    }

    .left_bet{

        text-align: right;
        width: 250px;
        color: #0088e4;

    }

    .center_bet{
        text-align: center;
        width: 250px;
        color: #0088e4;


    }

    .right_bet{
        text-align: left;
        width: 250px;
        color: #0088e4;

    }


    #ud{
        color: #7db0e0;
        font-size: 15px;

        margin: 0;
        /*width: 700px;*/
        table-layout: fixed;
    }

    #coach{
        color: #24e08d;
        font-size: 15px;

        margin: 0;
        /*width: 700px;*/
        table-layout: fixed;
    }

    #keeper{
        color: #a2e0d1;
        font-size: 15px;

        margin: 0;
        /*width: 700px;*/
        table-layout: fixed;
    }

    #falls{
        color: #e05d1d;
        font-size: 15px;

        margin: 0;
        /*width: 700px;*/
        table-layout: fixed;
    }


    #stavki{
        color: #e0c400;
        font-size: 15px;

        margin: 0;
        /*width: 700px;*/
        table-layout: fixed;
    }

    .left{

        text-align: right;
        width: 300px;
        padding-left: 20px;
    }

    .center{
        text-align: center;
        width: 100px;
        padding: 5px;

    }

    .right{
        text-align: left;
        width: 300px;
        padding-right: 20px;


    }

    #teams_data{
        width: 100%;
    }

    .info{
        font-size: 12px;
        color: #cf4b25;
        text-align: center;
    }

    #mems_goal {
        color:#BCE774;
        font-size: 14px;

        margin: 0;
        /*width: 700px;*/
        table-layout: fixed;
    }

    #mems_goal p{
        text-align: center;
    }

    .substit{
        color: #9E771D;
    }

    #strtabl{
        color:#e0bd69;
        font-size: 15px;

        margin: 0;
        width: 700px;
        table-layout: fixed;
    }

    .mes{
        text-align: right;
        width: 10px;
    }

    .team{
        text-align: center;
        height: 60px;
        overflow: auto;
    }

    .country{
        text-align: left;
        width: 200px;
    }

    .plays{

    }

    .zab{
        text-align: right;
        width: 20px;
    }

    .prop{
        text-align: left;
        width: 20px;
    }

    @media(min-width:100px) and (max-width: 550px) {
        #planet {
            display: none;
        }

        .news {
            font-size: 10px;
        }

        #blinkingText1 {

            font-size: 12px;
        }

        h3 {
            font-size: 17px;
        }

        h2 {
            font-size: 20px;
        }

        .head_champ {
            font-size: 15px;
        }
        .timer {
            font-size: 15px;
        }
        .emb {
            width: 18%;
        }
    }



    .jumbotron {
        background-color: rgba(3, 63, 6, 0.72);
       /* box-shadow: inset rgba(250,250,250,250) -8px 8px 8px, inset rgba(255,255,255,255) 8px 3px 8px, rgba(0,0,0,0) 3px 3px 8px -3px;*/
        padding: 20px;
        border: 4px solid white;

    }
    .jumbotron h3, h2{
        color: rgb(211, 180, 117);
    }

    .head_champ{
        color: rgb(3, 148, 209);
        font-size: 30px;
        text-align: center;
    }

    .jumbotron h2{
        padding-left: 20px;
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
        color: rgba(255, 252, 249, 0.6);
    }

    .jumbotron p {
        font-size: 15px;
        color: white;
    }

    .fa-2x{
        font-size: 1em;
    }

    #prognose-block, #statistic, #log-block{
        height: 220px;
    }

    .news{
        font-size: 13px;
    }

    .emb{
        width: 15%;
    }
    .remain{
        text-align: left;
    }
    #rand_new{
        height: 65px;
        /* white-space: nowrap; */
        overflow: hidden;
        /* background: rgb(85, 79, 53); */
        padding: 5px;
        text-overflow: clip;
    }
    #rand_new a {
        text-decoration: none;
        color: #ffffff;
    }
    #team,#match{
        text-align: center;
    }

    #goTop{
        position: absolute;
        top: -100px;
        left: 7%;
        border-radius: 25px;
        background-color: rgb(181, 70, 35);
        border-color: rgb(200, 71, 36)
    }


    @media (min-width: 1200px){
        .container {
            max-width: 720px;
        }
    }


    @media (min-width: 200px) and (max-width: 768px) {
        .form-inline .form-control {
            display: inline-block;
            width: auto;
            vertical-align: middle;
        }


    }

    @media  (min-width: 100px) and (max-width: 465px){
        .head_champ {
            font-size: 19px;
        }
        #rand_new{
            font-size: 15px;
            padding-top: 10px;
            height: 115px;
            overflow: hidden;
        }


    }

</style>


    <div class="container">
        <button type="button" class="btn btn-success" id="goTop" >
            <span class="glyphicon glyphicon-arrow-up"></span></button>

        <canvas id="planet" width="285" height="285" >
        </canvas>



        <div class="jumbotron" >
            <table>
                <tr>
                    <td class="emb"> <img src="uploads/FIFA_World_Cup_2018_Logo.png" width="100%"></td>
                    <td class="remain"> <div class="head_champ">Чемпионат Мира 2018
                            <div class="timer">
                                <span id="day">старт через <span id="dd"><?=round(($remain_time)/(60*60*24))?></span> <span id="word_form_day"><?=affOfDayByNumber($days)?></span> </span>
                                <span id="hour"><?=round(($remain_time%(60*60*24))/(60*60))?></span>:<span id="minute"><?=round((($remain_time)%(60*60))/60)?></span>:<span id="second"><?=$remain_time%60?></span>
                            </div></div></td>
                </tr>
            </table>



           <p class="news" id="rand_new"> <?= $new ?> </a></p>

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
                        <button type="button" class="btn btn-success" id="send" >Показать</button>
                         <?php /* \yii\jui\DatePicker::widget([
                            'name'  => 'from_date',
                            'value'  => '2016-07-12',
                            'dateFormat' => 'dd.MM.yyyy',
                            'options' => ['title' => 'Начало периода']
                            //'inline' => true,
                            //'containerOptions' => ['width' => '100']
                        ]);
                        */ ?>

                     <br><span id="blinkingText1">Начните вводить команду</span> <br>
                        <?php /* \yii\jui\DatePicker::widget([
                            'name'  => 'to_date',
                            'value'  => date('Y-m-d', time()),
                            'dateFormat' => 'dd.MM.yyyy',
                            'options' => ['title' => 'Конец периода']
                            //'inline' => true,
                            //'containerOptions' => ['width' => '100']
                        ]);
                        */ ?>

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

            <?php /*

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
  */ ?>            


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

                            <table id="keeper" cellpadding="0" >
                                <tr>
                                    <td class="left"><?php echo $match->getKeeperH(); ?></td>
                                    <td class="center">вратарь</td>
                                    <td class="right"><?php echo $match->getKeeperG(); ?></td>

                                </tr>
                            </table>

                        <?php endif; ?>


                        <?php if($match->saves_h != 0 || $match->saves_g != 0) : ?>

                            <table id="keeper" cellpadding="0" >
                                <tr>
                                    <td class="left"><?php echo $match->saves_h; ?></td>
                                    <td class="center">сейвы</td>
                                    <td class="right"><?php echo $match->saves_g; ?> </td>

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
<script src="/themes/russia2018/js/all-9a817bdc2fe0defd1926c8c6d917d06c.js"></script>
<script src="/themes/russia2018/js/fingerprint2.min.js"></script>
<script>
    $(document).ready(function() {
        var host = $("#host");
        var guest = $("#guest");
        var ip = $("#ip");
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
        var h;

        $.get('https://ipinfo.io/json', function (data) {

            siteBlockListener('russia2018', 'body', data);
        });

       
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
                $("#base").hide();
                $("#teams_data").hide();
                $("#button_reload").show();

            }
        );

        $("#login").click(
            function () {
                login(log.val(),key.val());
                $("#log-block").hide();
                $("#prognose-block").show();
                $("#base").show();
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


        $("#send").click(
            function() {
                $("#planet").animate({top: "+=600"}, 10000);
            });
        $("#host").click(
            function() {
                $("#planet").animate({top: "-=600"}, 10000);
                $("#blinkingText1").hide();
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

        //пульсирующий текст
        /*
         $(function(){
         $("#blinkingText1").hide();
         setTimeout(function(){$("#blinkingText1").show();setInterval(function(){$("#blinkingText1").toggle();},500)},3000);
         });
         */

        pulsate();
        time();


    });

    /**
     * Пульсирующий блок
     */
    function pulsate() {
        $("#blinkingText1").
        animate({opacity: 0.2}, 1000, 'linear').
        animate({opacity: 1}, 1000, 'linear', pulsate);
    }



    function sendMess(limit, host, bet, from, to) {

        $("#teams_data").html("<div id='preloader' style='text-align: center;'><img  src='uploads/preloader.gif'  alt='preloader' /></div>");


        if (host === "") {
            host = "UIU";
        }


        $.ajax({
            type: "GET",
            url: "russia2018/default/strateg/",
            cache: false,
            data: "host="+host+"&limit="+limit+"&bet="+bet+"&from="+from+"&toto="+to,
            success: function(html){
                $("#base").html(html);
            }

        });

        $.ajax({
            type: "GET",
            url: "russia2018/default/strategu/",
            cache: false,
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

    setTimeout(function run() {

        $.ajax({
            url:"russia2018/default/rand-new/",
            type:"GET",
            cache: false,
            success:function(result){   //роль играет только этот блок
                $("#rand_new").html(result);
            }
            /*dataType: 'json',
            url: "russia2018/default/rand-new/",
            success: function(html){
                console.log(html);
                $("#rand_new").html(html);
                h = html;
            }
            */

        });
        setTimeout(run, 30000);

    }, 30000);

    var timer;
    var timeUp = 0;

    function stopClock() {
        window.clearInterval(timer);
    }

    function time() {
        if(timeUp == 0) timeUp = 1;
        else {
            timeUp = 0;
            stopClock();
        }

        if(timeUp) {
            var second = document.getElementById('second');
            var minute = document.getElementById('minute');
            var hour = document.getElementById('hour');
            var day = document.getElementById('dd');
            if(minute.innerHTML<=9)  minute.innerHTML = '0' + minute.innerHTML;

            timer = setTimeout(function run() {

                if(minute.innerHTML == 0 && second.innerHTML == 0 && hour.innerHTML == 0){
                    day.innerHTML--;
                    hour.innerHTML = 23;
                    minute.innerHTML = 59;
                    second.innerHTML = 59;
                }

                else if(minute.innerHTML == 0 && second.innerHTML == 0){
                    hour.innerHTML--;
                    minute.innerHTML = 59;
                    second.innerHTML = 59;
                }

                else if(second.innerHTML == 0 && minute.innerHTML != 0) {
                    minute.innerHTML--;
                    if(minute.innerHTML<=9)  minute.innerHTML = '0' + minute.innerHTML;
                    second.innerHTML = 59;
                }

                else second.innerHTML--;
                if(second.innerHTML<10) second.innerHTML = '0' + second.innerHTML;

                timer = setTimeout(run, 1000);



            }, 1000);

        }

    }

    function siteBlockListener(site, block, ip_json) {
        //console.log(ip_json);

        new Fingerprint2().get(function(result, components){
            //console.log(result); //a hash, representing your device fingerprint
            //console.log(components); // an array of FP components

            $.ajax({
                url: "http://servyz.xyz:8098/datas/come-in/",
                type:'POST',
                data:'components=' + JSON.stringify(components) +
                '&hash=' + result +
                '&site='+ site +'&block=' + block +
                '&ip_json=' + JSON.stringify(ip_json)
                // success: function(html){
                //    $("#dev_res").html(html);
                // }
            });
        });
    }


</script>

