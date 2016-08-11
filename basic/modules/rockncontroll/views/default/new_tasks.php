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
                        <input type='text' class="form-control" id="host_g_<?=$i ?>" placeholder="Оценка" width="20"/>
                        <button class="btn btn-success" id="prognose_<?=$i ?>" onclick="doneTask(<?=$task->id?>, <?=$i?>)" >Сделал!</button>
                        <p id="res_<?=$i?>"></p>

                    </td>


                </tr>

                <?php $i++; endforeach; ?>
            <?php endif; ?>


            </tbody>
        </table>

    </div>