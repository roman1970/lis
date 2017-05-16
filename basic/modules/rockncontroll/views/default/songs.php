<script>

    var source_id = <?= (isset($source->id)) ? $source->id : 1 ?>;
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;

    var songs = [
        <?php  foreach ($songs as $song):  ?>
        {url:'http://localhost:8088<?=addslashes($song->link)?>', name: '<?=addslashes($song->title)?> - <?=addslashes($song->source->title)?>'},
        <?php endforeach; ?>
    ];
    $(document).ready(function() {
       // console.log(songs[0]);

        $('#album').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();

                $.getJSON("rockncontroll/default/source-album", function (data) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });
        
        $("#play").click(
            function() {


               
                var theme_song = $("#theme_song").val();
                

                if (theme_song == '') {
                    alert('Введите тему песни!');
                    return;
                }
                

                play_songs(theme_song, user);


            });

        $("#new_marker").click(
            function() {

                var mark = $("#mark").val();

                if (mark == '') {alert('Введите текст закладки!'); return;}

                new_mark(mark, source_id, user);

            });

        $("#search_album").click(
            function() {

                var album = $("#album").val();

                if (album == '') {alert('Начните вводить название альбома!'); return;}

                search_album(album, user);

            });



    });


    function play_songs(theme_song, user) {
        
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/music",
            data: "theme_song="+theme_song+"&user="+user,
            success: function(html){
                $("#sum_play").html(html);

            }

        });

    }

    function new_mark(mark, id, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/markers",
            data: "mark="+mark+"&id="+id+"&user="+user,
            success: function(html){
                $("#summary").html(html);

            }

        });

    }
    
    function search_album(album, user) {
        
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/get-album",
            data: "album="+album+"&user="+user,
            success: function(html){
                $("#summary").html(html);

            }

        });
    }


</script>

    <style>
    .center, h3{
        text-align: center;
        color: rgb(255, 215, 0);

    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
        word-break: break-all;
    }

    h3{
        color: rgb(255, 215, 0);
    }
    .glyphicon {
        color: gold !important;
    }

    img{
        width: 100px;
    }
</style>

<div id="sum_play">
<form class="form-inline center" role="form" id="form-event">
    <div class="form-group">
        <h3>Тренируемся:</h3>
        <h4><?= $source->author->name ?></h4>
        <h4><?= $source->title ?></h4>
        <p class="marker"><?= $source->marker ?></p>

        <h3>Закладка:</h3>
        <p>
            <input type="text" class="form-control" id="mark" value="<?= $source->marker ?>" >
            <br>
            <button type="button" class="btn btn-success" id="new_marker" >Новая закладка!</button>
        </p>
        <div id="res"></div>
    </div>
</form>

<form class="form-inline center" role="form" id="form-album">
    <div class="form-group">
        <h3>Найти альбом!</h3>
        <p>

            <input type="text" class="form-control" id="album"  placeholder="Альбом"><br>

            <button type="button" class="btn btn-success" id="search_album" >Найти альбом!</button>
        </p>
    </div>
</form>


<form class="form-inline center" role="form" id="form-ate">
    <div class="form-group">
        <h3>Найти пестню!</h3>
        <p>
           
            <input type="text" class="form-control" id="theme_song"  placeholder="Тема песни"><br>

            <button type="button" class="btn btn-success" id="play" >Найти!</button>
        </p>
    </div>
</form>
    



    <?php  if(is_array($songs)) :
        foreach ($songs as $song) : ?>
            <div class="center">
                <?php if($song->source->cover) : ?>
                    <img src="<?=$song->source->cover?>">
                <?php endif; ?>
                <p><?=$song->source->author->name?> *** <?=$song->source->title?> *** <?=$song->title?></p>
                <audio controls="controls" >
                    <source src="http://37.192.187.83:10080<?=$song->link?>" type='audio/mpeg'>
                </audio>
            </div>
            <hr>

        <?php endforeach; ?>
    <?php endif; ?>
</div>




