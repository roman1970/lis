<script>
    $(document).ready(function() {
        $(".accord h3:first").addClass("active");

        $(".accord span:not(:first)").hide();

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
</script>
<style>
    .song-name{
        font-size: 18px;
        color: rgb(255, 250, 240);
        cursor: pointer;
    }
    .song-text{
        font-size: 12px;
        color: rgb(255, 253, 150);
    }
</style>

<div id="res"></div>
<div class="accord">


    <?php foreach ($songs as $song): ?>
        <h3 class="song-name"> <input type="radio" name="reper" onclick="saveNextSong(user, <?= $song->id ?>)" value="<?= $song->id ?>"> <?= $song->title ?> </h3>

        <span class="song-text" ><?= nl2br($song->text) ?></span>

    <?php endforeach; ?>

</div>