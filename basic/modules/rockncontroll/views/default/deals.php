<script>

    $(document).ready(function() {

        $("#add_deal").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var deal_name = $("#deal_name").val();
                var deal_mark = $("#deal_mark").val();

                if (deal_name == '') {alert('Введите название действия!'); return;}
                if (deal_mark == '') {alert('Введите оценку!'); return;}

                addDeal(deal_name, deal_mark, user);


            });

        $('#user_name').focus(
            function () {
                $(this).select();
            });
        $('#deal_mark').focus(
            function () {
                $(this).select();
            });

    });

    function addDeal(name, mark, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/deals",
            data: "name="+name+"&mark="+mark+"&user="+user,
            success: function(html){
                $("#sum_tasks").html(html);

            }

        });

    }

    function doneDeal(deal_id, i, user){
        
            $.ajax({
                type: "GET",
                url: "rockncontroll/default/done-deal",
                data: "user="+user+"&deal_id="+deal_id,
                success: function(res){
                    $("#tasked_"+i).hide();
                    $("#mark_"+i).hide();
                    $("#res_"+i).html(res);
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
    .form-group{
        text-align: center;
    }

    #task_name, #task_description{
        width: 100%;
    }

    table > tbody > tr > td{
        padding: 0;
        font-size: 20px;
    }

    h3, p, #form-task{
        text-align: center;
    }

    @media (min-width:320px) and (max-width:767px) {
        table > tbody > tr > td{

            font-size: 14px;
            color: white;
        }
    }

</style>
<form class="form-inline center" role="form" id="form-deal">
    <div class="form-group">
        <h3>Новое действие</h3>

            <input type="text" class="form-control" id="deal_name"  placeholder="Назвать действие">
            <input type="text" class="form-control" id="deal_mark"  placeholder="Оценка">

            <button type="button" class="btn btn-success" id="add_deal" >Создать!</button>

    </div>
</form>
<div id="sum_tasks">
    <?php  $i = 0;
    if(count($deals) < 1) : ?>

    <div class="view" style="color: white; text-align: center" ><h3>Ничего не делал!</h3>
        <?php foreach ($all_deals as $item) :  ?>

            <tr>
                <td>
                    <?= $item->name ?>
                </td>

                <td>
                    <?= $item->mark ?>
                </td>

                <td>
                    <button class="btn btn-success" id="tasked_<?=$i ?>" onclick="doneDeal(<?=$item->id?>, <?=$i?>, <?=$user?>)" >Сделал!</button>
                    <p id="res_<?=$i?>"></p>
                </td>


            </tr>

            <?php $i++; endforeach; ?>

        <?php else : ?>

        <div class="view">

            <table class="table">
                <tbody>

                <?php foreach ($all_deals as $item) :  ?>

                    <tr>
                        <td>
                            <?= $item->name ?>
                        </td>

                        <td>
                            <?= $item->mark ?>
                        </td>

                        <td>
                            <button class="btn btn-success" id="tasked_<?=$i ?>" onclick="doneDeal(<?=$item->id?>, <?=$i?>, <?=$user?>)" >Сделал!</button>
                            <p id="res_<?=$i?>"></p>
                        </td>


                    </tr>

                    <?php $i++; endforeach; ?>


                <?php foreach ($deals as $item) :  ?>

                    <tr>
                        <td>
                            <?= $item->name ?>
                        </td>

                        <td>
                            <?= $item->mark ?>
                        </td>

                        <td>

                        </td>


                    </tr>

                    <?php $i++; endforeach; ?>
                <?php endif; ?>


                </tbody>
            </table>

        </div>

    </div>
