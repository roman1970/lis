<?php

namespace app\modules\rockncontroll\controllers;


use app\components\FrontEndController;

use Yii;

class TestController extends FrontEndController
{

    /**
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');

    }

    public function actionTestes()
    {

        return $this->renderPartial('index');

    }
}
