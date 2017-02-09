<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {

        $(".accord h4:first").addClass("active");

        $(".accord div").hide();

        $(".accord h4").click(function() {

            $(this).next("div").slideToggle("slow").siblings("div:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h4").removeClass("active");
        });

        $("#bind").click(
            function() {

                var title = $("#idea_title").val();
                alert(title);

                //bind_item(txt, user, idea_id);

            });



    });

    function bind(id) {

        var title = $("#idea_title_" + id).val();
        //alert(title);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/bind-project-item",
            data: "idea=" + title + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }
    
    function toPlayList(id) {
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/add-item-to-play-list",
            data: "user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }

    function autocompl(id) {

        $('#idea_title_' + id).autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/ideas", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

    }

</script>

<style>
    img{width: 100%}
    h4{cursor: pointer}
    h3{ color: rgb(255, 215, 0); }

    audio
    {
        -webkit-transition:all 0.5s linear;
        -moz-transition:all 0.5s linear;
        -o-transition:all 0.5s linear;
        transition:all 0.5s linear;
        -moz-box-shadow: 2px 2px 4px 0px #006773;
        -webkit-box-shadow:  2px 2px 4px 0px #006773;
        box-shadow: 2px 2px 4px 0px #006773;
        -moz-border-radius:7px 7px 7px 7px ;
        -webkit-border-radius:7px 7px 7px 7px ;
        border-radius:7px 7px 7px 7px ;
    }

    audio:hover, audio:focus, audio:active
    {
        -webkit-box-shadow: 15px 15px 20px rgba(0,0, 0, 0.4);
        -moz-box-shadow: 15px 15px 20px rgba(0,0, 0, 0.4);
        box-shadow: 15px 15px 20px rgba(0,0, 0, 0.4);
        -webkit-transform: scale(1.05);
        -moz-transform: scale(1.05);
        transform: scale(1.05);
    }
</style>

<div style="text-align: center; color: white" class="accord">
    <hr>
    <hr>
    <h3>Краткости талантов</h3>
    <hr>
    <?php
        $i=0;
        if(is_array($items_rows)) :
            foreach ($items_rows as $rec): $i++; ?>
                <hr>
                <h4><?=$i?>) <?=$rec->title?></h4>
                <div>
                    <?php if($rec->audio_link) : ?>
                        <audio controls="controls" >
                            <source src="http://37.192.187.83:10080/<?=$rec->audio_link?>" type='audio/mpeg'>
                        </audio><br>
                    <?php endif; ?>
                    <?php if($rec->img) : ?>
                        <img src="<?=$rec->img?>">
                    <?php endif;
                    ?>
                    
                    <?=nl2br($rec->text)?>

                    <?='<br>('.$rec->source->title.' - '.$rec->source->author->name.')'?>
                    <form class="form-inline center" role="form" id="form-event">
                        <input type="text" class="form-control" id="idea_title_<?=$rec->id?>" onfocus="autocompl(<?=$rec->id?>)" placeholder="Идея">
                        <br>
                        <button type="button" class="btn btn-success" onclick="bind(<?=$rec->id?>)" >Привязать айтем к идее!</button>
                        <button type="button" class="btn btn-success" onclick="toPlayList(<?=$rec->id?>)" >Добавить в конец основного плейлиста!</button>

                    </form>
                </div>

            <?php
               endforeach;
            else: echo $items_rows;
        endif;
    ?>
    <hr>
    <hr>
    <h3>События</h3>
    <hr>
    <?php //var_dump($events_rows); exit;
        if(is_array($events_rows)) :
            foreach ($events_rows as $rec): $i++;
                ?>
                <hr>
                <h4><?=$i?>) <?=date('Y-m-d', $rec->act->time)?></h4>
                <div><?=nl2br($rec->text)?><br>
                <?php if($rec->img) : ?>
                <img src="<?=$rec->img?>">
                <?php endif; ?>
                </div>
                <?php
            endforeach;
        else: echo $events_rows;
    endif;
    ?>
    <hr>
    <hr>
    <h3>Новости</h3>
    <hr>
    <?php //var_dump($events_rows); exit;
    if(is_array($news_rows)) :
        foreach ($news_rows as $rec): $i++;
            ?>
            <hr>
            <h4><?=$i?>) <?=$rec->title?></h4>
            <div><?=nl2br($rec->description)?></div>
        <?php endforeach;
    else: echo $news_rows;
    endif;
    ?>
</div>
