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

       return $this->render('index');

    }

    /**
     * Съел
     * @return string
     */
    public function actionEat(){

        $start_day = strtotime('now 00:00:00');

        
        if(Yii::$app->getRequest()->getQueryParam('user'))  {

            $user = Yii::$app->getRequest()->getQueryParam('user');


            if(Yii::$app->getRequest()->getQueryParam('dish') &&
                Yii::$app->getRequest()->getQueryParam('measure')) {


                $round_ate = 0;

                $dish = DiaryDish::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('dish')])->one();
                $today_acts_before = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user)->all(), 'id', 'id'));

                if($today_acts_before) {
                    $sum_kkal_before = DiaryAte::find()
                        ->select('SUM(kkal)')
                        ->where("act_id  IN (" . $today_acts_before . ")")
                        ->scalar();
                }
                else $sum_kkal_before = 0;

                $act = new DiaryActs();
                $act->model_id = 1;
                $act->user_id = Yii::$app->getRequest()->getQueryParam('user');
                $round_ate = round(Yii::$app->getRequest()->getQueryParam('measure') * $dish->kkal / 100);



                if($act->save(false)) {
                    $ate = new DiaryAte();

                    try {
                        $ate->dish_id = $dish->id;
                    } catch (\ErrorException $e) {
                        return 'Такого блюда в базе нет!';
                    }

                    $ate->act_id = $act->id;
                    $ate->user_id = $act->user_id;
                    $ate->measure = Yii::$app->getRequest()->getQueryParam('measure');
                    $ate->kkal = $round_ate;
                    //$ate->mark = $act->mark;

                    if(!$ate->validate()) {
                        return 'Данные введены некорректно';
                    }
                    else {
                        $ate->save();
                        /*метка начала текущих суток*/

                        $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user)->all(), 'id', 'id'));

                        $ate_today = DiaryAte::find()
                            ->where("act_id  IN (" . $today_acts . ")")
                            ->all();
                        $sum_kkal = DiaryAte::find()
                            ->select('SUM(kkal)')
                            ->where("act_id  IN (" . $today_acts . ")")
                            ->scalar();

                        if($sum_kkal > 2000) {
                            if($sum_kkal - $round_ate < 2000) {
                                $act->mark = round(($sum_kkal-2000)/100, 0, PHP_ROUND_HALF_UP)*(-1);
                            }
                            else{
                                $act->mark = round($round_ate/100, 0, PHP_ROUND_HALF_UP)*(-1);
                            }
                            $act->update();
                            $ate->mark = $act->mark;
                            $ate->update();
                        }


                        return $this->renderPartial('ate_today', ['ate_today' => $ate_today, 'sum_kkal' => $sum_kkal]);

                    }

                }

            }
            
        
            $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user)->all(), 'id', 'id'));
    
    
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
    
            return $this->renderPartial('eat', ['ate_today' => $ate_today, 'sum_kkal' => $sum_kkal, 'user' => $user]);
        }
        
        else {
            return $this->renderPartial('error');
        }


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

    /**
     * Вход
     * @return bool|string
     */
    public function actionLogin(){


        if(Yii::$app->getRequest()->getQueryParam('name') && Yii::$app->getRequest()->getQueryParam('pseudo')) {
            $name = Yii::$app->getRequest()->getQueryParam('name');
            $pseudo = Yii::$app->getRequest()->getQueryParam('pseudo');

            $user = MarkUser::find()
                ->where("name like('%" . $name . "') and pseudo like('" . $pseudo . "')")
                ->one();
            //return var_dump($user);

            if($user) {
               return $this->renderPartial('menu', ['user' => $user]);
            }
            else return false;

        }

        else {
            return $this->render('index');
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