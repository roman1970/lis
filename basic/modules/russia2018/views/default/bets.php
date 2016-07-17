<?php if(isset($tournament)) {echo $tournament; $tournament = null;} /* ?>
<p>Если поставить на один исход во всех этих матчах</p>
<table id="bet" cellpadding="0" >
    <tr>
        <td class="left_bet">На хозяев</td>
        <td class="center_bet">На ничью</td>
        <td class="right_bet">На гостей</td>

    </tr>
</table>
<p>Можно было бы выиграть (- проиграть) *ставка</p>
<table id="bet" cellpadding="0" >
    <tr>
        <td class="left_bet_cyph"><?=$bet_h ?></td>
        <td class="center_bet_cyph"><?=$bet_n ?></td>
        <td class="right_bet_cyph"><?=$bet_g ?></td>
    </tr>
</table>
<?php

 $arr['vic'] = 0;
        $arr['nob'] = 0;
        $arr['def'] = 0;
        $arr['sum_gett'] = 0;
        $arr['sum_lett'] = 0;
        $arr['ball_h'] = 0;
        $arr['ball_g'] = 0;
  */
?>
    <table class="table table-striped">
        <tbody>
            <tr>
                <td><?= $summary['count'] ?> </td>
                <td>+<?= $summary['vic'] ?> </td>
                <td>=<?= $summary['nob'] ?></td>
                <td>-<?= $summary['def'] ?></td>
                <td><?= $summary['sum_gett'] ?></td>
                <td>:</td>
                <td><?= $summary['sum_lett'] ?></td>
            </tr>

        </tbody>
    </table>