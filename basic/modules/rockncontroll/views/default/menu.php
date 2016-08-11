<script>
    $(document).ready(function() {
        var user = <?= (isset($user->id)) ? $user->id : 8 ?>;

        $("#eat").click(
            function() {
                eat(user);
            });

        $("#task").click(
            function() {
                task(user);
            });

    });


    function eat(user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/eat/",
            data: "user="+user,
            success: function(html){
                $("#summary").html(html);
            }

        });

    }

    function task(user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/show-task/",
            data: "user="+user,
            success: function(html){
                $("#summary").html(html);
            }

        });

    }

</script>

<div id="menu">
    <button type="button" class="btn btn-success btn-lg btn-block" id="eat">Съел</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="bought">Купил</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="done">Сделал</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="task">Задачи</button>
</div>

