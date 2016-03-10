<?php use yii\helpers\Url; ?>

    <div class="content">
            <div class="uli">


                <?php if (!empty($articles)): ?>
                <div class="row">

                    <?php foreach ($articles as $article): ?>
                        <div class="article col-md-3 col-sm-3 col-xs-3">
                            <a href="<?='knoledges/default/show/'.$article->id;?>">

                                <?=$article->title;?> </br>
                                <?php if($article->img) : ?>
                                    <img src="<?=Url::to($article->img)?>" />
                                <?php endif; ?>

                            </a>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php else : ?>

                ...

            <?php endif; ?>
            </div>
        </div>

