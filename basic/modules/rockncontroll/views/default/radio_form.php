<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {


        $("#make_pl").click(
            function() {

                var txt = $("#words").val();

                if (txt == '') {alert('Введите ключевые слова!'); return;}

                find(txt, user);

            });

        $("#player").click(
            function() {
                $("#silent").display = 'none';

            });

        $('#words').focus(
            function () {
                $(this).select();
            })

    });

    function find(txt, user) {
        //console.log(txt);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/radio",
            data: "request=" + txt + "&user=" + user,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }



</script>
<style>
    .form-group{
        text-align: center;
    }
    h4,p, #silent{
        color: white;
        text-align: center;
    }
</style>
<div class="container">
    <div id="silent">Включить радио</div>

    <p style="text-align: center" id="player">
        <p>
            <audio controls="controls" >
                <source src="http://37.192.187.83:10088/test_mp3" >
            </audio>
        </p>
        <p>
            <audio controls="controls" >
                <source src="http://37.192.187.83:10088/second_mp3" >
            </audio>
        </p>
        <p>
            <audio controls="controls" >
                <source src="http://37.192.187.83:10088/bard_mp3" >
            </audio>
        </p>
    <p id="radio"></p>

    </p>
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">

            <p class="center">
                <input type="text" class="form-control" id="words"  placeholder="Ключевые слова">

                <button type="button" class="btn btn-success" id="make_pl" >Создать плейлист!</button>
            </p>
            <div id="res"></div>
        </div>
    </form>

</div>

<script>


    /*setInterval(function () {
     $.ajax({
     type: "GET",
     url: "rockncontroll/default/rand-item/",
     success: function(html){
     $("#rand_item").html(html);
     h = html;
     }

     });

     }, 20000);
     */


    setTimeout(function run() {

     $.ajax({
     type: "GET",
     url: "rockncontroll/default/show-current-radio-tracks/",
     success: function(html){
     $("#radio").html(html);
     }

     });
     setTimeout(run, 10000);

     }, 10000);





</script>