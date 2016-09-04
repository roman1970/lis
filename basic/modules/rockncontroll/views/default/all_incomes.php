<style>
    .center, h3{
        text-align: center;
        color: rgb(255, 215, 0);
    }

    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
    }

    h3, h4{
        color: rgb(255, 215, 0);
    }

    .marker{
        color: rgb(255, 215, 0);
        font-size: 15px;
    }

    .form-control {
        width: 100%;
    }


</style>
<h4 class="center">Полезный баланс <?= round($bal_sum,2)?> Р</h4>
<table class="table">
    <tbody>

    <?php $i=1; foreach ($incomes as $income) :  ?>

        <tr>
            <td>
                <?= $i ?> <?= $income->income->name ?>
            </td>

            <td>
                <?= round($income->sum, 2) ?>
            </td>
        </tr>

        <?php $i++; endforeach; ?>


    </tbody>
</table>