<style>
    .center, h3{
        text-align: center;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
        word-break: break-all;
    }

    h3{
        color: rgb(255, 215, 0);
    }
    .glyphicon {
        color: gold !important;
    }
</style>

<table class="table">
    <tbody>
    <tr >
        <td>time - ip</td>

        <td>body</td>

    </tr>
    <?php $i=0; foreach ($logs as $log) : ?>
        <tr >
            <td style="width: 30%"><?= $log->ip ?> ::: <?= date('d-m-Y H:m',$log->time) ?></td>
            <td> <?= $log->body ?></td>


        </tr>

    <?php endforeach; ?>

    </tbody>
</table>
