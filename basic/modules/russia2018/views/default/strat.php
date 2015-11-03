<table id="mems_match" cellpadding="0" >
    <tr>
        <td class="left">Если бы поставил на победу, выигрыш </td>
        <td class="center">Если бы поставил на ничью, выигрыш  </td>
        <td class="right">Если бы поставил на поражение, выигрыш  </td>

    </tr>
</table>
<table id="mems_match" cellpadding="0" >
    <tr>
        <td class="left"><?=$bet_h ?></td>
        <td class="center"><?=$bet_n ?></td>
        <td class="right"><?=$bet_g ?></td>
    </tr>
</table>

<?php $r=0; foreach ($matchs as $match) : ?>
    <div class="view">


        <p id="match_date">
            <?php echo $match->date; ?>
        </p>


        <p id="match_tour" onclick="getTour(<?=$r?>)" class="tour<?=$r?>">
            <?php echo $match->tournament; ?>
        </p>


        <table id="mems_match" cellpadding="0" >
            <tr>
                <td class="left"><?php echo $match->host; ?></td>
                <td class="center"><?php echo $match->gett; ?>:<?php echo $match->lett; ?> </td>
                <td class="right"><?php echo $match->guest; ?></td>

            </tr>
        </table>
        <?php if($match->prim) : ?>
            <p class="prim"><?=$match->prim ?></p>
        <?php endif; ?>
        <table id="mems_goal" cellpadding="0" >
            <tr>
                <td class="left"><?php echo $match->goalH_str(); ?><?php echo $match->redCardH_str(); ?><?php echo $match->penMissH_str(); ?></td>
                <td class="center"></td>
                <td class="right"><?php echo $match->goalG_str(); ?><?php echo $match->redCardG_str(); ?><?php echo $match->penMissG_str(); ?></td>

            </tr>
        </table>
        <?php if($match->getCoachH() != '' || $match->getCoachG() != '') : ?>

            <table id="coach" cellpadding="0" >
                <tr>
                    <td class="left"><?php echo $match->getCoachH(); ?></td>
                    <td class="center">тренер</td>
                    <td class="right"><?php echo $match->getCoachG(); ?></td>

                </tr>
            </table>

        <?php endif; ?>

    <?php if($match->ud_h != 0 && $match->ud_g != 0) : ?>

        <table id="ud" cellpadding="0" >
            <tr>
                <td class="left"><?php echo $match->ud_h; ?></td>
                <td class="center">удары</td>
                <td class="right"><?php echo $match->ud_g; ?></td>

            </tr>
        </table>

    <?php endif; ?>

        <?php if($match->falls_h != 0 && $match->falls_g != 0) : ?>

            <table id="falls" cellpadding="0" >
                <tr>
                    <td class="left"><?php echo $match->yellCardCount_h(); ?><?php echo $match->falls_h; ?></td>
                    <td class="center">фолы</td>
                    <td class="right"><?php echo $match->falls_g; ?><?php echo $match->yellCardCount_g(); ?></td>

                </tr>
            </table>

        <?php endif; ?>

        <table id="stavki" cellpadding="0" >
            <tr>
                <td class="left"></td>
                <td class="center"> ставки </td>
                <td class="right"></td>

            </tr>
        </table>
        <table id="stavki" cellpadding="0" >
            <tr>
                <td class="left"><?php echo $match->bet_h; ?></td>
                <td class="center"><?php echo $match->bet_n; ?> </td>
                <td class="right"><?php echo $match->bet_g; ?></td>

            </tr>
        </table>


    </div>

<?php endforeach; ?>