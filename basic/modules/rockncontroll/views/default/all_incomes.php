<table class="table">
    <tbody>

    <?php $i=1; foreach ($incomes as $income) :  ?>

        <tr>
            <td>
                <?= $i ?> <?= $income->income->name ?>
            </td>

            <td>
                ---------
            </td>

            <td>
                <?= $income->sum ?>
            </td>
        </tr>

        <?php $i++; endforeach; ?>


    </tbody>
</table>