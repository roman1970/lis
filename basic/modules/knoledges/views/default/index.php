<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

    <div class="content">
            <div class="uli">

                <div class="theme_title">
                    <h1>Великие противостояния</h1>
                </div>
              
                <?php
                if(__DIR__ == '/home/romanych/public_html/plis/basic/modules/knoledges/views/default'):
                    $form = ActiveForm::begin(); ?>
                    <?= $form->field($uploadFile, 'file')->fileInput() ?>
                    <?= \yii\helpers\Html::button('Отправить', ['class' => 'btn btn-primary', 'id' => 'send']);?>
                    <?php ActiveForm::end();
                    endif;
                ?>



                <?php if (!empty($articles)): ?>
                <div class="row">

                    <?php foreach ($articles as $article): ?>
                        <div class="article col-md-3 col-sm-4 col-xs-4">
                            <a href="<?='knoledges/default/show/'.$article->id;?>">

                                <p class="article_title"><?=$article->title;?></p> </br>
                                <?php if($article->img) : ?>
                                    <img src="<?=Url::to($article->img)?>" class="team-photo" />
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

