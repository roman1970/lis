<style>
    html, body {
        background-color: rgb(51, 65, 117);
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgb(26, 17, 93);
    }
    td, th {
        text-align: center;
        width: 33%;
    }
    th, .date{
        font-size: large;
    }
    .cent {
        text-align: center;
    }


</style>


<div class="col-sm-3 col-md-2 sidebar">
    lll

</div>


<div class="col-sm-9 col-md-10 main">
    <h1 class="page-header cent">КХЛ 2015-2016</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <td class="date"> <?= $match->stadium ?></td>
            <td class="date">Зрители: <?= $match->audience ?></td>
            <td class="date"> <?= $match->date ?></td>

        </tr>
        <tr>
            <th><?= $match->host->name ?></th>
            <th><?= $match->host_g ?>:<?= $match->guest_g ?></th>
            <th><?= $match->guest->name ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($events_of_match as $event): ?>
            <tr>
                <td><?php if($event->is_host == 1) {

                        if($event->status == 1) echo "<span style='color:#7bff48'>" .round($event->minute / 60) . "' Гол! ". $event->player->name;
                        elseif($event->status == 2) echo "<span style='color:#ffab3b'>".round($event->minute / 60) . "' Удаление " . $event->player->name. " " . $event->prim."</span>";
                        elseif($event->status == 3) echo "<span style='color:#7bff48'>" .round($event->minute / 60) . "' Реализованный буллит ".  $event->player->name;
                        elseif($event->status == 4) echo "<span style='color:#ff7721'>" .round($event->minute / 60) . "' Нереализованный буллит ".  $event->player->name;
                    }
                    else{
                        if($event->status == 1) echo "<span style='color:#ff7721'> Пропустил ". $event->goalKeeper->name."</span>";
                        elseif($event->status == 3) echo "<span style='color:#ff7721'>Вратарь ". $event->goalKeeper->name."</span>";
                        elseif($event->status == 4) echo "<span style='color:#7bff48'>Вратарь ". $event->goalKeeper->name."</span>";
                    }
                    ?></td>
                <td></td>
                <td><?php if($event->is_host == 0) {

                        if($event->status == 1) echo "<span style='color:#7bff48'>" .round($event->minute / 60) . "' Гол! ". $event->player->name;
                        elseif($event->status == 2) echo "<span style='color:#ffab3b'>".round($event->minute / 60) . "' Удаление " . $event->player->name. " " . $event->prim."</span>";
                        elseif($event->status == 3) echo "<span style='color:#7bff48'>" .round($event->minute / 60) . "' Реализованный буллит ".  $event->player->name;
                        elseif($event->status == 4) echo "<span style='color:#ff7721'>" .round($event->minute / 60) . "' Нереализованный буллит ".  $event->player->name;

                    }
                    else{
                        if($event->status == 1) echo "<span style='color:#ff7721'> Пропустил ". $event->goalKeeper->name;
                        elseif($event->status == 3) echo "<span style='color:#ff7721'>Вратарь ". $event->goalKeeper->name."</span>";
                        elseif($event->status == 4) echo "<span style='color:#7bff48'>Вратарь ". $event->goalKeeper->name."</span>";
                    }
                    ?></td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <td><?= $match->shotsHost->match ?></td>
            <td><?= "Броски в створ"?></td>
            <td><?= $match->shotsGuest->match ?></td>
        </tr>
        <tr>
            <td><?= $match->reflectedHost->match ?></td>
            <td><?= "Отраженные броски"?></td>
            <td><?= $match->reflectedGuest->match ?></td>
        </tr>
        <tr>
            <td><?= $match->removalHost->match ?></td>
            <td><?= "Удаления"?></td>
            <td><?= $match->removalGuest->match ?></td>
        </tr>

        </tbody>
    </table>


</div>
<?php
var_dump($match);
var_dump($events_of_match);