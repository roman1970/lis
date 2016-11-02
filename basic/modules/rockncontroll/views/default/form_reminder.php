<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {

        
        $("#record").click(
            function() {
                
                var txt = $("#text").val();
             
                if (txt == '') {alert('Введите текст!'); return;}
             
                rec(txt, user);

            });
        

    });

  
    function rec(txt, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/rec-remind",
            data: "txt="+txt+"&user="+user,
            success: function(html){
                $("#res").html(html);

            }

        });

    }



</script>

<style>
    .center, h3, table > tbody > tr > td{
        text-align: center;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
    }
    h3{
        color: rgb(255, 215, 0);
    }


    .form-control {
        width: 100%;
    }


</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">
            <h3>Напомнить?</h3>
            <p>
                
                <textarea class="form-control" id="text" placeholder="Текст" rows="10" cols="45"><?= $note ?></textarea>
                <br>
                <button type="button" class="btn btn-success" id="record" >Обновить напоминалку!</button>
            </p>
            <div id="res"></div>
        </div>
    </form>
    
</div>