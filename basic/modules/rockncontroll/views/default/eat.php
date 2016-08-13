<script>
    $(document).ready(function() {

        $('#dish').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                console.log(term);
                $.getJSON("rockncontroll/default/dishes", function (data) {

                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

        $("#ate").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var dish = $("#dish").val();
                var measure = $("#measure").val();
                
                if (dish == '') {alert('Введите название блюда!'); return;}
                if (measure == '') {alert('Введите название блюда!'); return;}
                
                ate(dish, measure, user);

               
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
    
    
   function ate(dish, measure, user) {

       $.ajax({
           type: "GET",
           url: "rockncontroll/default/eat",
           data: "dish="+dish+"&measure="+measure+"&user="+user,
           success: function(html){
               $("#sum_ate").html(html);

           }

       });

   } 
    
    
</script>

<style>
    .center, h3, table > tbody > tr > td{
        text-align: center;
    }
</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">
            <h3>Что съел?</h3>
            <p>
                <input type="text" class="form-control" id="dish"  placeholder="Выбрать блюдо">
                <input type="text" class="form-control" id="measure"  placeholder="Съеденное в граммах">
               
                <button type="button" class="btn btn-success" id="ate" >Съел!</button>
            </p>
        </div>
    </form>
        <div id="sum_ate">

            <?php if($sum_kkal >= 2000 ) :  ?>
                <h3 style="color: red">Сегодня съел <?= $sum_kkal ?> kkal</h3>
            <?php elseif($sum_kkal < 2000) : ?>
                <h3>Сегодня съел <?= $sum_kkal ?> kkal</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>м</td>
                            <td>блюдо</td>
                            <td>количество</td>
                            <td>калорийность</td>
                        </tr>

            <?php endif; ?>
                <?php $i=0; foreach ($ate_today as $item) : $i++;  ?>
                    <tr >
                        <td><?= $i ?></td>
                        <td> <?= $item->dish->name ?></td>
                        <td> <?= $item->measure ?></td>
                        <td> <?= $item->kkal ?></td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>

        </div>

</div> 