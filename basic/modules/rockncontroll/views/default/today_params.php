<script>

    $(document).ready(function() {
        $('#calculate').focus(
            function () {
                $(this).select();
            });
        
        $("#do_calc").click(
            function() {

                var calculate = $("#calculate").val();
                if (calculate == '') {alert('Нечего считать!'); return;}
                var calc = new Calculator;

                document.getElementById('calculate').value = calc.calculate(calculate);
                $('#calculate').focus(
                    function () {
                        $(this).select();
                    });


                //alert(result);

            });
    });
       
    function recParam(param_id, i, user){

        var val = $("#val_"+i).val();

        //Валидация
        if (val  === "") {
            alert("Введите значение");
            return false;
        }
        
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
       
        return true;

    }

    function changeParam(param_id, i, user){

        var val = $("#rec_val_"+i).val();

        //Валидация
        if (val  === "") {
            alert("Введите значение");
            return false;
        }
        

            $.ajax({
                type: "GET",
                url: "rockncontroll/default/change-param",
                data: "val="+val+"&user="+user+"&param_id="+param_id,
                success: function(res){
                    $("#summary").html(res);
                }

            });
       

        return true;

    }


    function Calculator() {

        var methods = {
            "-": function(a, b) {
                return a - b;
            },
            "+": function(a, b) {
                return a + b;
            },
            "*": function(a, b) {
                return a * b;
            },
            "/": function(a, b) {
                return a / b;
            },
            "**": function(a, b) {
                return Math.pow(a, b);
            }
        };

        this.calculate = function(str) {

            var split = str.split(' '),
                a = +split[0],
                op = split[1],
                b = +split[2];

            if (!methods[op] || isNaN(a) || isNaN(b)) {
                return 'Делайте пробел между цифрами и действием';
            }

            return methods[op](+a, +b);
        };

        this.addMethod = function(name, func) {
            methods[name] = func;
        };
    }


    //alert( result ); // 8




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

    h3, p, #do_calc{
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
    <?php  $i = 0; ?>


        <div class="view">

            <input type='text' class="form-control" id="calculate" value="Введите расчётную строку (например 2 + 2)"/>
            <button class="btn btn-success form-control" id="do_calc" >Считаем!</button>


            <table class="table">
                <tbody>

                <?php foreach ($recorded_params as $param) :  ?>

                    <tr>
                        <td>
                            <?= $param->dayparam->name ?>

                        </td>

                        <td width="80">

                            <input type='text' class="form-control" id="rec_val_<?=$i ?>" value="<?= $param->value ?>" />
                            <button class="btn btn-success" id="rec_param_<?=$i ?>" onclick="changeParam(<?=$param->id?>, <?=$i?>, <?=$user?>)" >Изменить!</button>
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


                </tbody>
            </table>

        </div>

    </div>
