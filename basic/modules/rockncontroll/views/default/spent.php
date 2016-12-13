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

        $("#get_spent").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var request = $("#request").val();

                if (request == '') {
                    alert('Введите магазин, категорию или товар!');
                    return;
                }


                get_spent(user, request);


            });

        $('#request').focus(
            function () {
                $(this).select();
            })


    });


    function get_spent(user, request) {


        $.ajax({
            type: "GET",
            url: "rockncontroll/default/spent",
            data: "user="+user+"&request="+request,
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
            <h3>Расходы</h3>
            <p>

                <input type="text" class="form-control" id="request"  placeholder="Магазин, товар или категория"><br>

                <button type="button" class="btn btn-success" id="get_spent" >Получить!</button>
            </p>
        </div>
    </form>
    <div id="sum_bought">

        <h3>Товары</h3>

        <table class="table">
            <tbody>
            <tr >
                <td>м</td>
                <td>товар</td>

                <td>сумма</td>
            </tr>
            <?php $i=0; foreach ($spents as $spent) : $i++;  ?>
                <tr >
                    <td><?= $i ?></td>
                    <td><?= $spent->product->name ?></td>

                    <td><?= round($spent->sum, 2) ?></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

        <h3>Магазины</h3>

        <table class="table">
            <tbody>
            <tr >
                <td>м</td>
                <td>товар</td>

                <td>сумма</td>
            </tr>
            <?php $i=0; foreach ($shop_spents as $spent) : $i++;  ?>
                <tr >
                    <td><?= $i ?></td>
                    <td><?= $spent->shop->name ?></td>

                    <td><?= round($spent->sum, 2) ?></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>


    </div>

</div>