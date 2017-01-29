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
</style>

<div id="res"></div>
<div class="accord">

    <?php // var_dump($thoughts);
    //echo $thoughts[rand(0,count($thoughts-1))]->text;  ?>

    <?php foreach ($news as $new): ?>

        <h3 class="song-name"><?= $new->title ?> </h3>

        <span class="song-text" ><?= nl2br($new->description) ?><br>



        </span>
        <hr>
    <?php endforeach; ?>


</div>