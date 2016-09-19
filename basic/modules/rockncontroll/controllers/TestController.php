<?php

namespace app\modules\rockncontroll\controllers;


use app\components\FrontEndController;

use app\models\Categories;
use app\models\DiaryActs;
use app\models\Estest;
use app\models\Klavaro;
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

            if(Yii::$app->getRequest()->getQueryParam('presize') &&
                Yii::$app->getRequest()->getQueryParam('speed') !== null &&
                Yii::$app->getRequest()->getQueryParam('eng_ru') &&
                Yii::$app->getRequest()->getQueryParam('cat')) {

                $act = new DiaryActs();
                $act->model_id = 13;
                $act->user_id = $user->id;

                if((float)Yii::$app->getRequest()->getQueryParam('presize') > 95 && (float)Yii::$app->getRequest()->getQueryParam('speed') > 30) $act->mark = 2;
                elseif ((float)Yii::$app->getRequest()->getQueryParam('presize') > 95) $act->mark = 1;
                else $act->mark = 0;

                //var_dump($act);

                if($act->save(false)) {
                    $klav_done = new Klavaro();
                    $klav_done->presize = (float)Yii::$app->getRequest()->getQueryParam('presize');
                    $klav_done->speed = (float)Yii::$app->getRequest()->getQueryParam('speed');


                    if (Categories::find()->where("name like '" . trim(Yii::$app->getRequest()->getQueryParam('eng_ru') . "'"))->one()) {
                        //  return var_dump(Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('cat')])->one()->id);
                        $klav_done->eng_ru = Categories::find()->where("name like '" . trim(Yii::$app->getRequest()->getQueryParam('eng_ru') . "'"))->one()->id;
                    } else return "Раскладка!";

                    if (Categories::find()->where("name like '" . trim(Yii::$app->getRequest()->getQueryParam('cat') . "'"))->one()) {
                        //  return var_dump(Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('cat')])->one()->id);
                        $klav_done->cat_id = Categories::find()->where("name like '" . trim(Yii::$app->getRequest()->getQueryParam('cat') . "'"))->one()->id;
                    } else return "Категория!";
                    $klav_done->act_id = $act->id;
                    //return var_dump($klav_done);
                    if($klav_done->save(false)) {
                        return 'Получи ' . $act->mark . ' баллов!';
                    }
                    else return 'Ошибка klav';


               }
                else return 'Ошибка act';

            }

        return $this->renderPartial('klavaro', ['user' => $user]);
        }

        return 'Доступ запрещён';


    }
    
    public function actionKlavarosCats(){
        $res = [];

        $m = Categories::find()
            ->where(['site_id' => 13])
            ->all();

        foreach ($m as $h){
            $res[] = $h->name;

        }

        return  json_encode($res);
    }


}
