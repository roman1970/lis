
<style>
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

    .big_font_with_padding{
        font-size: 55px;
        padding: 30px;
    }

    .center{
        text-align: center;
    }

</style>

<div class="content center" id="tester">
    <div class="uli">

        <div class="theme_title">
            <h1>Выбери правильный перевод</h1>
            <h4><?= $test->body ?></h4>
            <?php foreach ($test->answers as $key => $answer): ?>
                <p><input type="radio"  onclick="(<?= $answer->id ?>)" name="q" value="<?= $answer->id ?>">
                    <?= $answer->body ?></p>
            <?php endforeach; ?>


        </div>


    </div>

</div>
<div id="res_qu">
    <button type="button" class="btn btn-success btn-lg btn-block" id="w">Следующий</button>
</div>

<div class="center">
    <h3>У тебя </h3>
    <p id="balls" class="big_font_with_padding">0</p>
    <h3>баллов</h3>

</div>
<script>
    var counter = 0;
    document.getElementById("w").onclick = function(){
        counter++;

        var z = document.getElementsByName('q');
        var balls = document.getElementById('balls');
        var tester = document.getElementById('tester');
        var button = document.getElementById('res_qu');

        if(counter>20) {
            $.ajax({
                type: "GET",
                url: "default/question-end/",
                success: function(html){
                    
                    button.style.display = 'none';
                    tester.innerHTML = html;

                }

            });
           
        }

        for (var i = 0; i < z.length; i++)  {

            if  (z[i].checked) {
                //alert(z[i].checked);

                // alert(isItTrue(z[i].value));
                $.ajax({
                    type: "GET",
                    url: "default/true/",
                    data: "id="+z[i].value,
                    success: function(html){
                        if(html==1){
                            balls.innerHTML++;
                        }

                    }

                });

                $.ajax({
                    type: "GET",
                    url: "default/question/",
                    data: "id="+z[i].value,
                    success: function(html){
                        if(html == '<p class="big_font_with_padding">Тест закончен</p>')
                            button.style.display = 'none';

                        tester.innerHTML = html;

                    }

                });

                break;

            }

        }

    }


</script>

