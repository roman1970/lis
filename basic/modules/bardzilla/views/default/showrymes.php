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

<?php if(isset($articles)): ?>
    <?php foreach($articles as $article): ?>
    <?php echo app\components\CustomPagination::widget([
        'pagination' => $article['pages'],
        'cat' => $cat
    ]);
    ?>
    <div class="accord">

        <?php

        shuffle($article['contents']);
        foreach ($article['contents'] as $conts) : ?>

            <h3 id="<?= $conts->id ?>"> <?= $conts->minititle ?></h3>
            <p><?= nl2br($conts->body) ?><br>
                <span class="smallest">просмотров: <?= $conts->count ?></span>
            </p>
            <span id="count"  style="display: none"><?= $conts->id ?></span>



        <?php endforeach; ?>


    </div>

    <?php endforeach; ?>

<?php endif; ?>

<?php /*
<p id="more" data-num="1" >Ещё</p>
 */ ?>
