<style>
    .table > tbody > tr > td{
        padding: 0;
    }
</style>

<h4 style="text-align: center; color: sandybrown">Чемпионат 2016-2018</h4>
<p style="color: white;text-align: center;">В этом чемпионате учитываются матчи, которые проводит команда во всех турнирах, а так же товарищеских матчах. За 300 дней до открытия чемпионата мира
по футболу 2018 начнётся розыгрыш призов. Болельщики победившей команды получат по 10000 рублей. Скоро мы опубликуем условия! Следите за Чемпионатом!!!</p>
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
    <?php $i=0;  foreach ($summary as $team) :  $i++; ?>
        <?php if ($this_team == $team->name ) : echo 'i'; ?>
            <tr >
                <td style="color: #2cb7d5"><?= $i ?></td>
                <td style="color: #2cb7d5;text-align: left"> <?= $team->name ?></td>
                <td style="color: #2cb7d5"><?= $team->cash_cout ?></td>
                <td style="color: #2cb7d5">+<?= $team->cash_vic ?> </td>
                <td style="color: #2cb7d5">=<?= $team->cash_nob ?></td>
                <td style="color: #2cb7d5">-<?= $team->cash_def ?></td>
                <td style="color: #2cb7d5"><?= $team->cash_g_get ?> :
                <?= $team->cash_g_let ?></td>
                <td style="color: #2cb7d5"><?= $team->cash_balls ?></td>
            </tr>
        <?php else : ?>
            <tr>
                <td style="color: wheat"><?= $i ?></td>
                <td style="color: wheat;text-align: left"> <?= $team->name ?></td>
                <td style="color: wheat"><?= $team->cash_cout ?></td>
                <td style="color: wheat">+<?= $team->cash_vic ?> </td>
                <td style="color: wheat">=<?= $team->cash_nob ?></td>
                <td style="color: wheat">-<?= $team->cash_def ?></td>
                <td style="color: wheat"><?= $team->cash_g_get ?> :
                    <?= $team->cash_g_let ?></td>
                <td style="color: wheat"><?= $team->cash_balls ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

    </tbody>
</table>