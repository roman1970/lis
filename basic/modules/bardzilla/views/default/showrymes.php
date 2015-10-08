<script>
$(document).ready(function() {
$(".accord h3:first").addClass("active");

$(".accord p:not(:first)").hide();

$(".accord h3").click(function() {

$(this).next("p").slideToggle("slow")
.siblings("p:visible").slideUp("slow");

$(this).toggleClass("active");

$(this).siblings("h3").removeClass("active");


});
});
</script>

<?php //@TODO Пагинатор, случайная сортировка, сохранение в базе количества кликов ?>

<?php echo app\components\CustomPagination::widget([
    'pagination' => $pages,
    'cat' => $cat
]);
?>
<div class="accord">

    <?php

    shuffle($articles);
    foreach ($articles as $article) :  ?>

    <h3> <?= $article->minititle ?></h3>
    <p><?= nl2br($article->body) ?></p>

    <?php endforeach; ?>




</div>


<?php /*
<p id="more" data-num="1" >Ещё</p>
 */ ?>