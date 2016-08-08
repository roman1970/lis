


    <?php if($sum_kkal > 2000) : ?>
        <h3 style="color: red">Сегодня съел <?= $sum_kkal ?> kkal</h3>
        <?php else : ?>
        <h3>Сегодня съел <?= $sum_kkal ?> kkal</h3>
    <?php endif; ?>

<table class="table">
    <tbody>
    <tr >
        <td>м</td>
        <td>блюдо</td>
        <td>количество</td>
        <td>калорийность</td>
    </tr>
<?php $i=0; foreach ($ate_today as $item) : $i++;  ?>
    <tr >
        <td><?= $i ?></td>
        <td> <?= $item->dish->name ?></td>
        <td> <?= $item->measure ?></td>
        <td> <?= $item->kkal ?></td>
    </tr>

<?php endforeach; ?>

    </tbody>
</table>
    