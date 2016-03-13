<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\widgets\Pjax;

$article_content_id = 1;
?>

<script>
    $(document).ready(function() {
        var name = $("#comm_name");
        var body = $("#comm_body");
        var content_id = $("#comm_cont");
        var name_string = '';
        var n = '';
        var ball = 0;
        if($.cookie('ball')) ball = $.cookie('ball');
        else ball = 0;

        var date = new Date();
        $.cookie.raw = true;


        $("#send").click(
            function() {

                 n = $.cookie('name');
                if(n !== '') alert("Вы " + n);

                addComment(name.val(), body.val(), content_id.val());
                sleep(2000);
                name_string = name.val();
                alert(ball.toString());
                $("#comments").load("/knoledges/default/callcomm/"+content_id.val());
                $('#w0').trigger( 'reset' ); //очищаем форму
                $.cookie('name', name_string, { expires: 7 });
                $.cookie('ball', ball.toString(), { expires: 7 });
                //setCookie('name', name_string, { expires: 7 });

            });

        function addComment(name, body, content) {

            //Валидация
            if (name === "" ) {
                alert("Введите Имя");
                return false;
            }

            if (body === "") {
                alert("Введите Текст");
                return false;
            }


            $.ajax({
                type: "GET",
                url: "/knoledges/default/addcomment/",
                data: "name="+name+"&body="+body+"&content_id="+content,
                success: function(html){
                    $("#base").html(html);
                }

            });

        }
        /*Симуляция сна*/
        function sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds){
                    break;
                }
            }
        }

        function setCookie(name, value, options) {
            options = options || {};

            var expires = options.expires;

            if (typeof expires == "number" && expires) {
                var d = new Date();
                d.setTime(d.getTime() + expires * 1000);
                expires = options.expires = d;
            }
            if (expires && expires.toUTCString) {
                options.expires = expires.toUTCString();
            }

            value = encodeURIComponent(value);

            var updatedCookie = name + "=" + value;

            for (var propName in options) {
                updatedCookie += "; " + propName;
                var propValue = options[propName];
                if (propValue !== true) {
                    updatedCookie += "=" + propValue;
                }
            }

            document.cookie = updatedCookie;
        }

    });


</script>
<div class="single">

		<div class="mb20">
           <span class="day"> <?= $title ?></span>  <div class="source"> <?= $author ?> - <?= $source ?> </div>
		</div>

	<h1 class="single__title index-tit mt0 mb10 rbt-c upper">

		<span><?php foreach ($contents as $article) :
                $article_content_id = $article->id; ?>
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
<aside>
    <?php /*DatePicker::widget(['name' => 'date']) */ ?>
    <div id="comments">

    <?= \app\components\CommentsWidget::widget(['article_id' => $article_content_id,
        'module_path' => \Yii::$app->view->theme->baseUrl]) ?>

    </div>
    <?php /*
    <input type='text' class="aer" id="comm_name" size="30" placeholder="10"/>
    <textarea rows="10" cols="45" name="text" id="comm_body"></textarea>
    <button class="btn btn-primary" id="send" value="Комментировать"></button>

    */
    ?>
    <div id="base"></div>
    <?php

    $form = ActiveForm::begin(); ?>
        <?= $form->field($comment, 'name')->textInput(['size' => 45, 'id' => 'comm_name']); ?>
        <?= $form->field($comment, 'body')->textarea(['rows' => 10, 'cols' => 45, 'id' => 'comm_body']) ?>
        <?= $form->field($comment, 'article_content_id')->textInput([ 'id' => 'comm_cont', 'type' => 'hidden', 'value' => $article_content_id])->label(false); ?>

        <?= \yii\helpers\Html::button('Комментировать', ['class' => 'btn btn-primary', 'id' => 'send']);?>
    <?php ActiveForm::end();?>


</aside>
