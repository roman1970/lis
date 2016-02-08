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
</script>

<div class="accord">
            <p><?= $group ?></p>

            <?php foreach ($songs as $song): ?>
            <h3 class="song-name"><?= $song->name ?></h3>

                <span class="song-text" ><?= nl2br($song->text) ?></span>

            <?php endforeach; ?>

</div>
