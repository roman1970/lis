<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
    $(document).ready(function() {

        $('#income_name').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/income", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $("#income_go").click(
            function() {


                var income_name = $("#income_name").val();
                var income_value = $("#income_value").val();

                if (income_name == '') {alert('Введите название статьи!'); return;}
                if (income_value == '') {alert('Введите значение в рублях!'); return;}

                income(income_name, income_value, user);


            });

        $('#dish').focus(
            function () {
                $(this).select();
            })
        $('#measure').focus(
            function () {
                $(this).select();
            })


    });


    function income(name, value, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/incomes",
            data: "name="+name+"&value="+value+"&user="+user,
            success: function(html){
                $("#res").html(html);

            }

        });

    }
    

</script>

<style>
    .center, h3 {
        text-align: center;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
    }
    h3,h4{
        color: rgb(255, 215, 0);
    }


    .form-control {
        width: 100%;
    }

</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-income">
        <div class="form-group">
            <h3>Упало?</h3>
            <p>
                <input type="text" class="form-control" id="income_name"  placeholder="Выбрать статью прихода-расхода">
                <input type="text" class="form-control" id="income_value"  placeholder="рубли">

                <button type="button" class="btn btn-success" id="income_go" >Записать!</button>
            </p>
        </div>
    </form>
    <div id="res">
        <h4 class="center">Полезный баланс <?= round($bal_sum,2)?> Р</h4>

            <table class="table">
                <tbody>

                <?php $i=1; foreach ($incomes as $income) :  ?>

                    <tr>
                        <td>
                            <?= $i ?> <?= $income->income->name ?>
                        </td>


                        <td>
                            <?= round($income->sum, 2) ?>
                        </td>
                    </tr>

                    <?php $i++; endforeach; ?>


                </tbody>
            </table>

    </div>
