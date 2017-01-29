<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<style>
    .theme_title{
        text-align: center;
    }
</style>

    <div class="content">
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

<script>

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
                            document.location.href='http://localhost:8080/tablo.html';

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

