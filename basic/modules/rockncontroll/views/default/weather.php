<style>
    .center, h3, table > tbody > tr > td{
        text-align: center;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
    }
    h3{
        color: rgb(255, 215, 0);
    }


    .form-control {
        width: 100%;
    }


</style>
<table class="table">
    <tbody>
        <tr>
        <td>city</td>
        <td>temp, C</td>
        <td>press, mm Hg</td>
    </tr>
    <?php foreach ($weather as $city) : ?>
    <tr>
        <td><?= $city->city->name ?> <?= date('Y-m-d H:i', $city->time) ?></td>
        <td><?= (int)$city->temp - 273 ?> </td>
        <td><?= round($city->pressure * 100 /  133.3224) ?> </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

