<style>

    .table > tbody > tr > td{
        vertical-align: middle;
        text-align: left;
    }
    
    .team {
        font-size: 20px;
    }
    .form-group {
        margin-bottom: 0;
    }
    .left{
        text-align: left;
        font-size: 20px;
    }
    .right{
        text-align: right;
    }
    .green{
        color: #c1ff65;
    }
    .blue{
        color: #4bbeff;
    }
    .red{
        color: #ff9148;
    }
    .view{
        color: white;
    }
</style>
<div class="view">
    <?= \app\components\BetBalanceWidget::widget(['user_id' => (isset($user->id)) ? $user->id : 1]) ?>
</div>
<div class="view">
    <?= \app\components\BetChempionWidget::widget(['user_id' => (isset($user->id)) ? $user->id : 1]) ?>
</div>
<div class="view">
    <table class="table">
        <tbody>

        <?php  $i = 0;

        foreach ($predicted as $one) :
            $class = '';
            $title = '';
            ?>
            <?php if ($one->match->foo_match_id > 1) :
            $mtch = \app\models\Matches::findOne($one->match->foo_match_id);

            if($one->status == \app\models\Totpredict::STATUS_RIGHT_SCORE) {
                $class = 'green';
                $title = 'Угадан счет';
            }
            elseif($one->status == \app\models\Totpredict::STATUS_RIGHT_RESULT) {
                $class = 'blue';
                $title = 'Угадан исход';
            }
            elseif($one->status == \app\models\Totpredict::STATUS_BAD_PROGNOSE) {
                $class = 'red';
                $title = 'Прогноз не верен';
            }

            ?>
            <tr>
                <td><p class="progn""><?= $mtch->date ?> <?= $mtch->tournament ?> </br> <?= $mtch->prim == '' ? '' : $mtch->prim ?></p></td>
                <td><p><?= $mtch->host ?> - <?= $mtch->guest ?></p></td>
                <td><p ><?= $mtch->gett ?> : <?= $mtch->lett ?></p></td>
            </tr>
        <?php endif ?>
            <tr title="<?=$title?>">
                <td><p class="<?=$class?> progn">Прогноз </p></td>
                <td><p class="<?=$class?>"><?= $one->match->host ?> - <?= $one->match->guest ?></p></td>
                <td><p class="<?=$class?>"><?= $one->host_g ?> : <?= $one->guest_g ?></p></td>
            </tr>

            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</div>
