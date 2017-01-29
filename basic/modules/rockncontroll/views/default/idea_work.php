<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    var idea_id = <?= $idea->id ?>;
    $(document).ready(function() {
    $("#rec_event").click(
        function() {

            var txt = $("#text_edited").val();

            edit(txt, user, idea_id);

        });


    });

    function edit(txt, user, id) {
        //console.log(txt);

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/project",
            data: "edited=" + txt + "&user=" + user + "&id=" + id,
            success: function (html) {
                $("#res").html(html);

            }

        });
    }



</script>
<style>
    .center, h3, table > tbody > tr > td{
        text-align: center;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
    }
    h3, h5, p{
        color: rgb(255, 215, 0);
    }

    .block{
        border: 4px groove rgb(255, 215, 0);
        /*background: rgba(19, 19, 38, 0.94);  */
        margin-bottom: 10px;
        border-radius: 5px;
        width: 100%;
        color: rgb(0, 0, 0);
    }

    .title{
        color: white;
    }

    .form-control {
        width: 100%;
    }


</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-event">
        <div class="form-group">
            <h3>Редактировать идею </h3>
            <h3 class="title"><?=$idea->title?></h3>
            <?php if($bound_items[0]) : ?>
                <h4>Привязанные айтемы</h4>
            <?php endif; ?>
            <?php foreach($bound_items as $item_id) : ?>
                <?php if((int)$item_id) : ?>
                    <div class="block">
                        <h5><?=\app\models\Items::findOne($item_id)->title ?></h5>
                        <p>(<?=\app\models\Items::findOne($item_id)->source->title ?> - <?=\app\models\Items::findOne($item_id)->source->author->name ?>)</p>
                        <p><?=\app\models\Items::findOne($item_id)->text ?></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <p>
                <textarea class="block" id="text_edited" rows="10" cols="45"><?=$idea->text?></textarea>
                <br>
                <button type="button" class="btn btn-success" id="rec_event" >Записать!</button>
            </p>
            <div id="res"></div>


        </div>
    </form>

</div>
