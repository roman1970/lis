<?php use yii\helpers\Url; ?>
<div class="container">
    <div class="content">
            <div class="uli">


                <?php if (!empty($articles)): ?>
                <div class="row">

                    <?php foreach ($articles as $article): ?>
                        <a href="<?=Url::to('knoledges/default/show/'.$article->id);?>">

                                <?=$article->title;?>

                        </a>
                    <?php endforeach; ?>

                </div>
            <?php else: ?>

                ...

            <?php endif; ?>
            </div>
        </div>
    </div>

