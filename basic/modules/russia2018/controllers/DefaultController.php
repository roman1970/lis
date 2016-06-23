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
                ->where("guest like('.$guester._')")
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
            $guester = trim($guester);
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

        return $this->renderPartial('bets', [
            'bet_h' => $this->bet_h,
            'bet_n' => $this->bet_n,
            'bet_g' => $this->bet_g,
        ]);



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



}