<style>
    .table, h3{

    }
    p{
        text-align: center;
        color: rgb(255, 255, 255);
    }
</style>

<h3><?= $cat ?></h3>
<p>Потрачено <?= round($sum, 2) ?> р</p>


<table class="table">
    <tbody>

    <tr>
        <td>м</td>
        <td>товар</td>
        <td>сумма, р</td>
    </tr>

    <?php $i=0; foreach ($spent_prods as $prod => $spent) :  $i++ ?>


            <tr>
                <td><?= $i ?></td>
                <td><?= $prod ?></td>
                <td><?= round((int)$spent, 2) ?></td>
            </tr>

    <?php endforeach; ?>
    </tbody>
</table>