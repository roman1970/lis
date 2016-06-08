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
            <h1 class="page-header">КХЛ 2015-2016</h1>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Дата</th>
                    <th>Стадион</th>
                    <th>Хозяева</th>
                    <th>Гости</th>
                    <th>Счет</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($matches as $match): ?>

                    <tr>
                        <td><?= $match->date ?></td>
                        <td><?= $match->stadium ?></td>
                        <td><?= $match->host->name ?></td>
                        <td><?= $match->guest->name ?></td>
                        <td><?= $match->host_g ?>:<?= $match->guest_g ?>
                            <a href="/khl/default/match/<?= $match->id?>"> <span class="glyphicon glyphicon-eye-open"></span></a>
                        </td>
                    </tr>


                    <?php endforeach; ?>


                </tbody>
            </table>

        </div>

