<?php

namespace app\modules\rockncontroll\controllers;


use app\components\FrontEndController;
use app\models\Bought;
use app\models\DiaryActs;
use app\models\DiaryAte;
use app\models\DiaryDayParams;
use app\models\DiaryDeals;
use app\models\DiaryDish;
use app\models\DiaryDoneDeal;
use app\models\DiaryRecDayParams;
use app\models\Items;
use app\models\MarkGroup;
use app\models\MarkUser;
use app\models\Products;
use app\models\Shop;
use app\models\Source;
use app\models\Tag;
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

                        $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id." and model_id = 1")->all(), 'id', 'id'));

                        $ate_today = [];
                        $sum_kkal = 0;

                        //return var_dump($today_acts);

                        if ($today_acts) {
                            $ate_today = DiaryAte::find()
                                ->where("act_id  IN (" . $today_acts . ")")
                                ->all();
                            $sum_kkal = DiaryAte::find()
                                ->select('SUM(kkal)')
                                ->where("act_id  IN (" . $today_acts . ")")
                                ->scalar();
                        }

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
            
        
            $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id." and model_id = 1")->all(), 'id', 'id'));

            //return var_dump($today_acts);
    
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

            //return var_dump($ate_today);
    
            return $this->renderPartial('eat', ['ate_today' => $ate_today, 'sum_kkal' => $sum_kkal, 'user' => $user]);
        }
        
      
        return $this->renderPartial('error');
       

    }

    /**
     * Удаление съеденного
     * @return string
     * @throws \Exception
     */
    public function actionDeleteAte(){
        if(Yii::$app->getRequest()->getQueryParam('user') && Yii::$app->getRequest()->getQueryParam('ate_id'))  {
            $user = Yii::$app->getRequest()->getQueryParam('user');
            $ate = DiaryAte::findOne(Yii::$app->getRequest()->getQueryParam('ate_id'));
            $act = DiaryActs::findOne($ate->act_id);
            if($ate->delete() && $act->delete())
                return "<span style='color:green; font-size: 15px;'>Запись удалена!</span>";
            else return "<span style='color:darkred; font-size: 15px;'>Ошибка удаления!</span>";

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
                ->where("status = 1 and user_id = $user")
                ->all();

            return $this->renderPartial('tasks', ['tasks_list' => $tasks, 'user' => $user]);
        }

        return $this->renderPartial('error');

    }

    /**
     * Показать текущую задачу
     * @return string
     */
    public function actionShowCurrentTask(){

        $current_hour = date('G', time())+7;
        $task_str = '';

        if(Yii::$app->getRequest()->getQueryParam('user')) {
            $user = Yii::$app->getRequest()->getQueryParam('user');
            $tasks = Task::find()
                ->where("status = 3 and hour = $current_hour and user_id = $user")
                ->all();

            if ($tasks) {
                foreach ($tasks as $task) {
                    $task_str .= $current_hour . ": " . $task->description . "<br>";
                }

                return $task_str;
            }

            return $current_hour . ": " . 'Текущих задач нет!';
        }

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
                $new_task->source_id = 327;
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
     * Параметры сегодня
     * @return string
     */
    public function actionDayParams(){


        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $start_day = strtotime('now 00:00:00');


            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));


            if (Yii::$app->getRequest()->getQueryParam('param_id') && Yii::$app->getRequest()->getQueryParam('val')) {
                
                $act = new DiaryActs();
                $act->model_id = 4;
                $act->user_id = $user->id;
                $act->mark = 0;
                $act->mark_status = 0;

                //return var_dump($act);

                if($act->save(false)) {

                    $rec_day_param = new DiaryRecDayParams();
                    $rec_day_param->day_param_id = (int)Yii::$app->getRequest()->getQueryParam('param_id');
                    $rec_day_param->user_id = $user->id;
                    $rec_day_param->act_id = $act->id;
                    $rec_day_param->value = (float)Yii::$app->getRequest()->getQueryParam('val');
                    //return var_dump($rec_day_param);

                    if ($rec_day_param->save()) {

                        return "<span style='color:green'>Записано!</span>";
                    }
                    else "<span style='color:red'>Ошибка сохранения записи</span>";

                }
                else return "<span style='color:red'>Ошибка валидации</span>";
                
                
                return var_dump(Yii::$app->getRequest()->getQueryParam('val'));
            }


            $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id." and model_id = 4")->all(), 'id', 'id'));

            //return var_dump($today_acts);

            $params = [];
            $recorded_params_in = [];
            $recorded_params = [];
            $recorded = [];


            if ($today_acts) {
                $recorded = DiaryRecDayParams::find()
                    ->where("act_id  IN (" . $today_acts . ")")
                    ->all();

                $param_array = implode(',', ArrayHelper::map($recorded, 'id', 'day_param_id'));


                if($param_array) {
                    $recorded_params_in = DiaryDayParams::find()
                        ->where("id  IN (" . $param_array . ")")
                        ->all();
                    $params = DiaryDayParams::find()
                        ->where("id NOT IN (" . $param_array . ")")
                        ->all();
                }

            }

            else {
                $params = DiaryDayParams::find()
                    ->all();
            }

            //return var_dump($params);


            //$params = DiaryDayParams::find()->all();



            return $this->renderPartial('today_params', ['params' => $params, 'recorded_params' => $recorded , 'user' => $user->id]);
            
            
        }
        
    }

    /**
     * Изменить параметр
     * @return string
     * @throws \Exception
     */
    public function actionChangeParam(){
        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $start_day = strtotime('now 00:00:00');

            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));

            if (Yii::$app->getRequest()->getQueryParam('param_id') && Yii::$app->getRequest()->getQueryParam('val')) {
                $rec_param = DiaryRecDayParams::findOne((int)Yii::$app->getRequest()->getQueryParam('param_id'));
                $rec_param->value = (float)Yii::$app->getRequest()->getQueryParam('val');
                if($rec_param->update())  {
                    $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id." and model_id = 4")->all(), 'id', 'id'));

                    //return var_dump($today_acts);

                    $params = [];
                    $recorded_params_in = [];
                    $recorded_params = [];
                    $recorded =[];


                    if ($today_acts) {
                        $recorded = DiaryRecDayParams::find()
                            ->where("act_id  IN (" . $today_acts . ")")
                            ->all();
                        $param_array = implode(',', ArrayHelper::map($recorded, 'id', 'day_param_id'));


                        if($param_array) {
                            $recorded_params_in = DiaryDayParams::find()
                                ->where("id  IN (" . $param_array . ")")
                                ->all();
                            $params = DiaryDayParams::find()
                                ->where("id NOT IN (" . $param_array . ")")
                                ->all();
                        }

                        foreach ($recorded_params_in as $param) {
                            $recorded_params[DiaryRecDayParams::findOne($param->id)->value] = $param->name;
                        }


                        //return var_dump($recorded_params);
                    }

                    else {
                        $params = DiaryDayParams::find()
                            ->all();
                    }


                    //$params = DiaryDayParams::find()->all();
                    //return var_dump($params);


                    return $this->renderPartial('today_params', ['params' => $params, 'recorded_params' => $recorded , 'user' => $user->id]);

                }

                return 'НЕ получилось';

            }

            //return var_dump($user);
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
     * Дела
     * @return string|void
     */
    public function actionDeals(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $start_day = strtotime('now 00:00:00');


            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));


            if (Yii::$app->getRequest()->getQueryParam('name') &&
                Yii::$app->getRequest()->getQueryParam('mark') !== null && Yii::$app->getRequest()->getQueryParam('cat')) {

                $deal = new DiaryDeals();

               // return   var_dump()

                if(Categories::find()->where("name like '".trim(Yii::$app->getRequest()->getQueryParam('cat')."'"))->one()){
                    //  return var_dump(Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('cat')])->one()->id);
                    $deal->cat_id = Categories::find()->where("name like '".trim(Yii::$app->getRequest()->getQueryParam('cat')."'"))->one()->id;
                }
                else $deal->cat_id = 57;

                $deal->name = Yii::$app->getRequest()->getQueryParam('name');
                $deal->mark = (int)Yii::$app->getRequest()->getQueryParam('mark');
                $deal->status = 0;
                if($deal->save()) {
                    return "<span style='color:green'>Действие сохранено!</span>";
                }

                return var_dump($deal);
            }

           
            $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id)->all(), 'id', 'id'));

            //return var_dump($today_acts);


            $deals = [];
            $sum_mark = 0;
            $deal_cats = [];
            $cat_deal = [];
            
            if ($today_acts) {
                $today_deals = DiaryDoneDeal::find()
                    ->where("act_id IN (" . $today_acts . ")")
                    ->all();
                $sum_mark = DiaryActs::find()
                    ->select('SUM(mark)')
                    ->where("time > $start_day and user_id = ".$user->id)
                    ->scalar();


            foreach ($today_deals as $done_deal) {
                $deals[] = DiaryDeals::findOne($done_deal->deal_id);
                $deal_cats[Categories::findOne($done_deal->deal->cat_id)->name][] = DiaryDeals::findOne($done_deal->deal_id)->mark;
                //return var_dump($done_deal->deal->cat_id);

            }


            foreach ($deal_cats as $cat => $marks){
                $mark = 0;
                foreach ($marks as $mrk) {
                    $mark += $mrk;
                }
                $cat_deal[$cat][] = $mark;
                }


            }

            $all_deals = DiaryDeals::find()->all();
            

            //return var_dump($deals);

            return $this->renderPartial('deals', ['deal_cats' => $cat_deal, 'sum_mark' => $sum_mark ,'user' => $user]);
            }

        return $this->renderPartial('error');

        }

    /**
     * Оценка конкретного пользователя - костыльное решение
     * @return string|void
     */
    public function actionMishichDeals(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $start_day = strtotime('now 00:00:00');


            $user = MarkUser::findOne(11);

            //return var_dump($user);

            if (Yii::$app->getRequest()->getQueryParam('name') &&
                Yii::$app->getRequest()->getQueryParam('mark') !== null &&  Yii::$app->getRequest()->getQueryParam('cat')) {

                $deal = new DiaryDeals();

                // return   var_dump()

                if(Categories::find()->where("name like '".trim(Yii::$app->getRequest()->getQueryParam('cat')."'"))->one()){
                    //  return var_dump(Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('cat')])->one()->id);
                    $deal->cat_id = Categories::find()->where("name like '".trim(Yii::$app->getRequest()->getQueryParam('cat')."'"))->one()->id;
                }
                else $deal->cat_id = 57;

                $deal->name = trim(Yii::$app->getRequest()->getQueryParam('name'));
                $deal->mark = (int)Yii::$app->getRequest()->getQueryParam('mark');
                $deal->status = 0;
                if($deal->save()) {
                    return "<span style='color:green'>Действие сохранено!</span>";
                }

                return var_dump($deal);
            }


            $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id." and model_id = 5")->all(), 'id', 'id'));

            //return var_dump($today_acts);

            $deals = [];
            $sum_mark = 0;
            $deal_cats = [];
            $cat_deal = [];

            if ($today_acts) {
                $today_deals = DiaryDoneDeal::find()
                    ->where("act_id IN (" . $today_acts . ")")
                    ->all();
                $sum_mark = DiaryActs::find()
                    ->select('SUM(mark)')
                    ->where("time > $start_day and user_id = ".$user->id." and model_id = 5")
                    ->scalar();


                foreach ($today_deals as $done_deal) {
                    $deals[] = DiaryDeals::findOne($done_deal->deal_id);
                    $deal_cats[Categories::findOne($done_deal->deal->cat_id)->name][] = DiaryDeals::findOne($done_deal->deal_id)->mark;
                    //return var_dump($done_deal->deal->cat_id);

                }


                foreach ($deal_cats as $cat => $marks){
                    $mark = 0;
                    foreach ($marks as $mrk) {
                        $mark += $mrk;
                    }
                    $cat_deal[$cat][] = $mark;
                }


            }

            $all_deals = DiaryDeals::find()->all();


            //return var_dump($deals);

            return $this->renderPartial('deals', ['deal_cats' => $cat_deal, 'sum_mark' => $sum_mark ,'user' => $user]);
        }

        return $this->renderPartial('error');
        
    }


    /**
     * Сделал дело
     * @return string
     */
    public function actionDoneDeal(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $start_day = strtotime('now 00:00:00');


            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));


            if (Yii::$app->getRequest()->getQueryParam('deal')) {

                try {
                    $deal = DiaryDeals::find()->where("name like '". trim(Yii::$app->getRequest()->getQueryParam('deal')) ."'")->one();
                } catch (\ErrorException $e) {
                    $deal = [];
                }
                if(!$deal) return 'Ошибка!';
                //return var_dump($deal);

                $act = new DiaryActs();
                $act->model_id = 5;
                $act->user_id = $user->id;
                $act->mark = $deal->mark;
                $act->mark_status = 0;

                //return var_dump($act);
                if($act->save(false)){
                    $done_deal = new DiaryDoneDeal();
                    $done_deal->deal_id = $deal->id;
                    $done_deal->act_id = $act->id;
                    $done_deal->user_id = $user->id;

                    //return var_dump($done_deal);

                    if($done_deal->save()){
                        $today_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id)->all(), 'id', 'id'));

                        $deals = [];
                        $sum_mark = 0;
                        $deal_cats = [];
                        $cat_deal = [];

                        if ($today_acts) {
                            $today_deals = DiaryDoneDeal::find()
                                ->where("act_id IN (" . $today_acts . ")")
                                ->all();
                            $sum_mark = DiaryActs::find()
                                ->select('SUM(mark)')
                                ->where("time > $start_day and user_id = ".$user->id)
                                ->scalar();


                            foreach ($today_deals as $done_deal) {
                                $deals[] = DiaryDeals::findOne($done_deal->deal_id);
                                $deal_cats[Categories::findOne($done_deal->deal->cat_id)->name][] = DiaryDeals::findOne($done_deal->deal_id)->mark;
                                //return var_dump($done_deal->deal->cat_id);

                            }


                            foreach ($deal_cats as $cat => $marks){
                                $mark = 0;
                                foreach ($marks as $mrk) {
                                    $mark += $mrk;
                                }
                                $cat_deal[$cat][] = $mark;
                            }


                        }

                        $all_deals = DiaryDeals::find()->all();


                        //return var_dump($deals);

                        return $this->renderPartial('deals', ['deal_cats' => $cat_deal, 'sum_mark' => $sum_mark ,'user' => $user]);
                    }

                    return $this->renderPartial('error');
                }

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
     * Список песен репертуара
     * @return string
     * @throws \Exception
     */
    public function actionRepertoire(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

           // $user = Yii::$app->getRequest()->getQueryParam('user');

            if(Items::find()->where(['is_next' => 1])->one()){
                $item = Items::find()->where(['is_next' => 1])->one();
                $song_id = $item->id;
            }

            else $song_id = 1;

            //return $song_id;

            $songs = Items::find()->where("(cat_id = 90 or cat_id = 89) and id >= $song_id")
                ->orderBy('id ASC')
                ->all();

            if(count($songs) == 1) {
                $songs[0]->is_next = 0;
                $songs[0]->update(false);
            }
            
            return $this->renderPartial('repertoire', ['songs' =>  $songs]);

        }


    }

    /**
     * Метка "следующая песня"
     * @return string
     * @throws \Exception
     */
    public function actionSaveNextSong(){
        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $user = Yii::$app->getRequest()->getQueryParam('user');

            if(Yii::$app->getRequest()->getQueryParam('id')) {

                if(Items::find()->where(['is_next' => 1])->one()){
                    $item = Items::find()->where(['is_next' => 1])->one();
                    $item->is_next = 0;
                    $item->update(false);
                }

                $item = Items::findOne((int)Yii::$app->getRequest()->getQueryParam('id'));
                $item->is_next = 1;
                $item->update(false);

                return "<p>Следующий $item->title, сказал заведующий! </p>";

            }
        }
    }

    /**
     * Запись айтема
     * @return string|void
     */
    public function actionRecordItem(){
        if(Yii::$app->getRequest()->getQueryParam('user')) {
            
            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));

            if(Yii::$app->getRequest()->getQueryParam('source') &&
                Yii::$app->getRequest()->getQueryParam('tags') &&
                Yii::$app->getRequest()->getQueryParam('cat') &&
                Yii::$app->getRequest()->getQueryParam('txt') &&
                Yii::$app->getRequest()->getQueryParam('title')) {

                //return var_dump(Yii::$app->getRequest()->getQueryParam('txt'));



                $act = new DiaryActs();
                $act->model_id = 7;
                $act->user_id = $user->id;
                $act->mark = 1;



                if($act->save(false)) {
                    $item = new Items();

                    $item->text = Yii::$app->getRequest()->getQueryParam('txt');
                    $item->tags = Yii::$app->getRequest()->getQueryParam('tags');
                    $item->title = Yii::$app->getRequest()->getQueryParam('title');

                   // return var_dump($item);



                    if(Categories::find()->where("name like '".trim(Yii::$app->getRequest()->getQueryParam('cat')."'"))->one()){
                        //  return var_dump(Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('cat')])->one()->id);
                        $item->cat_id = Categories::find()->where("name like '".trim(Yii::$app->getRequest()->getQueryParam('cat')."'"))->one()->id;
                    }
                    else return "Категория!";


                    $item->in_work_prim = '';
                    $item->play_status = 1;


                    if(Source::find()->where("title like '".Yii::$app->getRequest()->getQueryParam('source')."'")->one()){
                       // return var_dump(Source::find()->where(['title' => Yii::$app->getRequest()->getQueryParam('source')])->one()->id);
                        $item->source_id = Source::find()->where("title like '".trim(Yii::$app->getRequest()->getQueryParam('source')."'"))->one()->id;
                    }
                    else return var_dump($item);
                    $item->act_id = $act->id;
                    //return var_dump($item);

                    if($item->save(false)) {
                        Tag::addTags($item->tags, $item->id);
                    }
                }

                return "<p>Сохранено!</p>";


            }

            return $this->renderPartial('add_item');
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
     * Дела для автокомплита
     * @return string
     */
    public function actionDealsList(){
        $res = [];

        $m = DiaryDeals::find()->all();

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

    /**
     * Категории дел для автокомплита
     * @return string
     */
    public function actionDealCats(){
        $res = [];

        $m = Categories::find()->where(['site_id' => 13])->all();

        foreach ($m as $h){
            $res[] = $h->name;

        }

        return  json_encode($res);
    }

    /**
     * Категории дел для автокомплита
     * @return string
     */
    public function actionSources(){
        $res = [];

        $m = Source::find()->all();

        foreach ($m as $h){
            $res[] = $h->title;

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