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

        $("#show_menu").show();
        $("#summary").show();
        $("#menu").hide();

    }



</script>

<div id="menu">
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'day-params')">Сегодня</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'show-task')">Задачи</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'mishich-deals')">Оценить Мишича</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'deals')">Сделал</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'events')">События</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'markers')">Закладки</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'eat')">Съел</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'bought')">Купил</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'add-product')">Добавить товар</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'record-item')">Записать</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'repertoire')">Репертуар</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'incomes')">Incomes</button>

</div>
<div id="show_menu">
    <button type="button" class="btn btn-success btn-lg btn-block" >Меню</button>
</div>

