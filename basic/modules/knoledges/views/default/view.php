<?php use yii\helpers\Url; ?>
<div class="single">

		<div class="mb20">
           <span class="day"> <?= $title ?></span>  <div class="source"> <?= $author ?> - <?= $source ?> </div>
		</div>

	<h1 class="single__title index-tit mt0 mb10 rbt-c upper">

		<span><?php foreach ($contents as $article) : ?>
           <?= app\components\KnoledgesPagination::widget([
                'pagination' => $pages,
            ]);
            ?>

               <div class="blue"> <?= $article->minititle ?> </div>
                  <?php if($article->audio) : ?>
                    <audio controls="controls" class="audio">
                        <source src='<?=Url::to($article->audio)?>' type='audio/mpeg'>
                    </audio>
                <?php endif; ?>

                <?= $article->body ?>


            <?= app\components\KnoledgesPagination::widget([
                'pagination' => $pages,
            ]);
            ?>
            <?php endforeach; ?>
        </span>
	</h1>

		</div>
