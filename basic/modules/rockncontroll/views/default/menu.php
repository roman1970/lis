<style>
    #current_task{
        height: 100px;
        overflow: auto;
    }
</style>
<script>
   
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/remind/",
            success: function(html){
                $("#note_remind").html(html);
            }

        });

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/get-currency/",
            success: function(html){
                $("#curr").html(html);
            }

        });


</script>
<div class="alert alert-success">
    <p><span id="curr"></span>Привет, <?= $user->name ?> ! <span id="note_remind"></span></p>
    <p id="current_task"></p>
</div>
<div class="alert alert-success" ><p id="stop_item_block"></p></div>
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
        $("#stop_item_block").parent().hide();

        $("#show_menu").click(
            function() {
                $("#menu").show();
                $("#show_menu").hide();
                $("#summary").hide();
            });


    });


    function send(user, controller_str, test = 0) {

        if(test) {
            $.ajax({
                type: "GET",
                url: "rockncontroll/test/"+controller_str+"/",
                data: "user="+user,
                success: function(html){
                    $("#summary").html(html);
                }

            });
        }

        else {
            $.ajax({
                type: "GET",
                url: "rockncontroll/default/"+controller_str+"/",
                data: "user="+user,
                success: function(html){
                    $("#summary").html(html);
                }

            });
        }


        $("#show_menu").show();
        $("#summary").show();
        $("#menu").hide();

    }
    
    function learned(user=8) {
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/learned/",
            data: "user="+user,
            success: function(){
                $("#request_learned").clean();
                $("#menu").show();
            }

        });
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
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'spent')">Расходы</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'record-item')">Записать</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'repertoire')">Репертуар</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'incomes')">Incomes</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'weather')">Погода</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'klavaro', 1)">Klavaro</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'search')">Найти</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'article-search')">Найти статьи</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'rec-remind')">Напомнить</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'telephone')">Телефон</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'logs')">Логи nginx</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'music')">Музыка</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'concert')">Концерт</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'graf')">Графики</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'football')">Футбол 2016-2018</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'radio')">Радио</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'remember')">Запомнить</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'project')">Проект</button>
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="send(user,'news')">Новости</button>
</div>

<div id="show_menu">
    <button type="button" class="btn btn-success btn-lg btn-block" >Меню</button>
</div>



