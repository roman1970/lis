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
            url: "rockncontroll/default/events",
            data: "mark="+mark+"&id="+id+"&user="+user,
            success: function(html){
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
    h3{
        color: rgb(255, 215, 0);
    }


    .form-control {
        width: 100%;
    }


</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-event">
        <div class="form-group">
            <h3>Добавить событие?</h3>
            <p>
                <input type="text" class="form-control" id="mark"  placeholder="Строка закладки">
                <br>
                <button type="button" class="btn btn-success" id="new_marker" >Новая закладка!</button>
            </p>
            <div id="res"></div>
        </div>
    </form>

</div>