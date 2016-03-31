<script>

    function mark(){
        var i = 0;
        var acts;
        var arr = [];
        //var date = $("#w1").val();
        var user = <?= (isset($user->id)) ? $user->id : 1 ?>;
        while (i < <?= (isset($actions)) ? count($actions) : 10 ?> ) {
            if(!$("#act_"+i).val()) break;

            if($("#mrk_"+i).val()){
                var data = {};
                data.mrk = $("#mrk_"+i).val();
                data.act = $("#act_"+i).val();
                arr[arr.length] = data;
            }
            else {
                alert("Не всё оценили!!!");
                return false;
            }
            i++;
        }

        acts = JSON.stringify(arr);

        $.ajax({
            type: "GET",
            url: "/markself/default/markday/",
            data: "acts="+acts+"&user="+user,
            success: function(html){
                $("#res").html(html);

                //window.location = 'choosegroup/'+user;
                //$.cookie('username', user, { expires: 7 });
                // var test = $.cookie('username'); // получение кук

            }

        });

      return true;

    }

</script>

<?php

use app\assets\AppAsset;
use yii\bootstrap\Nav;

AppAsset::register($this);
?>
    <div class="col-sm-3 col-md-2 sidebar">
        <?php

        echo Nav::widget([
            'options' => ['class' => 'nav nav-sidebar'],
            'items' => [
                ['label' => 'Создать новое действие', 'url' => ['/default/accreate']],
                //['label' => 'Показать контент', 'url' => ['/articles/index']],
                //['label' => 'Добавить страницу', 'url' => ['/articles/addpage/'.$model->id]],

            ],
        ]);

        ?>

    </div>

    <div class="col-sm-9 col-md-10 main">
    <h1 class="page-header">Оцениваемые действия</h1>  <p> <?= $group_name ?></p>
    <?php /*
    <p>Выбрать день для оценки</p>
        <span style="color: #000012" >
            <?= $date = \yii\jui\DatePicker::widget([
            'name'  => 'from_date',
            //'value'  => $value,
            'language' => 'ru',
            //'dateFormat' => 'yyyy-MM-dd',
            ]);
            ?>
        </span>
    */?>
    <?php  $i = 0;
        foreach ($actions as $act) : ?>

        <h3 class="page-header"><?=$i+1 .' '. $act->name ?></h3>
            <input type='text' class="form-control" id="mrk_<?=$i ?>" placeholder="Оценка" title="1,2,3,4 или 5"/>
            <input type="hidden" id="act_<?=$i ?>" value="<?=$act->id ?>" />

        <p style="color: #ffa225"><?= $act->description ?></p>
        <?php $i++; ?>

    <?php endforeach; ?>

    <button class="btn" id="mark" onclick="mark()" >Оценить</button>
        <p id="res"></p>