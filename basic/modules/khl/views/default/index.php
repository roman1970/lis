<style>
    td{
        width: 200px;
    }
</style>
<?php foreach ($matches as $match): ?>
    <h3 class="teams">
        <table style="text-align: center">
            <tr>
                <td><?= $match->host->name ?></td>
                <td>-</td>
                <td><?= $match->guest->name ?></td>
            </tr>
            <tr>
                <td><?= $match->host_g ?></td>
                <td>:</td>
                <td><?= $match->guest_g ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?= $match->date ?></td>
                <td></td>
            </tr>
        </table>


<?php endforeach; ?>
