<script>
    $(document).ready(function() {

        $('#product').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/products", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $('#shop').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/shops", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $("#bye").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var item = $("#item").val();
                var measure = $("#measure").val();
                var product = $("#product").val();
                var shop = $("#shop").val();

                if (item == '') item = 0;
                
                if (measure == '') {
                    alert('Введите потраченные рубли!'); 
                    return;
                }

                if (product == '') {
                    alert('Выберите название купленного товара!');
                    return;
                }

                if (shop == '') {
                    alert('Введите название магазина!');
                    return;
                }

                make_bye(product, measure, user, item, shop);


            });

        $('#product').focus(
            function () {
                $(this).select();
            })
        $('#measure').focus(
            function () {
                $(this).select();
            })
        $('#item').focus(
            function () {
                $(this).select();
            })
        $('#shop').focus(
            function () {
                $(this).select();
            })



    });


    function make_bye(product, measure, user, item, shop) {


        $.ajax({
            type: "GET",
            url: "rockncontroll/default/bought",
            data: "product="+product+"&measure="+measure+"&user="+user+"&shop="+shop+"&item="+item,
            success: function(html){
                $("#sum_bought").html(html);

            }

        });

    }


</script>

<style>
    .center, h3{
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
    .glyphicon {
        color: gold !important;
    }
</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">
            <h3>Что купил?</h3>
            <p>
                <input type="text" class="form-control" id="product"  placeholder="Выбрать товар"><br>
                <input type="text" class="form-control" id="measure"  placeholder="Потраченные деньги"><br>
                <input type="text" class="form-control" id="item"  placeholder="Цена за шт или кг"><br>
                <input type="text" class="form-control" id="shop"  placeholder="Магазин"><br>

                <button type="button" class="btn btn-success" id="bye" >Купил!</button>
            </p>
        </div>
    </form>
    <div id="sum_bought">

        <h3>Сегодня купил на <?= round($sum_spent, 2) ?> руб</h3>

        <table class="table">
            <tbody>
            <tr >
                <td>м</td>
                <td>товар</td>
                <td>стоимость</td>
                <td>магаз</td>
            </tr>
            <?php $i=0; foreach ($bought_today as $item) : $i++;  ?>
                <tr >
                    <td><?= $i ?></td>
                    <td> <?= $item->product->name ?></td>
                    <td> <?= round($item->spent, 2) ?></td>
                    <td> <?= $item->shop->name ?></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>


    </div>

</div> 