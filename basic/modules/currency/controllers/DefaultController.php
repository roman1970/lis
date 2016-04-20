<?php

namespace app\modules\currency\controllers;

use app\components\BackEndController;
use app\modules\currency\models\Currencies;
use app\modules\currency\models\CurrHistory;
use Yii;


class DefaultController extends BackEndController
{

    public function actionIndex()
    {
        $currs = Currencies::find()->all();

        return $this->render('index', ['currs' => $currs]);
    }
    

}

