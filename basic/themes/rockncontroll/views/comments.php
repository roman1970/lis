<h3>Комментарии</h3>
<div id="comm">
    <?php foreach ($comments as $comment) : ?>
    <div class="comm_table">
        <div class="row_table">
            <div class="comment_name cell"><?=$comment->name?></div>
            <div class="comment_name cell right"><?=$comment->d_created?></div>
        </div>
        <div class="row_table">
            <div class="comment_body"><?=$comment->body?></div>
        </div>
        <hr class="simple">
    </div>
        <?php endforeach; ?>

</div>
