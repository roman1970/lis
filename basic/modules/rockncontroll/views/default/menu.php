<div class="alert alert-success">
    <p>Привет, <?= $user->name ?></p>
    <p id="current_task"></p>
</div>
<script>
    var user = <?= $user->id ?>;
    $(document).ready(function() {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/show-current-task/",
            data: "user="+user,
            success: function(html){
                $("#current_task").html(html);
            }

        });
       
        $("#show_menu").hide();

        $("#show_menu").click(
            function() {
                $("#menu").show();
                $("#show_menu").hide();
                $("#summary").hide();
            });

        $("#today_params").click(
            function() {
                send(user, 'day-params');
                $("#show_menu").show();
                $("#summary").show();
                $("#menu").hide();
            });

        $("#do_done").click(
            function() {
                send(user, 'deals');
                $("#show_menu").show();
                $("#summary").show();
                $("#menu").hide();
            });

        $("#mishich_do_done").click(
            function() {
                send(user, 'mishich-deals');
                $("#show_menu").show();
                $("#summary").show();
                $("#menu").hide();
            });

        $("#eat").click(
            function() {
                send(user,'eat');
                $("#summary").show();
                $("#menu").hide();
                $("#show_menu").show();
            });

        $("#task").click(
            function() {
                send(user, 'show-task');
                $("#summary").show();
                $("#menu").hide();
                $("#show_menu").show();
            });

        $("#bought").click(
            function() {
                send(user, 'bought');
                $("#summary").show();
                $("#menu").hide();
                $("#show_menu").show();
            });

        $("#add_product").click(
            function() {
                send(user, 'add-product');
                $("#summary").show();
                $("#menu").hide();
                $("#show_menu").show();
            });

        $("#repertoire").click(
            function() {
                send(user, 'repertoire');
                $("#show_menu").show();
                $("#summary").show();
                $("#menu").hide();
            });

        $("#rec_item").click(
            function() {
                send(user, 'record-item');
                $("#show_menu").show();
                $("#summary").show();
                $("#menu").hide();
            });

    });


    function send(user, controller_str) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/"+controller_str+"/",
            data: "user="+user,
            success: function(html){
                $("#summary").html(html);
            }

        });

    }



</script>

<div id="menu">
    <button type="button" class="btn btn-success btn-lg btn-block" id="today_params">Сегодня</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="eat">Съел</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="bought">Купил</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="add_product">Добавить товар</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="mishich_do_done">Оценить Мишича</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="do_done">Сделал</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="task">Задачи</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="rec_item">Записать</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="repertoire">Репертуар</button>
    
</div>
<div id="show_menu">
    <button type="button" class="btn btn-success btn-lg btn-block" >Меню</button>
</div>

