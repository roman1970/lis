<style>
    .table, h3{

    }
    p{
        text-align: center;
        color: rgb(255, 255, 255);
    }
</style>


<p>Потрачено <?= round($sum, 2) ?> р</p>

<?= $this->render('one_graph', ['data_2016' => $json_datas_2016, 'data_2017' => $json_datas_2017]);?>
<table class="table">
    <tbody>

    <tr>
        <td>м</td>
        <td>товар</td>
        <td>сумма, р</td>
    </tr>

    <?php $i=0; foreach ($spents as $spent) :  $i++ ?>

    <tr>
        <td><?= $i ?></td>
        <td><?= $spent->product->name ?></td>
        <td><?= round((int)$spent->spent, 2) ?></td>
    </tr>

<?php endforeach; ?>
</tbody>
</table>