<style>
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
    #team_host, #team_guest {
        width: 40%;
        font-size: 40px!important;
    }
    #score_host, #score_guest{
        font-size: 80px;
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

</style>
<div id="block">
    <div class='container' id="tablo">
        <h2 id="tournament">Чемпионат</h2>
        <div class="table-responsive">
            <table class="table">
                <tr class="teams">
                    <td id="team_host" style="font-size: 40px">Сибирь</td>
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
                    audio.src = 'verdy_march_aida.mp3'; // Указываем путь к звуку "клика"
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

</script>
