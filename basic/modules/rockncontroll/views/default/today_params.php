<script>

       
    function recParam(param_id, i, user){

        var val = $("#val_"+i).val();

        //Валидация
        if (val  === "") {
            alert("Введите значение");
            return false;
        }

        if(confirm('Проверьте введёное значение. Возможности изменить не будет!')) {

                $.ajax({
                    type: "GET",
                    url: "rockncontroll/default/day-params",
                    data: "val="+val+"&user="+user+"&param_id="+param_id,
                    success: function(res){
                        $("#param_"+i).hide();
                        $("#val_"+i).hide();
                        $("#res_"+i).html(res);
                    }

                });
            }


        return true;

    }

</script>

<style>
    .form-control{
        padding: 0;
        height: 33px;
        text-align: center;
        width: 100%;
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

<div id="sum_tasks">
    <?php  $i = 0;
    if(count($params) > 1) : ?>

        <div class="view">

            <table class="table">
                <tbody>

                <?php foreach ($recorded_params as $value => $name) :  ?>

                    <tr>
                        <td>
                            <?= $name ?>

                        </td>

                        <td width="80">
                            <?= $value ?>
                           <p id="res_<?=$i?>"></p>

                        </td>


                    </tr>

                    <?php $i++; endforeach; ?>


                <?php foreach ($params as $param) :  ?>

                    <tr>
                        <td>
                            <?= $param->name ?>

                        </td>

                        <td width="80">
                            <input type='text' class="form-control" id="val_<?=$i ?>" placeholder="Значение" />
                            <button class="btn btn-success" id="param_<?=$i ?>" onclick="recParam(<?=$param->id?>, <?=$i?>, <?=$user?>)" >Записать!</button>
                            <p id="res_<?=$i?>"></p>

                        </td>


                    </tr>

                    <?php $i++; endforeach; ?>
                <?php endif; ?>


                </tbody>
            </table>

        </div>

    </div>
