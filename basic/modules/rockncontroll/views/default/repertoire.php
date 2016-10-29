<script>
    $(document).ready(function() {
        $(".accord h3:first").addClass("active");

        $(".accord span").hide();

        $(".accord h3").click(function() {

            $(this).next("span").slideToggle("slow").siblings("span:visible").slideUp("slow");


            $(this).toggleClass("active");

            $(this).siblings("h3").removeClass("active");
        });


    });

    function saveNextSong(user, id) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/save-next-song/",
            data: "user="+user+"&id="+id,
            success: function(html){
                $("#res").html(html);
            }

        });

    }
    
    function frash(user) {
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/frash/",
            data: "user="+user,
            success: function(html){
                $("#res_qu").html(html);
            }

        });
        
    }
</script>
<style>
    .song-name{
        font-size: 18px;
        color: rgb(255, 250, 240);
        cursor: pointer;
        text-align: center;
    }
    .song-text{
        font-size: 16px;
        color: rgb(255, 253, 150);
        text-align: center;
    }
</style>

<div id="res"></div>
<div class="accord">

    <?php // var_dump($thoughts);
    //echo $thoughts[rand(0,count($thoughts-1))]->text;  ?>

    <?php foreach ($songs as $song): ?>

        <h3 class="song-name"> <input type="radio" name="reper" onclick="saveNextSong(user, <?= $song->id ?>)" value="<?= $song->id ?>"> <?= $song->title ?> </h3>

        <span class="song-text" ><?= nl2br($song->text) ?><br>



        </span>
        <hr>
    <?php endforeach; ?>


</div>
<div id="res_qu">
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="frash(user)">Сброс очереди</button>
</div>
