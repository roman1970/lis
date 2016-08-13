

    <h3>Сегодня   <?= $sum_spent ?> руб</h3>

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
            <td> <?= $item->spent ?></td>
            <td> <?= $item->shop->name ?></td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>
    