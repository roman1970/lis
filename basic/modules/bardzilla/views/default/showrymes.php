<script>
var cnt = null;
var block = null;
$(document).ready(function() {
$(".accord h3:first").addClass("active");

$(".accord p:not(:first)").hide();

    $(".accord h3").click(function() {

        $(this).next("p").slideToggle("slow")
            .siblings("p:visible").slideUp("slow");
        cnt = $(this).attr("id");

        if (cnt) {
            $('#count').load("bardzilla/default/counter/" + cnt);
        }
        else console.log('problem with counter');

    $(this).toggleClass("active");

    $(this).siblings("h3").removeClass("active");
    });
});
</script>

<?php //@TODO сохранение в базе количества кликов ?>

<?php echo app\components\CustomPagination::widget([
    'pagination' => $pages,
    'cat' => $cat
]);
?>
<div class="accord">

    <?php

    shuffle($articles);
    foreach ($articles as $article) : ?>

    <h3 id="<?= $article->id ?>"> <?= $article->minititle ?></h3>
    <p><?= nl2br($article->body) ?><br>
        <span class="smallest">просмотров: <?= $article->count ?></span>
    </p>
    <span id="count"  style="display: none"><?= $article->id ?></span>



    <?php endforeach; ?>




</div>


<?php /*
<p id="more" data-num="1" >Ещё</p>
 */ ?>
