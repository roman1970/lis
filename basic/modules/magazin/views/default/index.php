<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <div class="jumbotron">
                <h1>Добро пожаловать в маш магазин!</h1>
                <p></p>
            </div>
            <div class="row">

                <?php foreach ($products as $product) :?>
                <div class="col-6 col-sm-6 col-lg-4">
                    <h2><?= $product->name ?></h2>
                    <img src="<?=\yii\helpers\Url::to($product->photo)?>" class="prod-photo" />
                    <p><?= $product->description ?></p>
                    <p><?= $product->price ?></p>
                    <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                </div><!--/span-->
                <?php endforeach; ?>

            </div><!--/row-->
        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="list-group">
                <a href="#" class="list-group-item active">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>

            </div>
        </div><!--/span-->
    </div><!--/row-->

    <hr>

</div>
