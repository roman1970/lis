<script>
    $(document).ready(function() {

        var au = document.getElementById('au');
        au.src = 'http://37.192.182.101:10088/ices';

        au.onerror = function() {
            window.location = '/krokodile/default/noradio/';
        };

        var name = $("#comm_name");
        var body = $("#comm_body");
        var content_id = $("#comm_cont");
        var name_string = '';
        var n = '';


        var date = new Date();
        $.cookie.raw = true;


        $("#send").click(
            function() {
                if($.cookie('name')) name_string = $.cookie('name');
                else name_string = name.val();

                addComment(name_string, body.val());
                sleep(2000);

                $("#comments").load("/krokodile/default/callcomm/");
                $('#w0').trigger( 'reset' ); //очищаем форму
                $.cookie('name', name_string, { expires: 7 });

                //setCookie('name', name_string, { expires: 7 });

            });

    });

    
</script>

<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <div class="jumbotron">
                <h1>Hello, world!</h1>

                <audio id="au" autoplay >
                </audio>
            </div>
            <div class="row">
                <div class="col-6 col-sm-6 col-lg-4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                </div><!--/span-->
                <div class="col-6 col-sm-6 col-lg-4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                </div><!--/span-->
                <div class="col-6 col-sm-6 col-lg-4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                </div><!--/span-->
                <div class="col-6 col-sm-6 col-lg-4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                </div><!--/span-->
                <div class="col-6 col-sm-6 col-lg-4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                </div><!--/span-->
                <div class="col-6 col-sm-6 col-lg-4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                </div><!--/span-->
            </div><!--/row-->
        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div id="comments">

                <?= \app\components\RadioCommentsWidget::widget([
                    'module_path' => \Yii::$app->view->theme->baseUrl]) ?>

                <div id="base"></div>
                <?php

                $form = \yii\widgets\ActiveForm::begin(); ?>
                <?= $form->field($comment, 'name')->textInput(['size' => 45, 'id' => 'comm_name']); ?>
                <?= $form->field($comment, 'body')->textarea(['rows' => 10, 'cols' => 45, 'id' => 'comm_body']) ?>

                <?= \yii\helpers\Html::button('Комментировать', ['class' => 'btn btn-primary', 'id' => 'send']);?>
                <?php \yii\widgets\ActiveForm::end();?>

            </div>
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


<?php
echo "ok, Krok";