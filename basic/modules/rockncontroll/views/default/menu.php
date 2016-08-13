<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {

        $("#show_menu").hide();

        $("#show_menu").click(
            function() {
                $("#menu").show();
                $("#show_menu").hide();
                $("#summary").hide();
            });

        $("#eat").click(
            function() {
                eat(user);
                $("#summary").show();
                $("#menu").hide();
                $("#show_menu").show();
            });

        $("#task").click(
            function() {
                task(user);
                $("#summary").show();
                $("#menu").hide();
                $("#show_menu").show();
            });

        $("#bought").click(
            function() {
               
                bought(user);
                $("#summary").show();
                $("#menu").hide();
                $("#show_menu").show();
            });

        $("#add_product").click(
            function() {
                add_product(user);
                $("#summary").show();
                $("#menu").hide();
                $("#show_menu").show();
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

    function bought(user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/bought/",
            data: "user=" + user,
            success: function (html) {
                $("#summary").html(html);
            }

        });
    }

    function add_product(user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/add-product/",
            data: "user=" + user,
            success: function (html) {
                $("#summary").html(html);
            }

        });
    }


</script>

<div id="menu">
    <button type="button" class="btn btn-success btn-lg btn-block" id="eat">Съел</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="bought">Купил</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="add_product">Добавить товар</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="done">Сделал</button>
    <button type="button" class="btn btn-success btn-lg btn-block" id="task">Задачи</button>
    
</div>
<div id="show_menu">
    <button type="button" class="btn btn-success btn-lg btn-block" >Меню</button>
</div>

