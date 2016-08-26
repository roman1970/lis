<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    var source_id = <?= (isset($source->id)) ? $source->id : 1 ?>;
    $(document).ready(function() {

        $("#new_marker").click(
            function() {

                var mark = $("#mark").val();

                if (mark == '') {alert('Введите текст закладки!'); return;}

                new_mark(mark, source_id, user);

            });

        $('#new_marker').focus(
            function () {
                $(this).select();
            })

    });


    function new_mark(mark, id, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/markers",
            data: "mark="+mark+"&id="+id+"&user="+user,
            success: function(html){
                $("#summary").html(html);

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

    h3, h4{
        color: rgb(255, 215, 0);
    }

    .marker{
        color: rgb(255, 215, 0);
        font-size: 15px;
    }

    .form-control {
        width: 100%;
    }


</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-event">
        <div class="form-group">
            <h3>Читаем:</h3>
            <h4><?= $source->author->name ?></h4>
            <h4><?= $source->title ?></h4>
            <p class="marker"><?= $source->marker ?></p>

            <h3>Закладка:</h3>
            <p>
                <input type="text" class="form-control" id="mark" value="<?= $source->marker ?>" >
                <br>
                <button type="button" class="btn btn-success" id="new_marker" >Новая закладка!</button>
            </p>
            <div id="res"></div>
        </div>
    </form>

</div>