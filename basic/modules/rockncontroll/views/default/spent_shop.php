
<style>
    .table, h3{
        text-align: center;
    }
</style>

<h3>Магазин</h3>

<table class="table">
    <tbody>
    <tr>
        <td>магазин</td>
        <td>покупок</td>
        <td>сумма, р</td>
    </tr>

        <tr >
            <td><?= $spent_sum->shop->name ?></td>
            <td><?= $spent_sum->cnt ?></td>
            <td><?= round($spent_sum->sum, 2) ?></td>
        </tr>

    </tbody>
</table>

<?= $this->render('one_graph', ['data_2016' => $json_datas_2016, 'data_2017' => $json_datas_2017]);
//var_dump($json_datas);?>

<table class="table">
    <tbody>

    <tr>
        <td>дата</td>
        <td>товар</td>
        <td>сумма, р</td>
    </tr>

    <?php foreach ($spents as $spent) :  ?>
        <tr>
            <td><?= date('d-m-Y', $spent->act->time) ?></td>
            <td><?= $spent->product->name ?></td>

            <td><?= round($spent->spent, 2) ?></td>
        </tr>

    <?php endforeach; ?>



    </tbody>
</table>