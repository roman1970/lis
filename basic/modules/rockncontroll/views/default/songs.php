<script>

    var songs = [
        <?php  foreach ($songs as $song):  ?>
        {url:'http://localhost:8088<?=$song->link?>', name: '<?=$song->title?> - <?=$song->source->title?>'},
        <?php endforeach; ?>
    ];
    $(document).ready(function() {
        
        $("#play").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
               
                var theme_song = $("#theme_song").val();
                

                if (theme_song == '') {
                    alert('Введите тему песни!');
                    return;
                }
                

                play_songs(theme_song, user);


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
        foreach ($songs as $song):  ?>
            <div class="center">
                <?php if($song->source->cover) : ?>
                <img src="<?=$song->source->cover?>">
                <?php endif; ?>
                <p><?=$song->source->author->name?> *** <?=$song->source->title?> *** <?=$song->title?></p>
                <audio controls="controls" ">
                <source src="http://37.192.187.83:10080<?=$song->link?>" type='audio/mpeg'>
                </audio>
            </div>
            <hr>

        <?php endforeach; ?>
    <?php endif; ?>
</div>




