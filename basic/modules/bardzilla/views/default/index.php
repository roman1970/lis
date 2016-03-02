<div id="wrapper_menu" class="container">
    <div id="logo">


        <div id="phot_h">
            Бард, который перевернул ЗИЛ и его друзья
            <?php /* <img src="<?=$this->theme->getUrl('Img/teatr_nov_1.png')" alt="Бард, который перевернул ЗИЛ" width="1100" height="100" /> */?>
        </div>

        <div id="phrase"></div>



    </div>
    <div id="nav" class="row">

        <?php foreach($cats as $cat) : ?>


            <div class="col-md-2 col-sm-12 col-xs-12 col-lg-2" >

            <?php $items = \app\models\Categories::findOne(['name' => $cat->name]);
            $leaves = $items->leaves()->all();
            if($leaves) : ?>
                    <div id="<?=$cat->cssclass?>" class="root" ><a href="#"><b><?=$cat->title?></b></a>

                    <div class="inside">
                    <?php foreach ($leaves as $leave) : ?>
                        <p id="<?=$leave->cssclass?>" class="drop" onmouseup="getContent('<?=$leave->cssclass?>',  <?=$leave->id?>)"><a><b><?=$leave->title?></b></a> </p>

                    <?php endforeach; ?>
                    </div>
            <?php else : ?>

                <div id="<?=$cat->cssclass?>" class="root" onmouseup="getContent('<?=$cat->cssclass?>', <?=$cat->id?>)" ><a><b><?=$cat->title?></b></a>

            <?php endif; ?>
                </div>


            </div>


    <?php endforeach; ?>


    </div>
</div>

<?php /*
<div id="player_first" class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" >
        <p>

        <a href="<?= $article->audio ?>" target="_blank"><?php echo " --- " . $article->minititle ?> </a>

        <audio controls="controls" autoplay="autoplay">

        <source src='<?=$article->audio?>' type='audio/mpeg'>
        </audio>
        </p>
    </div>
</div>
*/ ?>