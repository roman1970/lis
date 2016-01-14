<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->registerJsFile('@web/js/accordion.js');
?>

<h3 class="head">Дневник <?php if($last_maner->dd == "") : ?> <span style="color: red; "> <?=date("d F Y D", $yesterday)?></span> 
<?php else : ?>  <?=date("d F Y D", $yesterday)?> </h3>
 <?php endif; ?>

<div class="col-lg-4">
    
    <div class="diary"> <span class="text">День жизни</span> <span class="dig"><?= $last_maner->denzhisni ?> </span>  </div> 
    <div class="diary"> <span class="text">Спорт:Неспорт</span> <span class="dig"><?= $last_maner->sport ?>:<?= $last_maner->nesport ?></span> </div> 
    <div class="diary"> <span class="text">Температура ночью</span> <span class="dig"> <?= $last_pogoda->temmorn ?> </span></div>
    <div class="diary"> <span class="text">Температура днём</span> <span class="dig"><?= $last_pogoda->temday ?></span></div>
    <div class="diary"> <span class="text">Точка (дни)</span> <span class="dig"><?= $ktt ?></span></div>
    <div class="diary"> <span class="text">Двоеточие (дни)</span> <span class="dig"><?= $see ?></span></div>
    <div class="diary"> <span class="text">Приход Sv:R</span> <span class="dig"><?= $prih_s ?>:<?= $prih_r ?></span></div>
    <div class="diary"> <span class="text">Потрачено с начала года</span> <span class="dig"><?= $totminus_sum ." р"?></span></div>
    <div class="grafik"><img src="<?= Url::base()."/uploads/dol.png"?>" /></div>
    <div class="grafik"><img src="<?= Url::base()."/uploads/sber.png"?>" /></div>
    
    <div class="chempship">
        <div class="ch">
            <p>Чемпионат магазинов</p>
            <?php $i=0; foreach ($best_shops as $key => $shop) { ?> 
            <?php if($shop && $i <= 10) : ?><div class="shops"> <span class="text"> <?= $key ?></span> <span class="dig"><?=  $shop ?></span></div>
            <?php $i++; endif; ?>
            <?php };     ?>
        </div>
        <div class="ch">
            <p>Чемпионат трат</p>
            <?php $i=0; foreach ($spends as $key => $spend) { ?> 
            <?php if($spend && $i <= 10) : ?><div class="shops"> <span class="text"> <?=  $key ?></span> <span class="dig"><?=  $spend ?></span></div>
            <?php $i++; endif; ?>
            <?php };     ?>
        </div>
     </div>
</div>

<div class="col-lg-4">
    
    
<div class="diary"> <span class="text">Оценка</span> 
    <span class="dig"><?php if($last_maner->ocenka < 65) : ?> <span style="color: red; "><?= $last_maner->ocenka ?> </span>
        <?php else : ?> <span style="color: green;"><?= $last_maner->ocenka ?> </span>
        <?php endif; ?>
    </span>
</div> 
<div class="diary"> <span class="text">Средняя оценка за 7 дней </span> 
    <span class="dig"><?php if($aver_seven < 65) : ?> <span style="color: red; "><?= round($aver_seven) ?> </span>
        <?php else : ?> <span style="color: green;"><?= round($aver_seven) ?> </span>
        <?php endif; ?>
    </span> 
</div>
   
    <div class="diary"> <span class="text">Расход электричества</span> <span class="dig"> <?=$yes_money ? round((($today_money->elcount - $yes_money->elcount) * $yes_money::STOIMOST_KILOVATA_ELEKTRICHESTVA), 2)." р" : "Нет данных" ?></span> </div>
    <div class="diary"> <span class="text">Расход горячей воды</span> <span class="dig"><?=$yes_money ? round((($today_money->hotwatcount - $yes_money->hotwatcount) * $yes_money::STOIMOST_KUBA_GOR_VODY), 2)." р" : "Нет данных" ?></span> </div>
    <div class="diary"> <span class="text">Расход холодной воды</span> <span class="dig"><?=$yes_money ? round((($today_money->coldwatcount - $yes_money->coldwatcount) * $yes_money::STOIMOST_KUBA_HOL_VODY), 2)." р"  : "Нет данных" ?></span> </div>
    <div class="diary"> <span class="text">Расход всего остального</span> <span class="dig"><?=$totminus." р" ?></span> </div>
    <div class="diary"> <span class="text">Приход всего</span> <span class="dig"><?=$totplus." р" ?></span> </div>
    <div class="diary"> <span class="text">На картах</span> <span class="dig"><?=$on_cards." р" ?></span> </div>
    
     <div class="accord">
    <h6>Шаги по часам за последние 7 дней</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/gistogramma_ormonsteps.png"?>" style="width: 350px; padding-bottom: 10px;" /></div>
    <h6>Аэробические шаги по часам за последние 7 дней</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/gistogramma_ormonaerosteps.png"?>" style="width: 350px; padding-bottom: 10px;" /></div>
    
     </div>
</div>
<div class="col-lg-4">
    <div class="diary"> <span class="text">Поездки</span> <span class="dig"> <?=$sum_poezdk?> </div>
    <div class="grafik"><img src="<?= Url::base()."/uploads/weigth.png"?>" /></div>
    <div class="grafik"><img src="<?= Url::base()."/uploads/ocenka.png"?>" /></div>
    <div class="accord">
    <h6>Килокалории по дням недели пн-вс</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/tottotweeks.png"?>" /></div>
    <h6>Оценка по дням недели пн-вс</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/ocenkaweeks.png"?>" /></div>
    <h6>Вес по месяцам</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/weigthmonthes.png"?>" /></div>
    <h6>Шаги по месяцам</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/totalstepmonthes.png"?>" /></div>
    <h6>Килокалории по месяцам</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/tottotmonthes.png"?>" /></div>
    <h6>Потраченные рубли по месяцам </h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/totminusmonthes.png"?>" /></div>
    <h6>Средняя скорость транспорта по дням недели пн-вс</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/srskorweeks.png"?>" /></div>
    <h6>Средняя скорость транспорта по дням месяцам пн-вс</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/srskormonthes.png"?>" /></div>
	<h6>Фрукты</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/fructmonthes.png"?>" /></div>
	<h6>Доходы</h6>
    <div class="grafik"><img src="<?= Url::base()."/uploads/totplusmonthes.png"?>" /></div>
    
    </div>
    
   
    
</div>

