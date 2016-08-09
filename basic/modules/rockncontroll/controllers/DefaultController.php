<?php

namespace app\modules\rockncontroll\controllers;


use app\components\FrontEndController;
use app\models\DiaryActs;
use app\models\DiaryAte;
use app\models\DiaryDish;
use app\models\MarkGroup;
use app\models\MarkUser;
use Yii;
use app\models\Categories;
use yii\data\Pagination;

use app\models\Articles;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;


class DefaultController extends FrontEndController
{
    public $current_user;

    /**
     * @return string
     */
    public function actionIndex(){

       return $this->render('in');

    }

    /**
     * Съел
     * @return string
     */
    public function actionEat(){

        $start_day = strtotime('now 00:00:00');

        if(Yii::$app->getRequest()->getQueryParam('dish') && Yii::$app->getRequest()->getQueryParam('measure')) {

            $act = new DiaryActs();
            $act->model_id = 1;
            if($act->save(false)) {
                $ate = new DiaryAte();
                $dish = DiaryDish::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('dish')])->one();
                try {
                    $ate->dish_id = $dish->id;
                } catch (\ErrorException $e) {
                    return 'Такого блюда в базе нет!';
                }
                $ate->act_id = $act->id;
                $ate->measure = Yii::$app->getRequest()->getQueryParam('measure');
                $ate->kkal = round($ate->measure * $dish->kkal / 100);

                if(!$ate->validate()) {
                    return 'Данные введены некорректно';
                }
                else {
                    $ate->save();
                    /*метка начала текущих суток*/
                    
                    $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > ".$start_day."")->all(), 'id', 'id'));

                    $ate_today = DiaryAte::find()
                        ->where("act_id  IN (" . $today_acts . ")")
                        ->all();
                    $sum_kkal = DiaryAte::find()
                        ->select('SUM(kkal)')
                        ->where("act_id  IN (" . $today_acts . ")")
                        ->scalar();
                    return $this->renderPartial('ate_today', ['ate_today' => $ate_today, 'sum_kkal' => $sum_kkal]);
                   
                }

            }

        }
        $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > ".$start_day."")->all(), 'id', 'id'));


        $ate_today = [];
        $sum_kkal = 0;

        if ($today_acts) {
            $ate_today = DiaryAte::find()
                ->where("act_id  IN (" . $today_acts . ")")
                ->all();
            $sum_kkal = DiaryAte::find()
                ->select('SUM(kkal)')
                ->where("act_id  IN (" . $today_acts . ")")
                ->scalar();
        }

        

        return $this->render('eat', ['ate_today' => $ate_today, 'sum_kkal' => $sum_kkal]);
    }


    /**
     * Блюда для автокомплита
     * @return string
     */
    public function actionDishes(){
        $res = [];
      
        $m = DiaryDish::find()
            ->all();
        foreach ($m as $h){
           
          $res[] = $h->name;
           
        }

        return  json_encode($res);
    }

    public function actionLogin(){


        if(Yii::$app->getRequest()->getQueryParam('name') && Yii::$app->getRequest()->getQueryParam('pseudo')) {
            $name = Yii::$app->getRequest()->getQueryParam('name');
            $pseudo = Yii::$app->getRequest()->getQueryParam('pseudo');

            $user = MarkUser::find()
                ->where("name like('%" . $name . "') and pseudo like('" . $pseudo . "')")
                ->one();
            if($user) {

                return md5($user->id);
            }
            else return false;

        }

        else {
            return $this->render('login');
        }

    }

    /**
     * Выбор группы
     * @param $id
     * @return string
     */
    public function actionChoosegroup($id){
        

        if($this->userIfUserLegal($id)){

            return $this->render('index', ['user' => $this->current_user]);
        }

        return $this->render('index');

    }


    /**
     * Проверка юзера
     * @param $cuser
     * @return bool
     */
    private function userIfUserLegal($cuser){

        $max_id = MarkUser::find()
            ->select('MAX(id)')
            ->scalar();

        $i = 0;
        while ($i <= $max_id) {
            $i++;
            if ($user = MarkUser::findOne($i)) {
                if (md5($user->id) == $cuser) {
                    $this->current_user = $user;
                    return true;
                }
            }
        }

        return false;

    }

}