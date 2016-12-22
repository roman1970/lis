<style>
    .table > tbody > tr > td{
        padding: 0;
        color: rgb(255, 215, 0);
    }
    h3{color: rgb(255, 215, 0); text-align: center}
</style>
<h3>Футбольные Клубы</h3>

<table class="table">
    <tbody>
    <tr>
        <td>м</td>
        <td>к</td>
        <td>и</td>
        <td>в</td>
        <td>н</td>
        <td>п</td>
        <td>рм</td>
        <td>о</td>
    </tr>
    <?php $i=0; foreach ($clubs as $team) :  $i++; ?>
            <tr>
                <td><?= $i ?></td>
                <td> <?= $team->name ?></td>
                <td><?= $team->cash_cout ?></td>
                <td>+<?= $team->cash_vic ?> </td>
                <td>=<?= $team->cash_nob ?></td>
                <td>-<?= $team->cash_def ?></td>
                <td><?= $team->cash_g_get ?> :
                    <?= $team->cash_g_let ?></td>
                <td><?= $team->cash_balls ?></td>
            </tr>


    <?php endforeach; ?>
    </tbody>
</table>

<h3>Футбольные Сборные</h3>

<table class="table">
    <tbody>
    <tr>
        <td>м</td>
        <td>к</td>
        <td>и</td>
        <td>в</td>
        <td>н</td>
        <td>п</td>
        <td>рм</td>
        <td>о</td>
    </tr>
    <?php $i=0; foreach ($countries as $team) :  $i++; ?>
        <tr>
            <td><?= $i ?></td>
            <td> <?= $team->name ?></td>
            <td><?= $team->cash_cout ?></td>
            <td>+<?= $team->cash_vic ?> </td>
            <td>=<?= $team->cash_nob ?></td>
            <td>-<?= $team->cash_def ?></td>
            <td><?= $team->cash_g_get ?> :
                <?= $team->cash_g_let ?></td>
            <td><?= $team->cash_balls ?></td>
        </tr>


    <?php endforeach; ?>
    </tbody>
</table>
