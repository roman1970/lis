<style>
    .form-control{
        width: auto;
        display: inline;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        text-align: left;
    }
    table td .progn{
        width: 400px;
        text-align: center;
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
        color: green;
    }
    .blue{
        color: #4bbeff;
    }
    .red{
        color: red;
    }
</style>
<div class="col-sm-4 col-md-3 sidebar" xmlns="http://www.w3.org/1999/html">

    <?= \app\components\BetBalanceWidget::widget(['user_id' => (isset($user->id)) ? $user->id : 1]) ?>


</div>

<div class="col-sm-8 col-md-9 main">
    <h1 class="page-header">Твои прогнозы</h1>
    <table class="table table-striped">
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
                        <td><p><?= $mtch->host ?></p></td>
                        <td><p>-</p></td>
                        <td><p class="right"><?= $mtch->guest ?></p></td>
                        <td><p ><?= $mtch->gett ?></p></td>
                        <td><p>:</p></td>
                        <td><p><?= $mtch->lett ?></p></td>
                    </tr>
                    <?php endif ?>
                    <tr title="<?=$title?>">
                        <td><p class="<?=$class?> progn">Прогноз </p></td>
                        <td><p class="<?=$class?>"><?= $one->match->host ?></p></td>
                        <td><p class="<?=$class?>">-</p></td>
                        <td><p class="<?=$class?>"><?= $one->match->guest ?></p></td>
                        <td><p class="<?=$class?> right"><?= $one->host_g ?></p></td>
                        <td><p class="<?=$class?>">:</p></td>
                        <td><p class="<?=$class?>""><?= $one->guest_g ?></p></td>
                    </tr>

                <?php $i++; endforeach; ?>
        </tbody>
    </table>
    </div>


