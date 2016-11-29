<style>
    .center, h3{
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

    <h3>Сегодня   <?= round($sum_spent, 2) ?> руб</h3>

<table class="table">
    <tbody>
    <tr >
        <td>м</td>
        <td>товар</td>
        <td>стоимость</td>
        <td>магаз</td>
    </tr>
    <?php $i=0; foreach ($bought_today as $item) : $i++;  ?>
        <tr >
            <td><?= $i ?></td>
            <td> <?= $item->product->name ?></td>
            <td> <?= round($item->spent, 2) ?></td>
            <td> <?= $item->shop->name ?></td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>
    