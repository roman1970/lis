<h4 style="text-align: center; color: sandybrown">На фоне грандов</h4>
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
                <td style="color: #2cb7d5"><?= $team->name ?></td>
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
                <td style="color: wheat"><?= $team->name ?></td>
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