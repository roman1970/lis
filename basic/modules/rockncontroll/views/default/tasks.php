<script>

    $(document).ready(function() {

        $("#add_task").click(
            function() {

                var user = <?= (isset($user->id)) ? $user->id : 8 ?>;
                var task_name = $("#task_name").val();
                var task_description = $("#task_description").val();

                if (task_name == '') {alert('Введите название задачи!'); return;}
                if (task_description == '') {alert('Введите описание задачи!'); return;}

                addTask(task_name, task_description, user);


            });

        $('#task_name').focus(
            function () {
                $(this).select();
            });
        $('#task_description').focus(
            function () {
                $(this).select();
            });

    });

    function addTask(name, description, user) {

        $.ajax({
            type: "GET",
            url: "rockncontroll/default/add-task",
            data: "name="+name+"&description="+description+"&user="+user,
            success: function(html){
                $("#sum_tasks").html(html);

            }

        });

    }

    function doneTask(task_id,i, user){

        var mark = $("#mark_"+i).val();

        //Валидация
        if (mark  === "") {
            alert("Введите оценку");
            return false;
        }


        if(mark){
            $.ajax({
                type: "GET",
                url: "rockncontroll/default/tasked",
                data: "mark="+mark+"&user="+user+"&task_id="+task_id,
                success: function(res){
                    $("#tasked_"+i).hide();
                    $("#mark_"+i).hide();
                    $("#res_"+i).html(res);
                }

            });
        }
        else alert("Введите оценку!");


        return true;

    }

</script>

<style>
    .form-control{
        padding: 0;
        height: 33px;
        text-align: center;
        width: 80px;
    }

    #task_name, #task_description{
        width: 100%;
    }

    table > tbody > tr > td{
        padding: 0;
        font-size: 20px;
        word-break: break-all;
    }

    h3, p, #form-task{
        text-align: center;
        color: white;
    }

    @media (min-width:320px) and (max-width:767px) {
        table > tbody > tr > td{

            font-size: 14px;
            color: white;
        }
    }

</style>
<form class="form-inline center" role="form" id="form-task">
    <div class="form-group">
        <h3>Новая задача</h3>
        <p>
            <input type="text" class="form-control" id="task_name"  placeholder="Назвать задачу">
            <textarea class="form-control" id="task_description"  placeholder="Описание"></textarea>

            <button type="button" class="btn btn-success" id="add_task" >Озадачить!</button>
        </p>
    </div>
</form>
<div id="sum_tasks">
    <?php  $i = 0;
    if(count($tasks_list) < 1) : ?>

    <div class="view" style="color: white; text-align: center" ><h3>Нет задач!</h3>
        <?php else : ?>

        <div class="view">

            <table class="table">
                <tbody>


                <?php foreach ($tasks_list as $task) :  ?>

                    <tr>
                        <td>
                            <?= $task->name ?>

                        </td>

                        <td>
                            <?= $task->description ?>
                        </td>
                        <td>
                            <input type='text' class="form-control" id="mark_<?=$i ?>" placeholder="Оценка" width="20"/>
                            <button class="btn btn-success" id="tasked_<?=$i ?>" onclick="doneTask(<?=$task->id?>, <?=$i?>, <?=$user?>)" >Сделал!</button>
                            <p id="res_<?=$i?>"></p>

                        </td>


                    </tr>

                    <?php $i++; endforeach; ?>
                <?php endif; ?>


                </tbody>
            </table>

        </div>

    </div>
