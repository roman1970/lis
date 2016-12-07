<script>
    $(document).ready(function() {


        var name = $("#comm_name");
        var body = $("#comm_body");

        var name_string = '';
        var n = '';


        $("#send_claim").click(
            function() {
                name_string = name.val();

                addComment(name_string, body.val());
                sleep(2000);

                $("#comments").load("/krokodile/default/callcomm/");
                $('#w0').trigger( 'reset' ); //очищаем форму

                //setCookie('name', name_string, { expires: 7 });

            });

    });


</script>
<div class="container">

    <?php
    foreach ($texts as $text){
        echo "<a href='".$text->link."'>".$text->title."</a>";
    }

    $form = \yii\widgets\ActiveForm::begin(); ?>
    <?= $form->field($comment, 'name')->textInput(['size' => 45, 'id' => 'comm_name']); ?>
    <?= $form->field($comment, 'body')->textarea(['rows' => 10, 'cols' => 45, 'id' => 'comm_body']) ?>

    <?= \yii\helpers\Html::button('Комментировать', ['class' => 'btn btn-primary', 'id' => 'send']);?>
    <?php \yii\widgets\ActiveForm::end();?>

</div>
