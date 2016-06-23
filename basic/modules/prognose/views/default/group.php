<script>

    function prognos(match,i){

        var host_g = $("#host_g_"+i).val();
        var guest_g = $("#guest_g_"+i).val();

        var user = <?= (isset($user->id)) ? $user->id : 1 ?>;

            if(host_g && guest_g){
                $.ajax({
                    type: "GET",
                    url: "/prognose/default/match/",
                    data: "host_g="+host_g+"&guest_g="+guest_g+"&user="+user+"&match="+match,
                    success: function(res){
                        $("#prognose_"+i).hide();
                        $("#res_"+i).html(res);
                    }

                });
            }
        else alert("Введите счёт прогнозируемого матча!");



        return true;


    }

</script>

<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\grid\GridView;
use yii\helpers\Url;

AppAsset::register($this);
//var_dump($user); exit;
?>
<style>
    .form-control{
        width: auto;
        display: inline;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        text-align: center;
    }
    .team {
        font-size: 20px;
    }
    .form-group {
        margin-bottom: 0;
    }
</style>
<div class="col-sm-3 col-md-2 sidebar">
    <?php

    echo Nav::widget([
        'options' => ['class' => 'nav nav-sidebar'],
        'items' => [
            ['label' => 'Твои прогнозы', 'url' => ['/prognose/default/predicted/?id='.md5($user->id)]],

        ],
    ]);

    ?>

</div>

<div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Список матчей</h1>

    <table class="table table-striped">
        <tbody>

        <?php  $i = 0;
            foreach ($match_list as $match) :  ?>

            <tr>
                <td><p class="team"><?= $match->date  ?></p></td>
                <td><p class="team"><?= $match->tournament ?></p></td>
                <td><p class="team"><?= $match->host ?></p>
                    <input type='text' class="form-control" id="host_g_<?=$i ?>" size="2" />
                </td>
                <td><p class="team"><?= $match->guest ?></p>
                    <input type='text' class="form-control" id="guest_g_<?=$i ?>" size="2" />
                </td>


                <td>
                    <button class="btn btn-primary" id="prognose_<?=$i ?>" onclick="prognos(<?=$match->id?>, <?=$i?>)" >Прогноз!</button>
                    <p id="res_<?=$i?>"></p>

                </td>
            </tr>


        <?php $i++; endforeach; ?>
        </tbody>
    </table>

</div>
