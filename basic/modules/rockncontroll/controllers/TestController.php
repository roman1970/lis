<?php

namespace app\modules\rockncontroll\controllers;


use app\components\FrontEndController;

use app\models\Estest;
use app\models\MarkUser;
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

    public function actionKlavaro()
    {

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));

          // return var_dump($user);

        //$tests = Estest::find()->all();

        return $this->renderPartial('klavaro', ['user' => $user]);
        }

        return 'Ошибка';


    }


}
