<?php

namespace app\modules\russia2018\controllers;

use app\components\FrontEndController;
use app\models\Matches;
use app\models\Team;
use app\modules\russia2018\models\Strategy;
use app\modules\russia2018\models;
use Yii;

class DefaultController extends FrontEndController
{
    public $bet_h = 0;
    public $bet_n = 0;
    public $bet_g = 0;
    public $host;
    

    /**
     * @return string
     */
    public function actionIndex()
    {

        $model = new Strategy();


            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->limit(10)
                //->offset(30)
                ->all();
            //$cats = Categories::find()->leaves()->all();
            $this->betsGenerate($matchs);
           // var_dump($matchs);

            shuffle($matchs);
            return $this->render('index', ['matchs' => $matchs,
                'model' => $model,
                'bet_h' => $this->bet_h,
                'bet_n' => $this->bet_n,
                'bet_g' => $this->bet_g]);
        }

    /**
     * Команда
     * @return string
     */
    public function actionStrateg() {

        if(Yii::$app->getRequest()->getQueryParam('host')) $team = Yii::$app->getRequest()->getQueryParam('host');
        else $team = '';

        if(Yii::$app->getRequest()->getQueryParam('limit')) $limit = Yii::$app->getRequest()->getQueryParam('limit');
        else $limit = 10;

        if(Yii::$app->getRequest()->getQueryParam('bet')) $bet = (int)Yii::$app->getRequest()->getQueryParam('bet');
        else $bet = 1;

        $model = new Strategy();

        $matchs = Matches::find()
            ->orderBy('id DESC')
            // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
            ->where("host like('_".$team."') or guest like('".$team."_')")
            ->limit($limit)
            ->all();
        //$cats = Categories::find()->leaves()->all();
        $this->betsGenerate($matchs);

       

        return $this->renderPartial('strat', [
            'matchs' => $matchs,
            'model' => $model,
            'bet_h' => $this->bet_h*$bet,
            'bet_n' => $this->bet_n*$bet,
            'bet_g' => $this->bet_g*$bet,
            'bet' => $bet,
            
        ]);
    }

    /**
     * Команда - данные
     * @return string
     */
    public function actionStrategu() {

        if(Yii::$app->getRequest()->getQueryParam('host')) $team = Yii::$app->getRequest()->getQueryParam('host');
        else $team = '';

        if(Yii::$app->getRequest()->getQueryParam('limit')) $limit = Yii::$app->getRequest()->getQueryParam('limit');
        else $limit = 10;

        if(Yii::$app->getRequest()->getQueryParam('bet')) $bet = (int)Yii::$app->getRequest()->getQueryParam('bet');
        else $bet = 1;

        $model = new Strategy();

        $matchs = Matches::find()
            ->orderBy('id DESC')
            // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
            ->where("host like('_".$team."') or guest like('".$team."_')")
            ->limit($limit)
            ->all();
        //$cats = Categories::find()->leaves()->all();
        $this->betsGenerate($matchs);

        $summary = $this->summary($matchs);
        //$arrteam = ;


        return $this->renderPartial('teams', [
            'bet_h' => $this->bet_h*$bet,
            'bet_n' => $this->bet_n*$bet,
            'bet_g' => $this->bet_g*$bet,
            'summary' => $this->teamsSummary($matchs, $team),
            

        ]);
    }


    /**
     * Запрос по стране
     * @return string
     */
    public function actionCountry() {

        $model = new Strategy();
        if(Yii::$app->getRequest()->getQueryParam('country')) $country = Yii::$app->getRequest()->getQueryParam('country');
        else $country = '';

        if(Yii::$app->getRequest()->getQueryParam('country_limit')) $country_limit = Yii::$app->getRequest()->getQueryParam('country_limit');
        else $country_limit = 10;

        if(Yii::$app->getRequest()->getQueryParam('country_bet')) $country_bet = (int)Yii::$app->getRequest()->getQueryParam('country_bet');
        else $country_bet = 1;

        $country = trim($country);

        $matchs = Matches::find()
            ->orderBy('id DESC')
            // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
            ->where("tournament like('".$country."%')")
            ->limit($country_limit)
            ->all();
        //$cats = Categories::find()->leaves()->all();
        $this->betsGenerate($matchs);

        return $this->renderPartial('strat', ['matchs' => $matchs,
            'model' => $model,
            'bet_h' => $this->bet_h*$country_bet,
            'bet_n' => $this->bet_n*$country_bet,
            'bet_g' => $this->bet_g*$country_bet,
        ]);

    }

    /**
     * Запрос по стране - данные
     * @return string
     */
    public function actionCountryu() {

        $model = new Strategy();
        if(Yii::$app->getRequest()->getQueryParam('country')) $country = Yii::$app->getRequest()->getQueryParam('country');
        else $country = '';

        if(Yii::$app->getRequest()->getQueryParam('country_limit')) $country_limit = Yii::$app->getRequest()->getQueryParam('country_limit');
        else $country_limit = 10;

        if(Yii::$app->getRequest()->getQueryParam('country_bet')) $country_bet = (int)Yii::$app->getRequest()->getQueryParam('country_bet');
        else $country_bet = 1;

        $country = trim($country);

        $matchs = Matches::find()
            ->orderBy('id DESC')
            // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
            ->where("tournament like('".$country."%')")
            ->limit($country_limit)
            ->all();
        //$cats = Categories::find()->leaves()->all();
        $this->betsGenerate($matchs);

        $summary = $this->summary($matchs);

        return $this->renderPartial('bets', [
            'bet_h' => $this->bet_h*$country_bet,
            'bet_n' => $this->bet_n*$country_bet,
            'bet_g' => $this->bet_g*$country_bet,
            'summary' => $summary
        ]);

    }


    /**
     * Запрос по турниру
     * @return string
     */
    public function actionTournament() {
        $model = new Strategy();
        if(Yii::$app->getRequest()->getQueryParam('tournament')) $tournament = Yii::$app->getRequest()->getQueryParam('tournament');
        else $tournament = 'АФРИКА';

       $tournament = trim($tournament);
        $year = date("Y");

        $matchs = Matches::find()
            ->orderBy('id DESC')
            // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
            ->where("tournament like('".$tournament."') and date like('%".$year."%')")
            ->all();

        $this->betsGenerate($matchs);

        return $this->renderPartial('strat', ['matchs' => $matchs,
            'model' => $model,
            'bet_h' => $this->bet_h,
            'bet_n' => $this->bet_n,
            'bet_g' => $this->bet_g,
        ]);

    }

    /**
     * Запрос по турниру - данные
     * @return string
     */
    public function actionTournamentu() {
        $model = new Strategy();
        if(Yii::$app->getRequest()->getQueryParam('tournament')) $tournament = Yii::$app->getRequest()->getQueryParam('tournament');
        else $tournament = 'АФРИКА';

        $tournament = trim($tournament);
        $year = date("Y");

        $matchs = Matches::find()
            ->orderBy('id DESC')
            // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
            ->where("tournament like('".$tournament."') and date like('%".$year."%')")
            ->all();

        $this->betsGenerate($matchs);

        $summary = $this->summary($matchs);

        return $this->renderPartial('bets', [
            'bet_h' => $this->bet_h,
            'bet_n' => $this->bet_n,
            'bet_g' => $this->bet_g,
            'tournament' => $matchs[0]->tournament,
            'summary' => $summary
        ]);

    }

    /**
     * Запрос на матч
     * @return string
     */
    public function actionMatch() {
        $model = new Strategy();
        if(Yii::$app->getRequest()->getQueryParam('hoster')) {
            $hoster = Yii::$app->getRequest()->getQueryParam('hoster');
            $hoster = trim($hoster);
        }
        else $hoster = '---';
        if(Yii::$app->getRequest()->getQueryParam('guester')) {

            $guester = Yii::$app->getRequest()->getQueryParam('guester');
            $guester = trim($guester);
        }
        else $guester = '---';

        if($hoster === 'null') {
            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("guest like('%".$guester."%')")
                ->all();
        }
        elseif($guester === 'null') {
            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("host like('%".$hoster."%')")
                ->all();
        }
        else {

            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("host like('%" . $hoster . "%') and guest like('%" . $guester . "%')")
                ->all();
        }

        $this->betsGenerate($matchs);



        return $this->renderPartial('strat', ['matchs' => $matchs,
            'model' => $model,
            'bet_h' => $this->bet_h,
            'bet_n' => $this->bet_n,
            'bet_g' => $this->bet_g,
        ]);


    }

    /**
     * Запрос на матч - данные
     * @return string
     */
    public function actionMatchu() {
        $model = new Strategy();
        if(Yii::$app->getRequest()->getQueryParam('hoster')) {
            $hoster = Yii::$app->getRequest()->getQueryParam('hoster');
            $hoster = trim($hoster);
        }
        else $hoster = 'ЦСКА';
        if(Yii::$app->getRequest()->getQueryParam('guester')) {

            $guester = Yii::$app->getRequest()->getQueryParam('guester');
            $guester = trim($guester);
        }
        else $guester = 'Манчестер Юнайтед';

        if($hoster === 'null') {
            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("guest like('%".$guester."%')")
                ->all();
        }
        elseif($guester === 'null') {
            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("host like('%".$hoster."%')")
                ->all();
        }
        else {

            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("host like('%" . $hoster . "%') and guest like('%" . $guester . "%')")
                ->all();
        }

        $this->betsGenerate($matchs);

        $summary = $this->summary($matchs);

        return $this->renderPartial('bets', [
            'bet_h' => $this->bet_h,
            'bet_n' => $this->bet_n,
            'bet_g' => $this->bet_g,
            'summary' => $summary
        ]);



    }

    /**
     * Запрос на матч (точный)
     * @return string
     */
    public function actionMatchstrict() {
        $model = new Strategy();

        if(Yii::$app->getRequest()->getQueryParam('hoster')) {

            if(Team::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('hoster')])->one()) {
                $hoster = Team::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('hoster')])->one()->name;
                $reg_h = Team::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('hoster')])->one()->reg;

            }
            elseif(Team::find()->where(['adapt_name' => Yii::$app->getRequest()->getQueryParam('hoster')])->one()) {
                $hosters = Team::find()->where(['adapt_name' => Yii::$app->getRequest()->getQueryParam('hoster')])->all();
                if(count($hosters) > 1) {
                    foreach ($hosters as $h) {
                        $teams_arr['name'][] = $h->name;
                        $teams_arr['reg'][] = $h->reg;
                    }
                    $hoster = '';
                }
                else {
                    $hoster = Team::find()->where(['adapt_name' => Yii::$app->getRequest()->getQueryParam('hoster')])->one()->name;
                    $reg_h = Team::find()->where(['adapt_name' => Yii::$app->getRequest()->getQueryParam('hoster')])->one()->reg;
                }

                //var_dump($teams_arr); exit;

            }
            else {
                $hoster = Yii::$app->getRequest()->getQueryParam('hoster');
                $reg_h = '';
            }
        }
        else $hoster = '---';
        if(Yii::$app->getRequest()->getQueryParam('guester')) {


            if(Team::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('guester')])->one()) {
                $guester = Team::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('guester')])->one()->name;
                $reg_g = Team::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('guester')])->one()->reg;
                //var_dump($reg_g); exit;

                    }
            elseif(Team::find()->where(['adapt_name' => Yii::$app->getRequest()->getQueryParam('guester')])->one()) {
                $guesters = Team::find()->where(['adapt_name' => Yii::$app->getRequest()->getQueryParam('guester')])->all();
                if(count($guesters) > 1) {
                    foreach ($guesters as $h) {
                        $teams_arr['name'][] = $h->name;
                        $teams_arr['reg'][] = $h->reg;
                    }
                    $guester = '';
                }
                else {
                    $guester = Team::find()->where(['adapt_name' => Yii::$app->getRequest()->getQueryParam('guester')])->one()->name;
                    $reg_g = Team::find()->where(['adapt_name' => Yii::$app->getRequest()->getQueryParam('guester')])->one()->reg;
                }




            }

            else {
                $guester = Yii::$app->getRequest()->getQueryParam('guester');
                $reg_g = '';

            }

        }
        else $guester = '---';

        if($hoster === 'null') {
            if(!isset($teams_arr)) {
                if($reg_g == 'МИР' || $reg_g == 'ЕВРОПА') {
                    //var_dump($reg_g);
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                        ->where("guest like('".$guester."_')")
                        ->andWhere("tournament like('МИР%') or tournament like('ЕВРОПА%')")
                        ->all();
                }
                else {
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        ->where("guest like('".$guester."_')")
                        ->andWhere("tournament like('".$reg_g."%')")
                        ->all();
                }
            }
            elseif(isset($teams_arr['name'][0]) and isset($teams_arr['name'][1])) {
                if($teams_arr['reg'][0] == 'ЕВРОПА') {
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        ->where("guest like('" . $teams_arr['name'][0] . "_') or guest like('" . $teams_arr['name'][1] . "_')")
                        ->andWhere("tournament like('ЕВРОПА%') or tournament like('МИР%') or tournament like('" . $teams_arr['reg'][1] . "%')")
                        ->all();
                }
                elseif ($teams_arr['reg'][1] == 'ЕВРОПА'){
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        ->where("guest like('" . $teams_arr['name'][0] . "_') or guest like('" . $teams_arr['name'][1] . "_')")
                        ->andWhere("tournament like('" . $teams_arr['reg'][0] . "%') or tournament like('ЕВРОПА%') or tournament like('МИР%') ")
                        ->all();
                }
                else {
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        ->where("guest like('" . $teams_arr['name'][0] . "_') or guest like('" . $teams_arr['name'][1] . "_')")
                        ->andWhere("tournament like('" . $teams_arr['reg'][0] . "%') or tournament like('" . $teams_arr['reg'][1] . "%')")
                        ->all();
                }
            }
        }


        elseif($guester === 'null') {
            if(!isset($teams_arr)) {
                if($reg_h == 'МИР' || $reg_h == 'ЕВРОПА') {
                    //var_dump($reg_h);
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                        ->where("host like('_".$hoster."')")
                        ->andWhere("tournament like('МИР%') or tournament like('ЕВРОПА%')")
                        ->all();
                }
                else {
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                        ->where("host like('_".$hoster."')")
                        ->andWhere("tournament like('".$reg_h."%')")
                        ->all();
                }
            }
            elseif(isset($teams_arr['name'][0]) and isset($teams_arr['name'][1])) {
                if($teams_arr['reg'][0] == 'ЕВРОПА') {
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                        ->where("host like('_" . $teams_arr['name'][0] . "') or host like('_" . $teams_arr['name'][1] . "')")
                        ->andWhere("tournament like('ЕВРОПА%') or tournament like('МИР%') or tournament like('" . $teams_arr['reg'][1] . "%')")
                        ->all();
                }
                elseif ($teams_arr['reg'][1] == 'ЕВРОПА'){
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                        ->where("host like('_" . $teams_arr['name'][0] . "') or host like('_" . $teams_arr['name'][1] . "')")
                        ->andWhere("tournament like('" . $teams_arr['reg'][0] . "%') or tournament like('ЕВРОПА%') or tournament like('МИР%') ")
                        ->all();
                }
                else {
                    $matchs = Matches::find()
                        ->orderBy('id DESC')
                        // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                        ->where("host like('_" . $teams_arr['name'][0] . "') or host like('_" . $teams_arr['name'][1] . "')")
                        ->andWhere("tournament like('" . $teams_arr['reg'][0] . "%') or tournament like('" . $teams_arr['reg'][1] . "%')")
                        ->all();
                }
            }
        }


        else {
            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("host like('_" . $hoster . "') and guest like('" . $guester . "_')")
                ->all();
        }

        $this->betsGenerate($matchs);

        return $this->renderPartial('strat', ['matchs' => $matchs,
            'model' => $model,
            'bet_h' => $this->bet_h,
            'bet_n' => $this->bet_n,
            'bet_g' => $this->bet_g,
        ]);



    }

    /**
     * Запрос на матч - данные (точный)
     * @return string
     */
    public function actionMatchstrictu() {
        $model = new Strategy();
        if(Yii::$app->getRequest()->getQueryParam('hoster')) {
            $hoster = Yii::$app->getRequest()->getQueryParam('hoster');
            $hoster = trim($hoster);
        }
        else $hoster = 'ЦСКА';
        if(Yii::$app->getRequest()->getQueryParam('guester')) {

            $guester = Yii::$app->getRequest()->getQueryParam('guester');
            //$guester = trim($guester);
        }
        else $guester = 'Манчестер Юнайтед';

        if($hoster === 'null') {
            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("guest like('" .$guester. "_')")
                ->all();
        }
        elseif($guester === 'null') {
            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("host like('_".$hoster."')")
                ->all();
        }
        else {

            $matchs = Matches::find()
                ->orderBy('id DESC')
                // ->where("host like('%ЦСКА') or host like('%ЦСКА (Рос)')")
                ->where("host like('_" . $hoster . "') and guest like('" . $guester . "_')")
                ->all();
        }

        $this->betsGenerate($matchs);

        $summary = $this->summary($matchs);

        return $this->renderPartial('bets', [
            'bet_h' => $this->bet_h,
            'bet_n' => $this->bet_n,
            'bet_g' => $this->bet_g,
            'summary' => $summary
        ]);

    }

    public function actionTeams(){
        $res = [];
        /*
        $m = Matches::find()
            ->select(['host, COUNT(*) as cnt'])
            ->groupBy('host')
            ->all();
        */
        $m = Team::find()
            ->all();
        foreach ($m as $h){
            //echo substr($h->host, 1);
            if($h->adapt_name) $res[] = $h->adapt_name;
            else $res[] = $h->name;
        }

        return  json_encode($res);
    }

    public function betsGenerate($matches) {
        foreach ($matches as $match) {
            if($match->bet_h != 0 && $match->bet_n != 0 && $match->bet_g != 0) {
                if ($match->gett > $match->lett) {
                    $this->bet_h += ($match->bet_h - 1);
                    $this->bet_n--;
                    $this->bet_g--;
                }
                if ($match->gett == $match->lett) {
                    $this->bet_n += ($match->bet_n - 1);
                    $this->bet_h--;
                    $this->bet_g--;
                }
                if ($match->gett < $match->lett) {
                    $this->bet_g += ($match->bet_g - 1);
                    $this->bet_n--;
                    $this->bet_h--;
                }
            }
        }
    }


    public function summary($matches){
        $arr['count'] = count($matches);
        $arr['vic'] = 0;
        $arr['nob'] = 0;
        $arr['def'] = 0;
        $arr['sum_gett'] = 0;
        $arr['sum_lett'] = 0;
        $arr['ball_h'] = 0;
        $arr['ball_g'] = 0;
        foreach ($matches as $match) {
            if($match->gett > $match->lett) {
                $arr['vic'] += 1;
                $arr['sum_gett'] += $match->gett;
                $arr['sum_lett'] += $match->lett;
                $arr['ball_h'] += 3;
            }
            elseif($match->gett == $match->lett){
                $arr['nob'] += 1;
                $arr['sum_gett'] += $match->gett;
                $arr['sum_lett'] += $match->lett;
                $arr['ball_h'] += 1;
                $arr['ball_g'] += 1;
            }
            else{
                $arr['def'] += 1;
                $arr['sum_gett'] += $match->gett;
                $arr['sum_lett'] += $match->lett;
                $arr['ball_g'] += 3;
            }
        }
       return $arr;

    }

    /**
     * Статистика команды
     * @param $matches
     * @param $team
     * @return mixed
     */
    public function teamsSummary($matches, $team){
        $arr['team'] = $team;
        $arr['vic'] = 0;
        $arr['nob'] = 0;
        $arr['def'] = 0;
        $arr['sum_gett'] = 0;
        $arr['sum_lett'] = 0;
        $arr['ball'] = 0;


        foreach ($matches as $match) {
            $arr['count'] = count($matches);

            if($team == iconv_substr($match->host, 1 , 80 , 'UTF-8' )) {

                if($match->gett > $match->lett) {
                    $arr['vic'] += 1;
                    $arr['sum_gett'] += $match->gett;
                    $arr['sum_lett'] += $match->lett;
                    $arr['ball'] += 3;
                }
                elseif($match->gett == $match->lett){
                    $arr['nob'] += 1;
                    $arr['sum_gett'] += $match->gett;
                    $arr['sum_lett'] += $match->lett;
                    $arr['ball'] += 1;
                }
                else{
                    $arr['def'] += 1;
                    $arr['sum_gett'] += $match->gett;
                    $arr['sum_lett'] += $match->lett;
                }

            }
            else{

                if($match->gett > $match->lett) {
                    $arr['def'] += 1;
                    $arr['sum_lett'] += $match->gett;
                    $arr['sum_gett'] += $match->lett;
                }
                elseif($match->gett == $match->lett){
                    $arr['nob'] += 1;
                    $arr['sum_lett'] += $match->gett;
                    $arr['sum_gett'] += $match->lett;
                    $arr['ball'] += 1;

                }
                else{
                    $arr['vic'] += 1;
                    $arr['sum_lett'] += $match->gett;
                    $arr['sum_gett'] += $match->lett;
                    $arr['ball'] += 3;
                }
            }

        }
        return $arr;

    }


}