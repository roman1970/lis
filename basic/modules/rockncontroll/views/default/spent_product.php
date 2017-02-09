<style>
    .table, h3{
        text-align: center;
    }
</style>

<h3><?= $product ?></h3>

<table class="table">
    <tbody>
        <tr>
            <td>покупок</td>
            <td>сумма, р</td>
        </tr>

        <tr>
            <td><?= $spent->cnt ?></td>
            <td><?= round($spent->sum, 2) ?></td>
        </tr>
    </tbody>
</table>
<?= $this->render('one_graph', ['data_2016' => $json_datas_2016, 'data_2017' => $json_datas_2017]);
//var_dump($json_datas);?>
<table class="table">
    <tbody>

        <tr>
            <td>дата</td>
            <td>магазин</td>
            <td>сумма, р</td>
            <td>цена за ед, р</td>
        </tr>

    <?php foreach ($spents as $spent) :  ?>
        <tr>
            <td><?= date('d-m-Y', $spent->act->time) ?></td>
            <td><?= $spent->shop->name ?></td>
            <td><?= round($spent->spent, 2) ?></td>
            <td><?= round($spent->item_price, 2) ?></td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>