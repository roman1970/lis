<?php

namespace app\modules\rockncontroll\controllers;


use app\components\FrontEndController;
use app\models\Bought;
use app\models\DiaryActs;
use app\models\DiaryAte;
use app\models\DiaryDish;
use app\models\MarkGroup;
use app\models\MarkUser;
use app\models\Products;
use app\models\Shop;
use app\models\Task;
use app\models\Tasked;
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

            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));
           // return var_dump($user);


            //$user = Yii::$app->getRequest()->getQueryParam('user');
            //return var_dump($user);


            if(Yii::$app->getRequest()->getQueryParam('dish') &&
                Yii::$app->getRequest()->getQueryParam('measure')) {


                $round_ate = 0;


                $dish = DiaryDish::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('dish')])->one();
                $today_acts_before = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = $user->id and model_id = 1")->all(), 'id', 'id'));

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

                        $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id)->all(), 'id', 'id'));

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


                        return $this->renderPartial('ate_today', ['ate_today' => $ate_today, 'sum_kkal' => $sum_kkal, 'user' => $user]);

                    }

                }

            }
            
        
            $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id)->all(), 'id', 'id'));
    
    
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
     * Показать список задач
     * @return string
     */
    public function actionShowTask(){

        //$start_day = strtotime('now 00:00:00');

        if(Yii::$app->getRequest()->getQueryParam('user'))  {
            $user = Yii::$app->getRequest()->getQueryParam('user');
            $tasks = Task::find()
                ->where('status = 0 or status = 1')
                ->all();

            return $this->renderPartial('tasks', ['tasks_list' => $tasks, 'user' => $user]);
        }

        return $this->renderPartial('error');

    }

    /**
     * Добавление задачи
     * @return string
     */
    public function actionAddTask(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));


            if (Yii::$app->getRequest()->getQueryParam('name') &&
                Yii::$app->getRequest()->getQueryParam('description')) {
                
                $new_task = new Task();
                $new_task->name = Yii::$app->getRequest()->getQueryParam('name');
                $new_task->description = Yii::$app->getRequest()->getQueryParam('description');
                $new_task->status = 1;
                $new_task->hour = 0;
                $new_task->dead_line = 0;
                
                if($new_task->validate()) {
                    if($new_task->save()) {
                        $tasks = Task::find()
                            ->where('status = 0 or status = 1')
                            ->all();
                        return $this->renderPartial('new_tasks', ['tasks_list' => $tasks, 'user' => $user]);
                      
                    }
                    else  return $this->renderPartial('error');
                    
                }
                else  return 'Текст большой!';

            }
        }
        
    }

    /**
     * Добавление товара
     * @return string
     */
    public function actionAddProduct(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $user = Yii::$app->getRequest()->getQueryParam('user');


            if (Yii::$app->getRequest()->getQueryParam('name') &&
                Yii::$app->getRequest()->getQueryParam('cat')) {
                
                $product = new Products();
                if(Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('cat')])->one()){
                  //  return var_dump(Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('cat')])->one()->id);
                    $product->cat_id = Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('cat')])->one()->id;
                }

                else $product->cat_id = 63;
                
                $product->name = Yii::$app->getRequest()->getQueryParam('name');
                $product->currency = 35;
                $product->currency_out = 35;
                $product->photo = '';
                $product->description = '';
                $product->formatted_val = '';
                $product->price = 0.0;
                //return var_dump($product);
                try {
                      if ($product->save(false)) return "<span style='color:green; font-size: 15px;'>Товар сохранен!</span>";
                        // else return var_dump($product);

                } catch (\ErrorException $e) {
                   return $e->getMessage();
                }

            }
            
            return $this->renderPartial('add_product');
        }
    }

    /**
     * Сохранение задачи
     * @return string
     * @throws \Exception
     */
    public function actionTasked(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $user = Yii::$app->getRequest()->getQueryParam('user');

                if(Yii::$app->getRequest()->getQueryParam('task_id') !== null && Yii::$app->getRequest()->getQueryParam('mark') !== null) {

                    //return var_dump($user);
                    $task = Task::findOne(Yii::$app->getRequest()->getQueryParam('task_id'));
                    $task->status = 2;
                    $task->update();

                    $act = new DiaryActs();
                    $act->model_id = 2;
                    $act->user_id = (int)$user;
                    $act->mark = (int)Yii::$app->getRequest()->getQueryParam('mark');
                    $act->mark_status = 0;

                    if($act->save(false)) {

                        $tasked = new Tasked();
                        $tasked->task_id = $task->id;
                        $tasked->user_id = (int)$user;
                        $tasked->act_id = $act->id;
                        $tasked->mark = (int)Yii::$app->getRequest()->getQueryParam('mark');
                        $tasked->mark_status = 0;

                   //return var_dump($tasked);

                        if ($tasked->save()) {

                                return "<span style='color:green'>Задача выполнена!</span>";
                            }
                            else "<span style='color:red'>Ошибка сохранения tasked</span>";
                       
                        }
                        else return "<span style='color:red'>Ошибка валидации</span>";

            }
        }
        
    }

    /**
     * Расскажи мне про покупку
     * @return string
     */
    public function actionBought(){

        $start_day = strtotime('now 00:00:00');

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $user = Yii::$app->getRequest()->getQueryParam('user');

            if(Yii::$app->getRequest()->getQueryParam('product') &&
                Yii::$app->getRequest()->getQueryParam('measure') &&
                Yii::$app->getRequest()->getQueryParam('shop') &&
                Yii::$app->getRequest()->getQueryParam('item')) {


                $product = Products::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('product')])->one();
                $shop = Shop::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('shop')])->one();
                $today_acts_before = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = $user and model_id = 3")->all(), 'id', 'id'));

                if($today_acts_before) {
                    $sum_spent_before = Bought::find()
                        ->select('SUM(spent)')
                        ->where("act_id  IN (" . $today_acts_before . ")")
                        ->scalar();
                }
                else $sum_spent_before = 0;

                $act = new DiaryActs();
                $act->model_id = 3;
                $act->user_id = (int)Yii::$app->getRequest()->getQueryParam('user');
                


                if($act->save(false)) {
                    $bought = new Bought();

                    try {
                        $bought->product_id = $product->id;
                    } catch (\ErrorException $e) {
                        return 'Такого продукта в базе нет!';
                    }

                    $bought->act_id = $act->id;
                    $bought->user_id = $act->user_id;
                    $bought->spent = (float)Yii::$app->getRequest()->getQueryParam('measure');
                    $bought->item_price = (float)Yii::$app->getRequest()->getQueryParam('item');
                    $bought->shop_id = $shop->id;
                    //$ate->mark = $act->mark;

                    //return var_dump($bought);

                    if(!$bought->validate()) {
                        return 'Данные введены некорректно';
                    }
                    else {
                        $bought->save();
                        //return var_dump($bought);
                        /*метка начала текущих суток*/

                        $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = $user and model_id = 3")->all(), 'id', 'id'));

                        $bought_today = [];
                        $sum_spent = 0;

                        if ($today_acts) {
                            try {
                                //return var_dump($bought_today);
                                $bought_today = Bought::find()->where("act_id  IN (" . $today_acts . ")")->all();
                            } catch (\ErrorException $e) {
                                return $e->getMessage();
                            }


                            $sum_spent = Bought::find()->select('SUM(spent)')->where("act_id  IN (" . $today_acts . ")")->scalar();
                           // return var_dump($sum_spent );
                        }

                        //return var_dump($sum_spent);


                            return $this->renderPartial('bought_today', ['bought_today' => $bought_today, 'sum_spent' => $sum_spent]);

                        }


                    }



            }

            $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = $user and model_id = 3")->all(), 'id', 'id'));


            $bought_today = [];
            $sum_spent = 0;

            if ($today_acts) {
                $bought_today = Bought::find()
                    ->where("act_id  IN (" . $today_acts . ")")
                    ->all();
                $sum_spent = Bought::find()
                    ->select('SUM(spent)')
                    ->where("act_id  IN (" . $today_acts . ")")
                    ->scalar();
            }

            return $this->renderPartial('bought', ['bought_today' => $bought_today, 'sum_spent' => $sum_spent, 'user' => $user]);


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
      
        $m = DiaryDish::find()->all();
        
        foreach ($m as $h){
          $res[] = $h->name;
           
        }

        return  json_encode($res);
    }

    /**
     * Товары для автокомплита
     * @return string
     */
    public function actionProducts(){
        $res = [];

        $m = Products::find()->all();
        
        foreach ($m as $h){
            $res[] = $h->name;

        }

        return  json_encode($res);
    }

    /**
     * Магазины для автокомплита
     * @return string
     */
    public function actionShops(){
        $res = [];

        $m = Shop::find()->all();

        foreach ($m as $h){
            $res[] = $h->name;

        }

        return  json_encode($res);
    }

    /**
     * Категории для автокомплита
     * @return string
     */
    public function actionCats(){
        $res = [];

        $m = Categories::find()->where(['site_id' => 11])->all();

        foreach ($m as $h){
            $res[] = $h->name;

        }

        return  json_encode($res);
    }
    
    public function actionDataForCharts(){
        $res = [];

        $m = Products::find()->all();

        $res[0][] = '';
        $res[1][] = '';

        foreach ($m as $h){
            $res[0][] = $h->name;

        }
        foreach ($m as $h){
            $res[1][] = $h->id;

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