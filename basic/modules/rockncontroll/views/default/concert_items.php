<style>
    .thougth{
        color: rgb(255, 222, 173);
        line-height: initial;
        font-size: 10px;
    }
    .short{
        width: 20px;
    }
</style>
<?php foreach ($songs as $song): ?>

    <h3 class="song-name"> <?= $song->title ?> </h3>
    <?php if($song->original_song_id) : ?>

        <audio controls="controls" >
            <source src="http://37.192.187.83:10080/<?=$song->original->link?>" >
        </audio>
        <br>
    <?php endif; ?>

    <?php /*<p class="phrase"> <?= \app\models\Items::findOne((int)$song->phrase_gen_id)->text ?></p> */?>

    <?php if($repers = \app\models\RepertuareItem::find()->where(['item_reper_id' => $song->id])->all()) : ?>


            <?php foreach ($repers as $thought): ?>
            <p class="thougth">
                <?=\app\models\Items::findOne($thought->item_phrase_id)->text ?>
            </p>
            <hr class="short">
            <?php endforeach; ?>


    <?php endif; ?>

    <hr>
<?php endforeach; ?>

<script>
    $(window).scroll(function() {
        if($(this).scrollTop() > 1000){
            $('#goTop').stop().animate({
                top: $(this).scrollTop() + $(this).height() - 100
            }, 500);
        }
        else{
            $('#goTop').stop().animate({
                top: '-100px'
            }, 500);
        }
    });
    $('#goTop').click(function() {
        $('html, body').stop().animate({
            scrollTop: 0
        }, 1000, function() {
            $('#goTop').stop().animate({
                top: '-100px'
            }, 1000);
        });
    });


</script>
