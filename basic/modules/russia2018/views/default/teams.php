<style>
    .table > tbody > tr > td {
        background-color: rgb(240, 248, 255);
    }
    .table {
        border-radius: 5px;
    }
</style>

<table class="table">
    <tbody>
    <tr>
        <td>и</td>
        <td>в</td>
        <td>н</td>
        <td>п</td>
        <td>мячи </td>
        <td>очки</td>
    </tr>
    <tr>
        <td><?= $summary['count'] ?></td>
        <td>+<?= $summary['vic'] ?> </td>
        <td>=<?= $summary['nob'] ?></td>
        <td>-<?= $summary['def'] ?></td>
        <td><?= $summary['sum_gett'] ?> :
        <?= $summary['sum_lett'] ?></td>
        <td><?= $summary['ball'] ?></td>
    </tr>

    </tbody>
</table>