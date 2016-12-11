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
    .accord{
        text-align: center;
    }
    .song-name{
        font-size: 18px;
        color: rgb(255, 250, 240);
        cursor: pointer;

    }
    .song-text{
        font-size: 16px;
        color: rgb(255, 253, 150);

    }
    .phrase{
        color: #acd57e;
    }
</style>

<div id="res"></div>
<div class="accord">


    <?php foreach ($songs as $song): ?>

        <h3 class="song-name"> <?= $song->title ?> </h3>


         <span class="song-text">
             <br>
             <hr>
             <p class="phrase"><?= nl2br($song->phrase2) ?></p>
             <br>
             <hr><?= nl2br($song->text) ?></span>
        <p class="phrase"> <?= nl2br($song->phrase) ?></p>

        <hr><hr>
    <?php endforeach; ?>


</div>

