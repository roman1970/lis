<?php

namespace app\modules\khl\controllers;

use app\components\FrontEndController;

use yii\data\Pagination;
use app\models\Khlmatches;
use app\models\Khlevents;
use app\models\Khlplayers;
use app\models\Khlperiods;
use app\models\Khlteams;



class DefaultController extends FrontEndController
{
    public $layout = 'hockey';

    /**
     * @return string
     */
    public function actionIndex()
    {
        $matches = Khlmatches::find()->all();
        return $this->render('index', ['matches' => $matches]);

    }

    public function actionMatch($id)
    {
        $match = Khlmatches::findOne($id);
        $events_of_match = Khlevents::find()->where(['match_id' => $id])->all();
        return $this->render('match', ['match' => $match, 'events_of_match' => $events_of_match]);
    }



}