<script>
    var bounce = new Bounce();
    bounce
        .translate({
            from: { x: -300, y: 0 },
            to: { x: 0, y: 0 },
            duration: 600,
            stiffness: 4
        })
        .scale({
            from: { x: 1, y: 1 },
            to: { x: 0.1, y: 2.3 },
            easing: "sway",
            duration: 800,
            delay: 65,
            stiffness: 2
        })
        .scale({
            from: { x: 1, y: 1},
            to: { x: 5, y: 1 },
            easing: "sway",
            duration: 300,
            delay: 30,
        })
    bounce.applyTo(document.querySelectorAll(".phrasa"));
    // or with jQuery: bounce.applyTo($(".animation-target"));
</script>
<?php if(isset($articles)): ?>
    <?php foreach($articles as $article): ?>
        <?php echo app\components\CustomPagination::widget([
            'pagination' => $article['pages'],
            'cat' => $cat
        ]);
        ?>
        <div class="phrasa">

            <?php

            shuffle($article['contents']);

            foreach ($article['contents'] as $conts) : ?>

                    <p><?= nl2br($conts->body) ?><br>


            <?php endforeach; ?>


        </div>


    <?php endforeach; ?>

<?php endif; ?>
