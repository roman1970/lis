<?php

//if(!empty($article->articlesContentsCount)){
//	$title .= CHtml::tag('span', array(), "($article->articlesContentsCount ФОТО)");
//}

?>

<div class="single">

		<div class="mb20">
           <span class="day">День <?= $title ?></span>  <div class="source"> <?= $author ?> - <?= $source ?> </div>
		</div>

	<h1 class="single__title index-tit mt0 mb10 rbt-c upper">

		<span><?php foreach ($contents as $article) : ?>
           <?= app\components\KnoledgesPagination::widget([
                'pagination' => $pages,
            ]);
            ?>

               <div class="blue"> <?= $article->minititle ?> </div>


                <?= $article->body ?>

            <?= app\components\KnoledgesPagination::widget([
                'pagination' => $pages,
            ]);
            ?>
            <?php endforeach; ?>

	</h1>

		</div>
