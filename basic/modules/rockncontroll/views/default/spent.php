<script>

    $( function() {
        $("#datepicker").datepicker({
            altFormat: "yy-mm-dd"
        });
    } );

    $(document).ready(function() {

        $('#request').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/shops-products-cats", function (data) {

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

        $("#get_date_spent").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;

                var stringyDate = $("#datepicker").val(); // mm/dd/yyyy
                var dateyDate = new Date(stringyDate);

                var ms = dateyDate.valueOf();
                var s = ms / 1000;
                
                get_date_spent(s);
                
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

    function get_date_spent(secs) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/spent",
            data: "user="+user+"&secs="+secs,
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

    <form class="form-inline center" role="form" id="form-date">
        <div class="form-group">
            <h3>Дата</h3>
            <p>
                <input type="text" class="form-control" id="datepicker" placeholder="Выбрать дату"><br>

                <button type="button" class="btn btn-success" id="get_date_spent" >Получить!</button>
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

        <h3>Категории</h3>

        <table class="table">
            <tbody>
            <tr >
                <td>м</td>
                <td>категория</td>

                <td>сумма</td>
            </tr>
            <?php $i=0;   foreach ($prod_boughts as $cat => $sum) : $i++;  ?>
                <?php if($i > 30) : exit; ?>
                    <?php endif; ?>
                <tr >
                    <td><?= $i ?></td>
                    <td><?= $cat ?></td>

                    <td><?= round($sum, 2) ?></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>


    </div>

</div>