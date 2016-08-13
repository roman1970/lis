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

        $('#product_name').focus(
            function () {
                $(this).select();
            });
        $('#product_cat').focus(
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
    }


</style>
<form class="form-inline center" role="form" id="form-add-product">
    <div class="form-group">
        <h3>Новый товар</h3>
        <p>
            <input type="text" class="form-control" id="product_name"  placeholder="Товар">
            <input class="form-control" id="product_cat"  placeholder="Категория">

            <button type="button" class="btn btn-success" id="add-product" >Добавить!</button>
        </p>
    </div>
</form>
<div id="res"></div>