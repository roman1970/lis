<?php
namespace frontend\modules\diary;

use yii\helpers\Html;
use yii\helpers\BaseUrl;

?> 


<div class="col-lg-4">
<h4>Команды, на победу которых стоит ставить (выигрыш на поставленный на победу рубль)</h4>
<?php 



foreach ($best_teams_bet_vic as $key => $team) { 
    $country_mod = new \frontend\modules\football\models\Countries();
    $country_of_team = $country_mod::find()
            ->where(['id_country' => $team->country_id])
            ->one();
    ?>
 
    <hr>
        <div class="table">
            <div class="cell"><?= $team->team ?></div>
            <div class="cell"><?php if($team->country_id != 0) echo $country_of_team->name ?></div>
            <div class="cell"><?= $team->bet_h ?> рублей </div>
   
</div> 
               

<?php }; ?>
</div>

<div class="col-lg-4">
<h4>Команды, на ничью которых стоит ставить (выигрыш на поставленный на ничью рубль)</h4>
<?php foreach ($best_teams_bet_nbd as $key => $team) { 
    $country_mod = new \frontend\modules\football\models\Countries();
    $country_of_team = $country_mod::find()
            ->where(['id_country' => $team->country_id])
            ->one();
    
    ?>

    <hr>
        <div class="table">
            <div class="cell"><?= $team->team ?></div>
            <div class="cell"><?php if($team->country_id != 0) echo $country_of_team->name ?></div>
            <div class="cell"><?= $team->bet_n ?> рублей</div>
        </div>
     

<?php }; ?>
</div>

<div class="col-lg-4">
<h4>Команды, на поражение которых стоит ставить (выигрыш на поставленный на поражение рубль)</h4>
<?php foreach ($best_teams_bet_def as $key => $team) { 
    $country_mod = new \frontend\modules\football\models\Countries();
    $country_of_team = $country_mod::find()
            ->where(['id_country' => $team->country_id])
            ->one();
    ?>
 
    <hr>
        <div class="table">
            <div class="cell"><?= $team->team ?> </div>
            <div class="cell"><?php if($team->country_id != 0) echo $country_of_team->name ?></div>
            <div class="cell"><?= $team->bet_g ?> рублей </div>
    
        </div> 
               

<?php }; ?>
</div>

