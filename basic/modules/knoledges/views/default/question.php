<div class="uli">

    <div class="theme_title">
        <h1>Выбери правильный перевод</h1>
        <h4><?= $test->body ?></h4>

        <?php $arr = $test->answers; shuffle($arr); foreach ($arr as $key => $answer): ?>
            <p><input type="radio"  onclick="(<?= $answer->id ?>)" name="q" value="<?= $answer->id ?>">
                <?= $answer->body ?></p>
        <?php endforeach; ?>

    </div>


</div>
