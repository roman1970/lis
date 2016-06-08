<style>
    html, body {
        background-color: rgb(51, 65, 117);
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgb(26, 17, 93);
    }
</style>


<div class="col-sm-3 col-md-2 sidebar">
    lll

</div>


<div class="col-sm-9 col-md-10 main">
    <table class="table table-striped">
        <thead>
        <tr>
            <?= $match->date ?>
        </tr>
        <tr>
            <th><?= $match->host->name ?></th>
            <th><?= $match->host_g ?>:<?= $match->guest_g ?></th>
            <th><?= $match->guest->name ?></th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td><?= $match->shotsHost->match ?></td>
            <td><?= "Броски в створ"?></td>
            <td><?= $match->shotsGuest->match ?></td>

        </tr>

        </tbody>
    </table>

    <h1 class="page-header"><?= $match->date ?> <?= $match->host->name ?> - <?= $match->guest->name ?> <?= $match->host_g ?>:<?= $match->guest_g ?></h1>
    <p><?php if($match->prim != "Завершен") echo $match->prim; ?></p>
    <p><?php echo "Броски в створ: ". $match->shotsHost->match . ":" . $match->shotsGuest->match; ?></p>
    <p><?php echo "Отраженные броски: ". $match->reflectedHost->match . ":" . $match->reflectedGuest->match; ?></p>
</div>
<?php
var_dump($match);
var_dump($events_of_match);