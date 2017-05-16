<script>

    $(document).ready(function() {

        $("#add-product").click(
            function() {
                
                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var product_name = $("#product_name").val();
                var product_cat = $("#product_cat").val();

                if (product_name == '') {alert('Введите название товара!'); return;}
                if (product_cat == '') {alert('Введите категорию товара!'); return;}

                addProduct(product_name, product_cat, user);


            });

        $('#product_cat').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();

                $.getJSON("rockncontroll/default/cats", function (data) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $('#source_cat').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();

                $.getJSON("rockncontroll/default/all-cats", function (data) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $('#author_country').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();

                $.getJSON("rockncontroll/default/country", function (data) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $('#source_author').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();

                $.getJSON("rockncontroll/default/author", function (data) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $("#add-shop").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var shop_name = $("#shop_name").val();

                if (shop_name == '') {alert('Введите название магазина!'); return;}

                addShop(shop_name, user);


            });

        $("#add-author").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var author_name = $("#author_name").val();
                var author_country = $("#author_country").val();
                var author_status = $("#author_status").val();

                if (author_name == '') {alert('Введите имя автора!'); return;}
                if (author_country == '') {alert('Начните вводить страну!'); return;}
                if (author_status == '') {alert('Введите цифру статуса!'); return;}
                
                var params = "name="+author_name+"&country="+author_country+"&status="+author_status+"&user="+user;
                

                addInstance("add-author", params);


            });

        $("#add-source").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var source_title = $("#source_title").val();
                var source_author = $("#source_author").val();
                var source_cat = $("#source_cat").val();

                if (source_title == '') {alert('Введите название источника!'); return;}
                if (source_author == '') {alert('Начните вводить автора!'); return;}
                if (source_cat == '') {alert('Начните вводить категорию!'); return;}

                var params = "title="+source_title+"&author="+source_author+"&cat="+source_cat+"&user="+user;
                
                addInstance("add-source", params);
                
            });

        $('#product_name').focus(
            function () {
                $(this).select();
            });
        $('#product_cat').focus(
            function () {
                $(this).select();
            });
        $('#shop_name').focus(
            function () {
                $(this).select();
            });
        $('#source_title').focus(
            function () {
                $(this).select();
            });

    });

    function addProduct(name, cat, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/add-product",
            data: "name="+name+"&cat="+cat+"&user="+user,
            success: function(html){
                $("#res").html(html);

            }

        });

    }
    
    function addShop(name) {
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/add-shop",
            data: "name="+name+"&user="+user,
            success: function(html){
                $("#res").html(html);

            }

        });
    }
    
    function addInstance(action, params) {
        $.ajax({
            type: "GET",
            url: "rockncontroll/default/"+action,
            data: params,
            success: function(html){
                $("#res").html(html);

            }

        }); 
    }


</script>

<style>
    .form-control{
        padding: 0;
        height: 33px;
        text-align: center;

    }

    #res{
        text-align: center;
    }

   form{

        text-align: center;

    }

    table > tbody > tr > td{
        padding: 0;
        font-size: 20px;
    }

    h3, p, #form-task{
        text-align: center;
        color: white;
    }


</style>
<div id="res"></div>
<form class="form-inline center" role="form" id="form-add-product">
    <div class="form-group">
        <h3>Новый товар</h3>
        <p>
            <input type="text" class="form-control" id="product_name"  placeholder="Товар">
            <input class="form-control" id="product_cat"  placeholder="Категория">

            <button type="button" class="btn btn-success" id="add-product" >Добавить товар!</button>
        </p>
    </div>
</form>
<form class="form-inline center" role="form" id="form-add-shop">
    <div class="form-group">
        <h3>Новый магазин</h3>
        <p>
            <input type="text" class="form-control" id="shop_name"  placeholder="Магазин">

            <button type="button" class="btn btn-success" id="add-shop" >Добавить магазин!</button>
        </p>
    </div>
</form>
<form class="form-inline center" role="form" id="form-add-author">
    <div class="form-group">
        <h3>Новый автор</h3>
        <p>
            <input type="text" class="form-control" id="author_name"  placeholder="Автор">
            <input class="form-control" id="author_country"  placeholder="Страна">
            <input class="form-control" id="author_status"  placeholder="1 - музыка, 2 - книга, 3 - музнецензур">

            <button type="button" class="btn btn-success" id="add-author" >Добавить автора!</button>
        </p>
    </div>
</form>
<form class="form-inline center" role="form" id="form-add-source">
    <div class="form-group">
        <h3>Новый источник</h3>
        <p>
            <input type="text" class="form-control" id="source_title"  placeholder="Источник">
            <input class="form-control" id="source_author"  placeholder="Автор">
            <input class="form-control" id="source_cat"  placeholder="Категория">

            <button type="button" class="btn btn-success" id="add-source" >Добавить источник!</button>
        </p>
    </div>
</form>
