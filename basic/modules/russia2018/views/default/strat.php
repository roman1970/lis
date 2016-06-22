<?php $r=0; foreach ($matchs as $match) : ?>
    <div class="view">


        <p id="match_date">
            <?php echo $match->date; ?>
        </p>


        <p id="match_tour" onclick="getTour(<?=$r?>)" class="tour<?=$r?>" title="Все матчи <?=$match->tournament?>">
            <?php echo $match->tournament; ?>
        </p>


        <table id="mems_match" cellpadding="0" >
            <tr>
                <td class="left" title="Состав: <?=$match->getSost_h()?>" style="cursor: pointer"><?php echo $match->host; ?></td>
                <td class="center"><?php echo $match->gett; ?>:<?php echo $match->lett; ?> </td>
                <td class="right" title="Состав: <?=$match->getSost_g()?>" style="cursor: pointer"><?php echo $match->guest; ?></td>

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
        <?php if($match->getKeeperH() != '' || $match->getKeeperG() != '') : ?>

            <table id="coach" cellpadding="0" >
                <tr>
                    <td class="left"><?php echo $match->getKeeperH(); ?></td>
                    <td class="center">вратарь</td>
                    <td class="right"><?php echo $match->getKeeperG(); ?></td>

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

        <?php if($match->bet_h != 0 && $match->bet_n != 0 && $match->bet_g != 0) : ?>

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

        <?php endif; ?>


    </div>

<?php $r++; endforeach; ?>