


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
        <td>кол-во</td>
        <td>ккал</td>
        <td>не съел</td>
    </tr>
<?php $i=0; foreach ($ate_today as $item) : $i++;  ?>
    <tr >
        <td><?= $i ?></td>
        <td> <?= $item->dish->name ?></td>
        <td> <?= $item->measure ?></td>
        <td> <?= $item->kkal ?></td>
        <td>
            <button class="btn btn-success" id="del_<?=$i ?>" onclick="delAte(<?=$item->id?>, <?=$i?>, <?=$user->id?>)" ><span class="glyphicon glyphicon-fire" id="del_<?=$i ?>"></span></button>
            <p id="res_<?=$i?>"></p>

        </td>
    </tr>

<?php endforeach; ?>

    </tbody>
</table>
    