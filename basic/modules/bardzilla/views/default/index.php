<div id="wrapper" >
    <div id="nav" class="row">

        <?php foreach($cats as $cat) : ?>


            <div class="col-md-2 col-sm-12 col-xs-12 col-lg-2" >



            <?php $items = \app\models\Categories::findOne(['name' => $cat->name]);
            $leaves = $items->leaves()->all();
            if($leaves) : ?>
                    <div id="<?=$cat->cssclass?>" class="root" ><a href="#"><b><?=$cat->title?></b></a>

                    <div class="inside">
                    <?php foreach ($leaves as $leave) : ?>
                        <p id="<?=$leave->cssclass?>" class="drop" onclick="getContent('<?=$leave->cssclass?>',  <?=$leave->id?>)"><a href="#"><b><?=$leave->title?></b></a> </p>

                    <?php endforeach; ?>
                    </div>
            <?php else : ?>

                <div id="<?=$cat->cssclass?>" class="root" onclick="getContent('<?=$cat->cssclass?>', <?=$cat->id?>)" ><a href="#"><b><?=$cat->title?></b></a>

            <?php endif; ?>
                </div>


            </div>


    <?php endforeach; ?>

    </div>
    </div>
    </div>