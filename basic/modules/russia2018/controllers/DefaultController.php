<?php

namespace app\modules\russia2018\controllers;

use app\components\FrontEndController;

class DefaultController extends FrontEndController
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');

    }



}