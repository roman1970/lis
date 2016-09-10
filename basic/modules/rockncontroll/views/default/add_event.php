<script xmlns="http://www.w3.org/1999/html">
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {

        $('#cat').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/deal-cats", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });
        
        $("#rec_event").click(
            function() {
                
                var cat = $("#cat").val();
                var txt = $("#text").val();
                
                if (cat == '') {alert('Введите категорию!'); return;}
                if (txt == '') {alert('Введите текст!'); return;}

                rec(cat, txt, user);

            });

        $('#cat').focus(
            function () {
                $(this).select();
            })

    });
    

    function rec(cat, txt, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/events",
            data: "cat="+cat+"&text="+txt+"&user="+user,
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
    <form class="form-inline center" role="form" id="form-event">
        <div class="form-group">
            <h3>Добавить событие?</h3>
            <p>
                <input type="text" class="form-control" id="cat"  placeholder="Категория">
                <textarea class="form-control" id="text"  placeholder="событие" rows="10" cols="45"></textarea>
                <br>
                <button type="button" class="btn btn-success" id="rec_event" >Записать!</button>
            </p>
            <div id="res"></div>

            <h3>Сегодня</h3>
            <ul>
            <?php
            //var_dump($today_event);
            if($today_event) :
                foreach ($today_event as $event) :
                ?>
                    <li style="color: rgb(255, 215, 0);; text-align: left"><?=$event->cat->name?> - <?=$event->text?></li>

                <?php endforeach; ?>
            <?php endif; ?>
            </ul>
        </div>
    </form>
    
</div>