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

    /**
     * @return string
     */
    public function actionIndex()
    {
        $matches = Khlmatches::find()->all();
        return $this->render('index', ['matches' => $matches]);

    }



}