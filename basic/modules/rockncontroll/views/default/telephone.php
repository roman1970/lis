
<table class="table" style="text-align: center; color: white;">
    <tbody>
    <tr >
        <td>м</td>
        <td>кол-во соединений</td>
        <td>кол-во</td>
    </tr>
<?php $i=0; foreach ($tells as $tell) : $i++;  ?>
    <tr >
        <td><?= $i ?></td>
        <td> <?= $tell->cnt  ?></td>
        <td> <?= $tell->nom_tel ?></td>
    </tr>

<?php endforeach; ?>

</tbody>
</table>