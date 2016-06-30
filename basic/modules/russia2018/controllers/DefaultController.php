<?php

namespace app\modules\russia2018\controllers;

use app\components\FrontEndController;
use app\models\Matches;
use app\modules\russia2018\models\Strategy;
use app\modules\russia2018\models;
use Yii;

class DefaultController extends FrontEndController
{
    public $bet_h = 0;
    public $bet_n = 0;
    public $bet_g = 0;
    public $host;
    public $autocomplete_json;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->autocomplete_json = '{
                "suggestions": [
                    {
                        "value": "Россия",
                        "data": "750"
                    },
                    {
                        "value": "Словакия",
                        "data": "750"
                    },
                    {
                        "value": "Германия",
                        "data": "750"
                    },
                    {
                        "value": "Paris 03",
                        "data": "750"
                    },
                    {
                        "value": "Paris 04",
                        "data": "750"
                    },
                    {
                        "value": "Paris 05",
                        "data": "750"
                    },
                    {
                        "value": "Paris 06",
                        "data": "750"
                    },
                    {
                        "value": "Paris 07",
                        "data": "750"
                    },
                    {
                        "value": "Paris 08",
                        "data": "750"
                    },
                    {
                        "value": "Paris 09",
                        "data": "750"
                    }
                ]
            }';
        if(Yii::$app->getRequest()->getQueryParam('query')) {

           echo $this->autocomplete_json; exit;
        }

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
            ->where("host like('%".$team."%') or guest like('%".$team."%')")
            ->limit($limit)
            ->all();
        //$cats = Categories::find()->leaves()->all();
        $this->betsGenerate($matchs);

        return $this->renderPartial('strat', ['matchs' => $matchs,
            'model' => $model,
            'bet_h' => $this->bet_h*$bet,
            'bet_n' => $this->bet_n*$bet,
            'bet_g' => $this->bet_g*$bet,
            'bet' => $bet
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
            ->where("host like('%".$team."%') or guest like('%".$team."%')")
            ->limit($limit)
            ->all();
        //$cats = Categories::find()->leaves()->all();
        $this->betsGenerate($matchs);

        return $this->renderPartial('bets', [
            'bet_h' => $this->bet_h*$bet,
            'bet_n' => $this->bet_n*$bet,
            'bet_g' => $this->bet_g*$bet,

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

        return $this->renderPartial('bets', [
            'bet_h' => $this->bet_h*$country_bet,
            'bet_n' => $this->bet_n*$country_bet,
            'bet_g' => $this->bet_g*$country_bet,
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

        return $this->renderPartial('bets', [
            'bet_h' => $this->bet_h,
            'bet_n' => $this->bet_n,
            'bet_g' => $this->bet_g,
            'tournament' => $matchs[0]->tournament
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

        return $this->renderPartial('bets', [
            'bet_h' => $this->bet_h,
            'bet_n' => $this->bet_n,
            'bet_g' => $this->bet_g,
        ]);



    }

    /**
     * Запрос на матч (точный)
     * @return string
     */
    public function actionMatchstrict() {
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
                ->where("guest like('" . $guester . "_')")
                //->where(['guest' => $guester])
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


        $res = ['Россия', 'Словакия'];

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


}