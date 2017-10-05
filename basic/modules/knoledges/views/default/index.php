<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<style>
    #team_host, #team_guest {
        width: 40%;
        font-size: 40px!important;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #score_host, #score_guest{
        font-size: 80px;
    }
    #tournament{
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .theme_title{
        text-align: center;
    }
    body{
        background-color: rgb(91, 192, 222);
    }
    header {
        background: none;
    }
    td, #tournament, #form{
        text-align: center;
    }

    }

    .timer{

        font-size: 50px;
    }
    #score_host, #score_guest, .timer{
        cursor: pointer;
    }
    #tablo{
        margin-top: 100px;
        border-radius: 10px;
        box-shadow: 0 0 6px black;
    }
    #form{
        margin-top: 10px;
        border-radius: 10px;
        box-shadow: 0 0 6px black;
    }


    @media (min-width:500px) and (max-width:1900px){
        #team_host, #team_guest{
            font-size: 40px!important;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #score_host, #score_guest{
            font-size: 80px!important;
        }

        .timer{
            font-size: 40px;
        }

        .table {
            table-layout: fixed;
        }
    }

    @media (max-width:500px){
        #team_host, #team_guest{
            font-size: 20px!important;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #score_host, #score_guest{
            font-size: 25px!important;
        }

        .timer{
            font-size: 20px;
        }

        .table {
            table-layout: fixed;
        }
    }



</style>

    <div class="content" id="tester">
            <div class="uli">

                <div class="theme_title">
                    <h1>Проверь себя</h1>
                    <h4><?= $test->body ?></h4>
                    <?php foreach ($test->answers as $key => $answer): ?>
                       <p><input type="radio"  onclick="(<?= $answer->id ?>)" name="q" value="<?= $answer->id ?>">
                           <?= $answer->body ?></p>
                    <?php endforeach; ?>
                    <div id="res_qu">
                        <button type="button" class="btn btn-success btn-lg btn-block" id="w">Проверить</button>
                    </div>

                </div>
                

            </div>
    </div>

<div id="block" style="display: none">
    <div class='container' id="tablo">
        <h2 id="tournament">Чемпионат</h2>
        <div class="table-responsive">
            <table class="table">
                <tr class="teams">
                    <td id="team_host" style="font-size: 40px">Сибирь</p></td>
                    <td></td>
                    <td id="team_guest" style="font-size: 40px">Трактор</td>
                </tr>
                <tr class="score">
                    <td id="score_host" onclick="scoreIter('score_host')" style="font-size: 100px">0</td>
                    <td onclick="time()" class="timer"><span id="minute">2</span>:<span id="second">00</span><p id="finish"></p></td>
                    <td id="score_guest" onclick="scoreIter('score_guest')" style="font-size: 100px">0</td>
                </tr>
            </table>
        </div>
    </div>

    <div class='container' id="form">
        <form class="form-inline center" role="form" id="form-ate">
            <div class="form-group">
                <h3>Заполни форму!</h3>
                <p>

                    <input type="text" class="form-control" id="set_tournament"  placeholder="Турнир"><br>
                    <input type="text" class="form-control" id="set_host"  placeholder="Хозяин"><br>
                    <input type="text" class="form-control" id="set_guest"  placeholder="Гость"><br>
                    <input type="text" class="form-control" id="set_minute"  placeholder="Минуты"><br>
                    <button type="button" class="btn btn-success" id="set_button" onclick="setField()">Установить!</button>
                </p>
            </div>
        </form>
    </div>
    <audio style="display: none" src="verdy_march_aida.mp3" id="audio"></audio>

</div>
<script>

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

            timer = setTimeout(function run() {

                if(second.innerHTML == 0) {
                    minute.innerHTML--;
                    second.innerHTML = 59;
                }
                else second.innerHTML--;
                timer = setTimeout(run, 1000);

                if(second.innerHTML<10) second.innerHTML = '0' + second.innerHTML;
                if(second.innerHTML == 0 && minute.innerHTML == 0) {
                    stopClock();
                    finish.innerHTML = 'Матч окончен!';
                    var audio = new Audio(); // Создаём новый элемент Audio
                    audio.src = 'uploads/mozart.mp3'; // Указываем путь к звуку "клика"
                    audio.autoplay = true; // Автоматически запускаем
                }
            }, 1000);

        }

    }

    function scoreIter(el) {
        var score = document.getElementById(el);
        score.innerHTML++;

    }

    function setField() {
        var tournament = document.getElementById('tournament');
        var host = document.getElementById('team_host');
        var guest = document.getElementById('team_guest');
        var minute = document.getElementById('minute');

        var tournament_field = document.getElementById('set_tournament');
        var host_field = document.getElementById('set_host');
        var guest_field = document.getElementById('set_guest');
        var minute_field = document.getElementById('set_minute');

        var set_form = document.getElementById('form');

        tournament.innerHTML = tournament_field.value;
        host.innerHTML = host_field.value;
        guest.innerHTML = guest_field.value;
        minute.innerHTML = minute_field.value;
        set_form.style.display = 'none';


    }


    document.getElementById("w").onclick = function(){

        var z = document.getElementsByName('q'), s='Choose your destiny!!';

        for (var i = 0; i < z.length; i++)  {

            if  (z[i].checked) {
                //alert(z[i].checked);

               // alert(isItTrue(z[i].value));
                $.ajax({
                    type: "GET",
                    url: "rockncontroll/default/true/",
                    data: "id="+z[i].value,
                    success: function(html){
                        if(html==1){
                            alert("Молодец");
                            document.getElementById('block').style.display = 'block';
                            document.getElementById('tester').style.display = 'none';
                        }
                        else {
                            alert('Попробуй ещё');
                            location.reload();
                        }

                    }

                });
                break;

            }

        }

    };

    function isItTrue(id) {


        $.ajax({
            type: "GET",
            url: "rockncontroll/default/true/",
            data: "id="+id,
            success: function(html){
                alert(html);
                return(html);
            }

        });


    }

</script>

