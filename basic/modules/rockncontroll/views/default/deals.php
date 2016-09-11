<script>

    $(document).ready(function() {

        var user = <?= (isset($user->id)) ? $user->id : 8 ?>;

        $('#done_deal').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/deals-list", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $('#deal_cat').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();

                $.getJSON("rockncontroll/default/deal-cats", function (data) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $("#add_deal").click(
            function() {

                var deal_name = $("#deal_name").val();
                var deal_mark = $("#deal_mark").val();
                var deal_cat = $("#deal_cat").val();

                if (deal_name == '') {alert('Введите название действия!'); return;}
                if (deal_mark == '') {alert('Введите оценку!'); return;}
                if (deal_cat == '') {alert('Введите категорию!'); return;}

                addDeal(deal_name, deal_mark, deal_cat, user);


            });

        $("#done_this").click(
            function() {

                var done_deal = $("#done_deal").val();
                var user = $("#user_deal").val();
                if (done_deal == '') {alert('Что сделано, то сделано!'); return;}

                doneDeal(done_deal, user);


            });

        $('#user_name').focus(
            function () {
                $(this).select();
            });
        $('#deal_mark').focus(
            function () {
                $(this).select();
            });
        $('#add_deal').focus(
            function () {
                $(this).select();
            });
        $('#deal_name').focus(
            function () {
                $(this).select();
            });

    });

    function addDeal(name, mark, cat, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/deals",
            data: "name="+name+"&mark="+mark+"&cat="+cat+"&user="+user,
            success: function(html){
                $("#sum_deals").html(html);

            }

        });

    }

    function doneDeal(deal, user){
        
            $.ajax({
                type: "GET",
                url: "rockncontroll/default/done-deal",
                data: "user="+user+"&deal="+deal,
                success: function(res){
                    $("#summary").html(res);
                }

            });
      
        return true;

    }

</script>

<style>
    .form-control{
        padding: 0;
        height: 33px;
        text-align: center;
        width: 50%;
    }


    table > tbody > tr > td{
        padding: 0;
        font-size: 20px;
    }

    h3, p, form {
        text-align: center;
    }

    @media (min-width:320px) and (max-width:767px) {
        table > tbody > tr > td{
            font-size: 14px;
            color: white;
        }
        .form-control{
            text-align: center;
            width: 100%;
        }

    }

</style>
<form class="form-inline center" role="form" id="form-deal">
    <div class="form-group" style="color: white; text-align: center" >
        <h3 >Новое действие</h3>

            <input type="text" class="form-control" id="deal_name"  placeholder="Назвать действие">
            <input type="text" class="form-control" id="deal_mark"  placeholder="Оценка">
            <input class="form-control" id="deal_cat"  placeholder="Категория">

            <button type="button" class="btn btn-success" id="add_deal" >Создать!</button>

    </div>
</form>


<div id="sum_deals">


    <?php  $i = 0; ?>

    <div class="view" style="color: white; text-align: center" ><h3>Ну дела!</h3>

        <form class="form-inline center" role="form" id="form-done-deal">
            <div class="form-group">

                <input type="text" class="form-control" id="done_deal"  placeholder="Действие">
                <input type="hidden" class="form-control" id="user_deal" value="<?= $user->id ?>">

                <button type="button" class="btn btn-success" id="done_this" >Сделал!</button>

            </div>
        </form>


            <h3><?= $user->name ?>, У тебя <?= $sum_mark ?> пузо!
                <?php if($user->id == 11) : ?> И <?= $money ?> руб денег <?php endif; ?></h3>
            <table class="table">
                <tbody>

                <?php  foreach ($deal_cats as $cat => $sum_mark) :  ?>

                    <tr>
                        <td>
                            <?= $cat ?>
                        </td>

                        <td>
                            ---------
                        </td>

                        <td>
                            <?= $sum_mark[0] ?> puso
                        </td>
                    </tr>

                <?php $i++; endforeach; ?>


                </tbody>
            </table>

        </div>

    </div>
