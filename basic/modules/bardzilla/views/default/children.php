<div id="nav" class="row">

    <?php foreach($cats as $cat) : ?>

        <div class="col-md-2 col-sm-6 col-xs-12">
            <p id="<?=$cat->cssclass?>"><a href="#"><b><?=$cat->title?></b></a> </p>
        </div>

    <?php endforeach; ?>

</div>