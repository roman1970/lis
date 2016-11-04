<script>
    var bounce = new Bounce();
    bounce
        .translate({
            from: { x: -100, y: 0 },
            to: { x: 0, y: 0 },
            duration: 100,
            stiffness: 4
        })
        .scale({
            from: { x: 1, y: 1 },
            to: { x: 0.1, y: 1.3 },
            easing: "sway",
            duration: 100,
            delay: 65,
            stiffness: 2
        })
        /*.scale({
            from: { x: 1, y: 1},
            to: { x: 2, y: 1 },
            easing: "sway",
            duration: 300,
            delay: 30,
        })*/
    bounce.applyTo(document.querySelectorAll(".phrasa"));
    // or with jQuery: bounce.applyTo($(".animation-target"));
</script>

<?php if(isset($articles)): ?>
    <?php foreach($articles as $article): ?>

        <div class="phrasa">
            <?php echo app\components\BardNextPagination::widget([
                'pagination' => $article['pages'],
                'cat' => $cat
            ]);
            ?>

            <?php

            shuffle($article['contents']);

            foreach ($article['contents'] as $conts) : ?>

                    <p><?= nl2br($conts->body) ?><br>
                        <?php if($conts->audio !== '') : ?>
                          <audio controls="controls" ">
                                <source src='<?=$conts->audio?>' type='audio/mpeg'>
                            </audio>
                         <?php endif; ?>
                    </p>

            <?php endforeach; ?>


        </div>


    <?php endforeach; ?>

<?php endif; ?>
