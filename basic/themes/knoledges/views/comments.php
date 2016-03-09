<h3>Комментарии</h3>
<div id="comm">
    <?php foreach ($comments as $comment) : ?>
        <p><?=$comment->name?></p>
        <p class="red"><?=$comment->body?></p>

    <?php endforeach; ?>

</div>
