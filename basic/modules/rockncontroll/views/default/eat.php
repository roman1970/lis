<script>
    var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
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

    function delAte(ate_id, i, user){
        
        confirm("Вы действительно хотите удалить запись?");

            $.ajax({
                type: "GET",
                url: "rockncontroll/default/delete-ate",
                data: "user="+user+"&ate_id="+ate_id,
                success: function(res){
                    $("#del_"+i).hide();
                    $("#res_"+i).html(res);
                }

            });

        return true;

    }
    
    
</script>

<style>
    .center, h3, table > tbody > tr > td{
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
            <?php endif; ?>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>м</td>
                            <td>блюдо</td>
                            <td>кол-во</td>
                            <td>ккал</td>
                            <td>не съел</td>
                        </tr>


                <?php $i=0; foreach ($ate_today as $item) : $i++;  ?>
                    <tr >
                        <td><?= $i ?></td>
                        <td> <?= $item->dish->name ?></td>
                        <td> <?= $item->measure ?></td>
                        <td> <?= $item->kkal ?></td>
                        <td>
                            <button class="btn btn-success" id="del_<?=$i ?>" onclick="delAte(<?=$item->id?>, <?=$i?>, <?=$user->id?>)" ><span class="glyphicon glyphicon-fire" id="del_<?=$i ?>"></span></button>
                            <p id="res_<?=$i?>"></p>

                        </td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>

        </div>

</div> 