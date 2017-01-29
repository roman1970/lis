<?php

namespace app\modules\rockncontroll\controllers;


use app\components\FrontEndController;
use app\components\Helper;
use app\models\ArticlesContent;
use app\models\Bought;
use app\models\DiaryActs;
use app\models\DiaryAte;
use app\models\DiaryDayParams;
use app\models\DiaryDeals;
use app\models\DiaryDish;
use app\models\DiaryDoneDeal;
use app\models\DiaryRecDayParams;
use app\models\Event;
use app\models\Idea;
use app\models\Income;
use app\models\Incomes;
use app\models\Items;
//use app\models\MarkGroup;
use app\models\Log;
use app\models\MarkUser;
use app\models\NsbNews;
use app\models\Products;
use app\models\Shop;
use app\models\Snapshot;
use app\models\SongText;
use app\models\Source;
use app\models\Tag;
use app\models\Task;
use app\models\Tasked;
use app\models\TeamSum;
use app\models\TelBasemts;
use app\models\TestAnswers;
use app\models\Weathernew;
use app\modules\currency\models\CurrHistory;
use app\modules\diary\models\Maner;
use app\modules\diary\models\Telbase;
use Yii;
use app\models\Categories;
//use yii\data\Pagination;

use app\models\Articles;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\sphinx\Query;
use yii\sphinx\MatchExpression;


class DefaultController extends FrontEndController
{
    public $current_user;
    public $choosen_songs = [];
    public $rand_tag = [];
    public $songs;

    /**
     * @return string
     */
    public function actionIndex(){

        $denzh = time() - mktime(0, 0, 0, 5, 3, 70) + 9*60*60;
        $denzhisni = round(($denzh / 3600 / 24), 0);

       return $this->render('index', ['denzhisni' => $denzhisni]);

    }

    /**
     * Съел
     * @return string
     */
    public function actionEat(){

        $start_day = strtotime('now 00:00:00', time()+7*60*60);

        
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
                ->orderBy('id DESC')
                ->all();

            return $this->renderPartial('tasks', ['tasks_list' => $tasks, 'user' => $user]);
        }

        return $this->renderPartial('error');

    }

    /**
     * Показать текущие актуальные данные
     * @return string
     */
    public function actionShowCurrentTask(){

        $current_hour = date('G', time())+7;
        $current_day_of_year = date('z', time())+7;
        //$current_day_of_year = 365;
        $day_number_first_sept = date('z', mktime(0, 0, 0, 1, 1, 2017))+7;
        //$day_number_first_sept = 122;
        $first_sept_time = mktime(0, 0, 0, 1, 1, 2017) + 7*60*60;
       
        //return date('Y-m-d H', $first_sept_time);
        $first_sept_act = DiaryActs::find()->where("time > $first_sept_time")->one();


        //return $first_sept_act->id;
        $task_str = '';

        if(Yii::$app->getRequest()->getQueryParam('user')) {
            $user = Yii::$app->getRequest()->getQueryParam('user');
            $tasks = Task::find()
                ->where("status = 3 and hour = $current_hour and user_id = $user")
                ->all();

            $spent = Bought::find()
                ->select('SUM(spent)')
                ->where("act_id > $first_sept_act->id")
                ->scalar();

            $incomes = Incomes::find()
                ->select('SUM(money)')
                ->where("act_id > $first_sept_act->id")
                ->andWhere("income_id IN (3,4,6,16)")
                ->scalar();
            

            $days_from_first_sept_to_today = $current_day_of_year - $day_number_first_sept + 1;
            
            $avg_spent_day = round($spent/$days_from_first_sept_to_today, 2);

            $avg_incomes_day = round($incomes/$days_from_first_sept_to_today, 2);
            
            
            /*
            $sum_kt = Maner::find()
                ->select('SUM(kt)')
                ->where(['year' => 2016])
                ->scalar();
            */
            $sum_kt = 0;
            $sum_tochka = DiaryDoneDeal::find()
                ->select('COUNT(id)')
                ->where(['deal_id' => 30])
                ->andWhere("act_id > $first_sept_act->id")
                ->scalar();

            /*средний вес из старой базы
            $sum_weight = Maner::find()
                ->select('SUM(weigth)')
                ->where(['year' => 2016])
                ->scalar();
            $day_count_of_year = Maner::find()
                ->select('COUNT(id)')
                ->where(['year' => 2016])
                ->scalar();
            */

            $weight = DiaryRecDayParams::find()
                ->select('AVG(value)')
                ->where(['day_param_id' => 1])
                ->andWhere("act_id >= 13129")
                ->scalar();

            $sum_mark = DiaryActs::find()
                ->select('SUM(mark)')
                ->where("user_id = 8 and time > ".mktime(0,0,0,1,1,2017))
                ->scalar();
            //return $sum_mark;

            //$first_day = DiaryActs::findOne(1);
            
            $avg_oz = round($sum_mark/$this->daysFromTwoTimes(mktime(0,0,0,1,1,2017), strtotime('today')),2);
            //return date('D',$first_day->time);

            try {
                $kt = round($current_day_of_year / ($sum_kt + $sum_tochka), 1);
            } catch (\ErrorException $e) {
                $kt = 0;
            }
            $we = round($weight, 2);




            //return "Коэффициент T ".round($current_day_of_year/($sum_kt + $sum_tochka), 1)."
            //<br> Средний вес конца года ". round($weight, 2);
            
            return $this->renderPartial('actual_datas', ['kt' => $kt, 
                'we' => $we, 
                'avg_oz' => $avg_oz, 
                'avg_spent_day' => $avg_spent_day,
                'avg_incomes_day' => $avg_incomes_day,
              //  'thoughts' => $thoughts
            ]);

            /*
            Текущие задачи не выводим

            if ($tasks) {
                foreach ($tasks as $task) {
                    $task_str .= $current_hour . ": " . $task->description . "<br>";
                }

                return $task_str;
            }

            return $current_hour . ": " . 'Текущих задач нет!';
            */
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
                            ->orderBy('id DESC')
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

            $start_day = strtotime('now 00:00:00', time()+7*60*60);
            //return date('D G:i', $start_day);


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

            $start_day = strtotime('now 00:00:00', time()+7*60*60);

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
    
    public function actionUpload(){

        return 'kkk';
    }

    /**
     * Дела
     * @return string|void
     */
    public function actionDeals(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $start_day = strtotime('now 00:00:00', time()+7*60*60);


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

                $deal->name = trim(Yii::$app->getRequest()->getQueryParam('name'));
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
            $money = 0;
            
            if ($today_acts) {
                $today_deals = DiaryDoneDeal::find()
                    ->where("act_id IN (" . $today_acts . ")")
                    ->all();
                $sum_mark = DiaryActs::find()
                    ->select('SUM(mark)')
                    ->where("time > $start_day and user_id = ".$user->id)
                    ->scalar();
                $mark_accumul = DiaryActs::find()
                    ->select('SUM(mark)')
                    ->where("time > ".mktime(0,0,0,9,1,2016)." and user_id = ".$user->id)
                    ->scalar();
                $users_money = MarkUser::findOne(11)->money;
                $money = $mark_accumul + $users_money;


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

            //$all_deals = DiaryDeals::find()->all();
            

            //return var_dump($deals);

            return $this->renderPartial('deals', ['deal_cats' => $cat_deal, 'sum_mark' => $sum_mark ,'user' => $user, 'money' => $money]);
            }

        return $this->renderPartial('error');

        }

    /**
     * Оценка конкретного пользователя - костыльное решение
     * @return string|void
     */
    public function actionMishichDeals(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $start_day = strtotime('now 00:00:00', time()+7*60*60);


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
            $money = 0;

            if ($today_acts) {
                $today_deals = DiaryDoneDeal::find()
                    ->where("act_id IN (" . $today_acts . ")")
                    ->all();
                $sum_mark = DiaryActs::find()
                    ->select('SUM(mark)')
                    ->where("time > $start_day and user_id = ".$user->id." and model_id = 5")
                    ->scalar();
                $mark_accumul = DiaryActs::find()
                    ->select('SUM(mark)')
                    ->where("time > ".mktime(0,0,0,9,1,2016)." and user_id = ".$user->id)
                    ->scalar();
                $users_money = MarkUser::findOne(11)->money;
                $money = $mark_accumul + $users_money;


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

            return $this->renderPartial('deals', ['deal_cats' => $cat_deal, 'sum_mark' => $sum_mark ,'user' => $user, 'money' => $money]);
        }

        return $this->renderPartial('error');
        
    }


    /**
     * Сделал дело
     * @return string
     */
    public function actionDoneDeal(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $start_day = strtotime('now 00:00:00', time()+7*60*60);


            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));


            if (Yii::$app->getRequest()->getQueryParam('deal')) {

                try {
                    $deal = DiaryDeals::find()->where("name like '".trim(Yii::$app->getRequest()->getQueryParam('deal'))."'")->one();
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
                            $mark_accumul = DiaryActs::find()
                                ->select('SUM(mark)')
                                ->where("time > ".mktime(0,0,0,9,1,2016)." and user_id = ".$user->id)
                                ->scalar();
                            $users_money = MarkUser::findOne(11)->money;
                            $money = $mark_accumul + $users_money;


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

                        return $this->renderPartial('deals', ['deal_cats' => $cat_deal, 'sum_mark' => $sum_mark ,'user' => $user, 'money' => $money]);
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

        $start_day = strtotime('now 00:00:00', time()+7*60*60);

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $user = Yii::$app->getRequest()->getQueryParam('user');

            if(Yii::$app->getRequest()->getQueryParam('product') &&
                Yii::$app->getRequest()->getQueryParam('measure') &&
                Yii::$app->getRequest()->getQueryParam('shop')) {


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
                    if(Yii::$app->getRequest()->getQueryParam('measure'))
                        $bought->spent = (float)Yii::$app->getRequest()->getQueryParam('measure');
                    else $bought->spent = 0;
                    if(Yii::$app->getRequest()->getQueryParam('item'))
                        $bought->item_price = (float)Yii::$app->getRequest()->getQueryParam('item');
                    else $bought->item_price = 0;

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

            $songs = Items::find()->where("(cat_id = 90 or cat_id = 89) and id >= $song_id and published = 1")
                ->orderBy('id ASC')
                ->all();
            
           /*$thoughts = Items::find()->where("(source_id = 27 or source_id = 17) and id >= $song_id")
               ->orderBy('id ASC')
               ->all();
           */

            //var_dump($thoughts); exit;
            
            

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
     * Сброс очереди репертуара
     * @return string
     */
    public function actionFrash(){
        if(Yii::$app->getRequest()->getQueryParam('user')) {

                if(Items::find()->where(['is_next' => 1])->one()){
                    $item = Items::find()->where(['is_next' => 1])->one();
                    $item->is_next = 0;
                    $item->update(false);


                    $first_song = Items::find()->where("(cat_id = 90 or cat_id = 89)")
                        ->orderBy('id ASC')
                        ->one();
                    $first_song->is_next = 1;
                    $item->update(false);


                return "<p>Очередь сброшена!</p>";

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

               // return nl2br(Yii::$app->getRequest()->getQueryParam('txt'));


                $act = new DiaryActs();
                $act->model_id = 7;
                $act->user_id = $user->id;
                $act->mark = 1;


                if($act->save(false)) {
                    $item = new Items();

                    $item->text = Yii::$app->getRequest()->getQueryParam('txt');
                    $item->tags = Yii::$app->getRequest()->getQueryParam('tags');
                    $item->title = Yii::$app->getRequest()->getQueryParam('title');
                    $item->cens = Yii::$app->getRequest()->getQueryParam('cens');
                    $item->published = Yii::$app->getRequest()->getQueryParam('published');

                   // return var_dump($item);
                    if(Yii::$app->getRequest()->getQueryParam('old_data'))
                        $item->old_data = Yii::$app->getRequest()->getQueryParam('old_data');


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
     * Идеи для автокомплита
     * @return string
     */
    public function actionIdeas(){
        $res = [];

        $m = Idea::find()->all();

        foreach ($m as $h){
            $res[] = $h->title;

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

    public function actionShopsProductsCats(){
        $res = [];

        $shops = Shop::find()->all();
        $products = Products::find()->all();
        $cats = Categories::find()->where(['site_id' => 11])->all();

        foreach ($shops as $shop){
            $res[] = $shop->name;

        }
        foreach ($products as $product){
            $res[] = $product->name;
        }
        foreach ($cats as $cat){
            $res[] = $cat->title;
        }

        return  json_encode($res);
    }

    /**
     * Приходы для автокомплита
     * @return string
     */
    public function actionIncome(){
        $res = [];

        $m = Income::find()->all();

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
     * Приходы
     * @return string
     */
    public function actionIncomes(){
        if(Yii::$app->getRequest()->getQueryParam('user')) {

           // $start_day = strtotime('now 00:00:00');


            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));
            
            if(!$user) return 'Доступ запрещен!';


            if (Yii::$app->getRequest()->getQueryParam('name') &&
                Yii::$app->getRequest()->getQueryParam('value') !== null ) {
                
                if(Income::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('name')]))
                    $income = Income::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('name')])->one();
                else return 'Ошибка при наборе';

                $act = new DiaryActs();
                $act->model_id = 9;
                $act->user_id = $user->id;

                //return var_dump($act);
                
                if($act->save(false)){
                    $incomes = new Incomes();

                    try {
                        $incomes->income_id = $income->id;
                    } catch (\ErrorException $e) {
                        return 'Такой статьи в базе нет!';
                    }

                    $incomes->act_id = $act->id;
                    $incomes->user_id = $act->user_id;
                    $incomes->money = (float)Yii::$app->getRequest()->getQueryParam('value');
                   

                    if(!$incomes->validate()) {
                        return 'Данные введены некорректно';
                    }
                    else{
                        if($incomes->save()) {
                            $all_incomes_grouped = Incomes::find()
                                ->select(['income_id, COUNT(*) as cnt, SUM(money) as sum '])
                                ->groupBy('income_id')
                                ->orderBy('sum DESC')
                                ->all();
                            //var_dump($all_incomes_grouped);

                            $not_curr_sum = Incomes::find()
                                ->select('SUM(money)')
                                ->where("income_id  IN (1,2,7,10)")
                                ->scalar();
                            $dollar = Incomes::find()
                                ->select('SUM(money)')
                                ->where("income_id  = 8")
                                ->scalar();
                            $euro = Incomes::find()
                                ->select('SUM(money)')
                                ->where("income_id  = 9")
                                ->scalar();
                            $bal_sum = $not_curr_sum + Helper::currencyAdapter($dollar, 11) + Helper::currencyAdapter($euro, 12);


                            return $this->renderPartial('all_incomes', ['user' => $user, 'incomes' => $all_incomes_grouped, 'bal_sum' => $bal_sum]);

                        }
                        else return 'Ошибка сохранения';
                        }
                    }
                }

            $all_incomes_grouped = Incomes::find()
                ->select(['income_id, COUNT(*) as cnt, SUM(money) as sum '])
                ->groupBy('income_id')
                ->orderBy('sum DESC')
                ->all();
            //var_dump($all_incomes_grouped);
            
            $not_curr_sum = Incomes::find()
                ->select('SUM(money)')
                ->where("income_id  IN (1,2,7,10)")
                ->scalar();
            $dollar = Incomes::find()
                ->select('SUM(money)')
                ->where("income_id  = 8")
                ->scalar();
            $euro = Incomes::find()
                ->select('SUM(money)')
                ->where("income_id  = 9")
                ->scalar();
            $bal_sum = $not_curr_sum + Helper::currencyAdapter($dollar,11) + Helper::currencyAdapter($euro,12);
            //sreturn Helper::currencyAdapter($dollar, 11);

            return $this->renderPartial('income', ['user' => $user, 'incomes' => $all_incomes_grouped, 'bal_sum' => $bal_sum]);


        }

        else return 'Ошибка';
    }

    /**
     * Добавление события
     * @return string
     */
    public function actionEvents(){
        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $start_day = strtotime('now 00:00:00', time()+7*60*60);


            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));

            if (!$user) return 'Доступ запрещен!';


            if (Yii::$app->getRequest()->getQueryParam('text') &&
                Yii::$app->getRequest()->getQueryParam('cat')) {


                if(Categories::find()->where("name like '".trim(Yii::$app->getRequest()->getQueryParam('cat')."'"))->one()){
                    $cat_id = Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('cat')])->one()->id;
                    //$item->cat_id = Categories::find()->where("name like '".trim(Yii::$app->getRequest()->getQueryParam('cat')."'"))->one()->id;
                }
                else return "Категория!";

                $act = new DiaryActs();
                $act->model_id = 10;
                $act->user_id = $user->id;

                //return var_dump($act);

                if($act->save(false)){
                    $event = new Event();
                    $event->act_id = $act->id;
                    $event->cat_id = $cat_id;

                    if(Yii::$app->getRequest()->getQueryParam('old_data_ev'))
                        $event->old_data = Yii::$app->getRequest()->getQueryParam('old_data_ev');

                    $event->user_id = $act->user_id;
                    $event->text = Yii::$app->getRequest()->getQueryParam('text');

                    if(!$event->validate()) {
                        return 'Данные введены некорректно';
                    }
                    else{
                        if($event->save()) {

                            return "<p>Событие сохранено!</p>";
                        }
                        else return 'Ошибка сохранения';
                    }
                }

            }

            $today_event_acts = implode(',', ArrayHelper::map(DiaryActs::find()->where("time > $start_day and user_id = ".$user->id." and model_id = 10")->all(), 'id', 'id'));

            $today_event = [];
           
            //return var_dump($today_event_acts);

            if ($today_event_acts) {
                $today_event = Event::find()
                    ->where("act_id  IN (" . $today_event_acts . ")")
                    ->orderBy('id DESC')
                    ->andWhere(["old_data" => 0])
                    ->all();
            }

            //return var_dump($today_event);
            

            return $this->renderPartial('add_event', ['user' => $user, 'today_event' => $today_event]);
        }
    }

    /**
     * Закладки
     * @return string
     * @throws \Exception
     */
    public function actionMarkers(){

        $current_hour = date('G', time()+7*60*60);
        //return $current_hour;


        switch ($current_hour) {
            case 6:
                $cat = 136;
                break;
            case 7:
                $cat = 116;
                break;
            case 8:
                $cat = 116;
                break;
            case 9:
                $cat = 116;
                break;
            case 10:
                $cat = 202;
                break;
            case 11:
                $cat = 202;
                break;
            case 12:
                $cat = 116;
                break;
            case 13:
                $cat = 116;
                break;
            case 14:
                $cat = 116;
                break;
            case 15:
                $cat = 116;
                break;
            case 18:
                $cat = 114;
                break;
            case 19:
                $cat = 114;
                break;
            default:
                $cat = 53;
        }

       //return $cat;


        if(Yii::$app->getRequest()->getQueryParam('user')) {
            
            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));
            if (!$user) return 'Доступ запрещен!';
            
            if (Yii::$app->getRequest()->getQueryParam('id') && Yii::$app->getRequest()->getQueryParam('mark')) {

                //return var_dump((int)Yii::$app->getRequest()->getQueryParam('id'));
               
                $update_source = Source::findOne((int)Yii::$app->getRequest()->getQueryParam('id'));
                $update_source->marker = Yii::$app->getRequest()->getQueryParam('mark');
                $update_source->is_next = 0;
                $update_source->update(false);

                if($update_source->id == 1276) return "<h4 style='text-align: center; color: white;'>Закладка сохранена!</h4>";

                //return var_dump($update_source);
                
                if($cat == 136) {
                    $next_source = Source::find()
                        ->where("id > $update_source->id and (cat_id = 136 or cat_id = 113) ")
                        ->one();
                }

                else{
                    $next_source = Source::find()
                        ->where("id > $update_source->id and cat_id = $cat ")
                        ->one();
                }


                if(!$next_source) {
                    $next_source = Source::find()
                        ->where("cat_id = $cat")
                        ->one();
                    if(!$next_source) {
                        return "Категория!";
                    }
                }
                $next_source->is_next = 1;
                //return var_dump($next_source);
                $next_source->update(false);

                return $this->renderPartial('source', ['source' => $next_source, 'user' => $user]);
            }

            if($cat == 136) {
                $source = Source::find()
                    ->where("(cat_id = 136 or cat_id = 113) and is_next = 1")
                    ->one();
            }
            
            else {
                $source = Source::find()
                    ->where("cat_id = $cat and is_next = 1")
                    ->one();
            }

                return $this->renderPartial('source', ['source' => $source, 'user' => $user]);
            }

            return 'нет!';
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
    
    private function daysFromTwoTimes($begin, $end){
        return round((($end-$begin)/(24*60*60)),0,PHP_ROUND_HALF_UP)+1;
    }
    
    public function actionWeather(){
        //$cities = [4081, 31763, 10854, 22890, 3821];
      
        $weather[3] = Weathernew::find()
            ->where(['city_id' => 4081])
            ->orderBy('id DESC')
            ->one();
        $weather[1] = Weathernew::find()
            ->where(['city_id' => 31763])
            ->orderBy('id DESC')
            ->one();
        $weather[] = Weathernew::find()
            ->where(['city_id' => 10854])
            ->orderBy('id DESC')
            ->one();
        $weather[] = Weathernew::find()
            ->where(['city_id' => 22890])
            ->orderBy('id DESC')
            ->one();
        $weather[] = Weathernew::find()
            ->where(['city_id' => 3821])
            ->orderBy('id DESC')
            ->one();

        return $this->renderPartial('weather', ['weather' => $weather]);

    }

    /**
     * Поиск Sphinx айтемов, событий и новостей
     * @return string
     */
    function actionSearch()
    {

        if (Yii::$app->getRequest()->getQueryParam('user')) {
            

            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));

            if (!$user) return 'Доступ запрещен!';


            if (Yii::$app->getRequest()->getQueryParam('text')) {

                $items_records = [];
                $events_records = [];
                $news_records = [];
               
                $query  = new Query();
                // $search_result = $query_search->from('siteSearch')->match($q)->all();  // поиск осуществляется по средством метода match с переданной поисковой фразой.
                $query_items_ids = $query->from('items')
                    ->match(Yii::$app->getRequest()->getQueryParam('text'))
                    ->all();


                foreach ($query_items_ids as $arr_item_rec){
                    foreach ($arr_item_rec as $id){
                        $items_records[] = Items::findOne((int)$id);
                    }
                }

                //return var_dump($items_records);
                    //return $this->renderPartial('searched', ['items_rows' => $items_records, 'events_rows' => 2]);

                $query_events_ids = $query->from('events')
                      ->match(Yii::$app->getRequest()->getQueryParam('text'))
                      ->all();

                  foreach ($query_events_ids as $arr_event_rec){

                      foreach ($arr_event_rec as $id) {
                          $events_records[] = Event::findOne((int)$id);
                      }
                  }

                $query_news_ids = $query->from('news')
                    ->match(Yii::$app->getRequest()->getQueryParam('text'))
                    ->all();

                foreach ($query_news_ids as $arr_new_rec){

                    foreach ($arr_new_rec as $id) {
                        $news_records[] = NsbNews::findOne((int)$id);
                    }
                }


                sort($events_records);
                krsort($events_records);
                //var_dump($query_news_ids); exit;

                $ideas = Idea::find()->all();

                return $this->renderPartial('searched', ['items_rows' => (is_array($items_records) && !empty($items_records) && $items_records) ? $items_records : 'Ничего не найдено',
                    'events_rows' => (is_array($events_records) && !empty($events_records) && $events_records) ? $events_records : 'Ничего не найдено',
                    'news_rows' => (is_array($news_records) && !empty($news_records) && $news_records) ? $news_records : 'Ничего не найдено',
                    'ideas' => $ideas]);

            }


            return $this->renderPartial('search_form');

        }
    }

    /**
     * Поиск Sphinx в статьях 
     * @return string
     */
    function actionArticleSearch(){
        if (Yii::$app->getRequest()->getQueryParam('user')) {


            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));

            if (!$user) return 'Доступ запрещен!';


            if (Yii::$app->getRequest()->getQueryParam('text')) {

                $articles_records = [];

                $query  = new Query();
                // $search_result = $query_search->from('siteSearch')->match($q)->all();  // поиск осуществляется по средством метода match с переданной поисковой фразой.
                $query_articles_ids = $query->from('articles')
                    ->match(Yii::$app->getRequest()->getQueryParam('text'))
                    ->all();

                foreach ($query_articles_ids as $arr_articles_rec){
                    foreach ($arr_articles_rec as $id){
                        $articles_records[] = ArticlesContent::findOne((int)$id);
                    }
                }
                

                //  var_dump(Items::findOne($r)); exit;

                return $this->renderPartial('articles_searched', ['articles_rows' => (is_array($articles_records) && !empty($articles_records)) ? $articles_records : 'Ничего не найдено']);

            }


            return $this->renderPartial('article_search_form');

        }
        
    }


    /***
     * Случайный айтем
     * @return mixed
     */
    function actionRandItem(){
        //return 45;
        $thoughts = Items::find()
            //->where("source_id = 27 or source_id = 17 or
            //source_id = 37 or source_id = 336 or source_id = 528 or cat_id = 104 or cat_id = 94")
                ->where('NOT `cat_id` IN (89,90)')
            ->orderBy('id ASC')
            ->all();
        $rand_thought = $thoughts[rand(0, count($thoughts)-1)];
        return $rand_thought->text;
    }

    /**
     * Обновление напоминалки
     * @return string
     */
    function  actionRecRemind(){

        if(Yii::$app->getRequest()->getQueryParam('user')) {

            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));

            //if()return Yii::$app->getRequest()->getQueryParam('text');

            if (Yii::$app->getRequest()->getQueryParam('txt')) {
                $reminder = fopen("/home/romanych/public_html/plis/basic/data/reminder.txt", "w");
                $res = fwrite($reminder, Yii::$app->getRequest()->getQueryParam('txt'));
                fclose($reminder);
                if($res) return 'Записано!';
                else return 'Ошибка!';
            }


            try {
                $text = file_get_contents("/home/romanych/public_html/plis/basic/data/reminder.txt");
            } catch (\ErrorException $e) {
                return $e->getMessage();
            }


            return $this->renderPartial('form_reminder', ['user' => $user, 'note' => $text]);
        }
    }

    /**
     * Напоминалка
     * @return string
     */
    function actionRemind(){
        return file_get_contents("/home/romanych/public_html/plis/basic/data/reminder.txt");
    }

    /***
     * Вывод количества соединений оператора сотовой связи
     * @return string
     */
    function actionTelephone(){
        if(Yii::$app->getRequest()->getQueryParam('user')) {
            //return Yii::$app->getRequest()->getQueryParam('user');

            $user = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));

            try {
                $tells = TelBasemts::find()
                    ->select(['id, nom_tel, COUNT(*) as cnt'])
                    ->where(['user_id' => 8])
                    ->groupBy('nom_tel')
                    ->orderBy('cnt DESC')
                    ->limit(50)
                    ->all();
            } catch (\ErrorException $e) {
                return $e->getMessage();
            }
            //return var_dump($tells);

            return $this->renderPartial('telephone', ['user' => $user, 'tells' => $tells]);
        }
    }

    /**
     * Вывод главных валют
     * @return string
     */
    function actionGetCurrency(){
        return '$'.round(Helper::currencyAdapter(1, 11), 2). ' &euro;' . round(Helper::currencyAdapter(1, 12), 2) . ' ';

    }
    
    function actionLogs(){

        $logs = Log::find()
            ->where("ip NOT IN('192.168.1.1', '127.0.0.1', '213.87.126.229')")
            ->orderBy('id DESC')
            ->limit(50)
            ->all();

        return $this->renderPartial('logs', ['logs' => $logs]);
        
    }

    /**
     * Для выбора и прослушивания музыки
     * @return string
     */
    function actionMusic(){
        if($user = Yii::$app->getRequest()->getQueryParam('user')) {

            if (!$user) return 'Доступ запрещен!';

            $learn_source = Source::findOne(1276);


             if (Yii::$app->getRequest()->getQueryParam('theme_song')) {

                //$theme = Yii::$app->getRequest()->getQueryParam('theme_song');

                 $arr_theme = explode(',', Yii::$app->getRequest()->getQueryParam('theme_song'));

                 if(!empty($arr_theme))
                     $this->songs = [];

                     foreach ($arr_theme as $theme) {

                         $query = new Query();

                         $songs_ids = $query->from('songtexts')
                             ->match($theme)
                             ->all();

                         foreach ($songs_ids as $arr_item_rec) {
                             foreach ($arr_item_rec as $id) {
                                 $this->songs[] = SongText::findOne((int)$id);
                             }
                         }
                     }

                     //return var_dump($arr);

                 return $this->renderPartial('songs', ['songs' => $this->songs, 'source' => $learn_source]);

                 //else  return $this->renderPartial('songs', ['song' => SongText::findOne(2)]);
             }



            $songs = [];


            $query = new Query();

            $songs_ids = $query->from('songtexts')
                ->match('new year')
                ->all();

            foreach ($songs_ids as $arr_item_rec) {
                foreach ($arr_item_rec as $id) {
                    $songs[] = SongText::findOne((int)$id);
                }
            }

            return $this->renderPartial('songs', ['songs' => $songs, 'source' => $learn_source]);


        }



    }

    /**
     * Случайный объект из набора объектов
     * @param $set_of_obj
     * @return mixed
     */
    static function  randObjFromSetOfObj($set_of_obj){
        return $set_of_obj[rand(0, count($set_of_obj)-1)];

    }

    /**
     * Выборка для случайного концерта
     * @return string
     */
    function actionConcert(){
        if($user = Yii::$app->getRequest()->getQueryParam('user')) {
            
            if(!$user) return 'Доступ запрещн!';

            // $user = Yii::$app->getRequest()->getQueryParam('user');

            if(Items::find()->where(['is_next' => 1])->one()){
                $item = Items::find()->where(['is_next' => 1])->one();
                $song_id = $item->id;
            }

            else $song_id = 100;

            $songs = [];

            //return $song_id;

            $songs1 = Items::find()->where("(source_id = 6 or source_id = 40) and id < $song_id and published = 1")
                ->limit(5)
                ->orderBy('id DESC')
                ->all();
            $songs2 = Items::find()->where("(source_id = 19 or source_id = 41) and id < $song_id and published = 1")
                ->limit(5)
                ->orderBy('id DESC')
                ->all();
            $songs3 = Items::find()->where("source_id = 38 and id < $song_id and published = 1")
                ->limit(5)
                ->orderBy('id DESC')
                ->all();
            $songs4 = Items::find()->where("(source_id = 29 or source_id = 326 or source_id = 526) and id < $song_id and published = 1")
                ->limit(1)
                ->orderBy('id DESC')
                ->all();

            $songs = array_merge($songs1,$songs2,$songs3,$songs4);
            shuffle($songs);

            //return var_dump($songs);

            //$choosen_songs = [];

            foreach ($songs as $song){
                try {

                    $items_records = [];


                    $tags = explode(',',$song->tags);
                    $rand_tag = $tags[mt_rand(0, count($tags)-1)];

                    $this->rand_tag[] = $rand_tag;

                    $query  = new Query();
                    // $search_result = $query_search->from('siteSearch')->match($q)->all();  // поиск осуществляется по средством метода match с переданной поисковой фразой.
                    $query_items_ids = $query->from('items')
                        ->match($rand_tag)
                        ->all();

                    //return var_dump($query_items_ids);

                    foreach ($query_items_ids as $arr_item_rec){
                        foreach ($arr_item_rec as $id){

                            $item = Items::findOne((int)$id);

                            if($item->cat_id == 93 || $item->cat_id == 104 || $item->cat_id == 105 || $item->cat_id == 143 || $item->cat_id == 136)
                                $items_records[] = Items::findOne((int)$id);

                        }
                    }
                    //return var_dump($items_records[mt_rand(0,count($items_records)-1)]->text);
                    if(empty($items_records)) continue;

                    $rand_index = mt_rand(0,count($items_records)-1);

                    $song->phrase = $items_records[$rand_index]->text;

                    if(isset($items_records[$rand_index+1]) && $song->phrase != $song->phrase2)
                        $song->phrase2 = $items_records[$rand_index+1]->text;
                    else $song->phrase2 = $items_records[0]->text;
                    //return $song->phrase.'<br>'.$song->phrase2;
                   //return var_dump($song);

                        $this->choosen_songs[] = $song;
                    } catch (\ErrorException $e) {
                        return $e->getMessage();
                    }
                }
                //exit;

            //return var_dump($this->choosen_songs);


            return $this->renderPartial('concert', ['songs' =>  $this->choosen_songs, 'tags' => $this->rand_tag]);

        }
        
    }


    /**
     * Траты
     * @return string
     */
    function actionSpent(){
        if($user = Yii::$app->getRequest()->getQueryParam('user')) {

            if (!$user) return 'Доступ запрещн!';

            if (Yii::$app->getRequest()->getQueryParam('request')) {
               // return Yii::$app->getRequest()->getQueryParam('request');

                $shop = Shop::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('request')])->one();

                if($shop)  {
                    //return var_dump($shop->id);
                    $shop_spent_sum = Bought::find()
                        ->select(['id, spent, shop_id, COUNT(*) as cnt, SUM(spent) as sum'])
                        ->where(['user_id' => 8, 'shop_id' => $shop->id])
                        ->andWhere('id > 28')
                        ->one();
                    
                    $shop_last_spent = Bought::find()
                        ->where(['user_id' => 8, 'shop_id' => $shop->id])
                        ->andWhere('id > 28')
                        ->orderBy('id DESC')
                        ->limit(30)
                        ->all();

                   //return var_dump($shop_spent);
                    return $this->renderPartial('spent_shop', ['spent_sum' => $shop_spent_sum, 'spents' => $shop_last_spent]);
                }
                
                $product = Products::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('request')])->one();

                if($product)  {
                    //return var_dump($shop->id);
                    $product_spent = Bought::find()
                        ->select(['id, spent, shop_id, COUNT(*) as cnt, SUM(spent) as sum'])
                        ->where(['user_id' => 8, 'product_id' => $product->id])
                        ->andWhere('id > 28')
                        ->one();
                    $product_last_spent = Bought::find()
                        ->where(['user_id' => 8, 'product_id' => $product->id])
                        ->andWhere('id > 28')
                        ->orderBy('id DESC')
                        ->limit(30)
                        ->all();

                    //return var_dump($product_last_spent);
                    return $this->renderPartial('spent_product', ['spent' => $product_spent, 'spents' => $product_last_spent, 'product' => $product->name]);
                }

                $product = Products::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('request')])->one();

                if($product)  {
                    //return var_dump($shop->id);
                    $product_spent = Bought::find()
                        ->select(['id, spent, shop_id, COUNT(*) as cnt, SUM(spent) as sum'])
                        ->where(['user_id' => 8, 'product_id' => $product->id])
                        ->andWhere('id > 28')
                        ->one();
                    $product_last_spent = Bought::find()
                        ->where(['user_id' => 8, 'product_id' => $product->id])
                        ->andWhere('id > 28')
                        ->orderBy('id DESC')
                        ->limit(30)
                        ->all();

                    //return var_dump($product_last_spent);
                    return $this->renderPartial('spent_product', ['spent' => $product_spent, 'spents' => $product_last_spent, 'product' => $product->name]);
                }

                $cat = Categories::find()->where(['name' => Yii::$app->getRequest()->getQueryParam('request')])->one();

                if($cat)  {

                    $sum = 0;
                    $spent_prods = [];

                    $prods = Products::find()
                        ->where(['cat_id' => $cat->id])
                        ->all();

                    //return var_dump($prods);

                    foreach ($prods as $prod) {

                        $cat_products_ids = implode(',', ArrayHelper::map(Products::find()->where(['cat_id' => $prod->cat->id])->all(), 'id', 'id'));

                        $sum = Bought::find()
                            ->select('SUM(spent) as sum')
                            ->where('product_id IN (' . $cat_products_ids . ')')
                            ->andWhere('id > 28')
                            ->scalar();
                        $spent_prods[$prod->name] = Bought::find()
                            ->select('SUM(spent) as sum')
                            ->where(['user_id' => 8, 'product_id' => $prod->id])
                            ->andWhere('id > 28')
                            ->scalar();
                    }

                    arsort($spent_prods);

                    //return var_dump($spent_prods);
                    return $this->renderPartial('spent_cat', ['sum' => $sum, 'spent_prods' => $spent_prods, 'cat' => $cat->name]);
                }


            }

            //return 'ok';
            try {
                $spents = Bought::find()
                    ->select(['id, spent, product_id, COUNT(*) as cnt, SUM(spent) as sum'])
                    ->where(['user_id' => 8])
                    ->andWhere('id > 28')
                    ->groupBy('product_id')
                    ->orderBy('sum DESC')
                    ->limit(20)
                    ->all();
                $shop_spents = Bought::find()
                    ->select(['id, spent, shop_id, COUNT(*) as cnt, SUM(spent) as sum'])
                    ->where(['user_id' => 8])
                    ->andWhere('id > 28')
                    ->groupBy('shop_id')
                    ->orderBy('sum DESC')
                    ->limit(20)
                    ->all();


                $prod_boughts = [];

                $prods = Products::find()
                    ->select(['id, cat_id, COUNT(*) as cnt'])
                    ->groupBy('cat_id')
                    ->all();

                //return var_dump($prods);

                foreach ($prods as $prod) {

                    $cat_products_ids = implode(',', ArrayHelper::map(Products::find()->where(['cat_id' => $prod->cat->id])->all(), 'id', 'id'));

                    $prod_boughts[$prod->cat->name] = Bought::find()
                        ->select('SUM(spent) as sum')
                        ->where('product_id IN (' . $cat_products_ids . ')')
                        ->andWhere('id > 28')
                        ->scalar();
                }

                arsort($prod_boughts);
                    

               //return var_dump($prod_boughts);
            } catch (\ErrorException $e) {
                return $e->getMessage();
            }
            
            return $this->renderPartial('spent', ['spents' => $spents, 'shop_spents' => $shop_spents, 'prod_boughts' => $prod_boughts]);
        }
    }


    /**
     * Данные для постоения графиков
     * @return string
     */
    function actionGraf(){
        
        $weigth16 = [];
        $weigth17 = [];

        $spent16 = [];
        $spent17 = [];
        $incomes16 = [];
        $incomes17 = [];

        $oz16 = [];
        $oz17 = [];

        $doll16 = [];
        $doll17 = [];
        $euro16 = [];
        $euro17 = [];
        
        $el11216 = [];
        $el11116 = [];
        $el11217 = [];
        $el11117 = [];

        $cold_wat16 = [];
        $hot_wat16 = [];
        $cold_wat17 = [];
        $hot_wat17 = [];


        $income = 0;

        //return var_dump(DiaryRecDayParams::find()->where('day_param_id = 4 and act_id <'.$this->getMaxMonthActId(11, 2016))->orderBy('id DESC')->one());

        //return var_dump(Incomes::find()->select(['SUM(money)'])->where('income_id IN (3, 4, 6, 16) and act_id IN ('.$this->getMonthActIds(1, 2016).')')->scalar()/(int)date('d', time()));
     
            for($i=1; $i<=12; $i++) {

                if($this->getMonthActIds($i, 2016))
                    $income16 = Incomes::find()
                            ->select(['SUM(money)'])
                            ->where('income_id IN (3, 4, 6, 16) and act_id IN (' . $this->getMonthActIds($i, 2016) . ')')
                            ->scalar() / (int)date('t', mktime(0, 0, 0, $i, (int)date('d', time()), 2016));
                else $income16 = 0;

                //if($i=12) return (int)date('t', mktime(0, 0, 0, $i, (int)date('d', time()), 2016));
                if($this->getMonthActIds($i, 2017))
                    $income17 = Incomes::find()
                            ->select(['SUM(money)'])
                            ->where('income_id IN (3, 4, 6, 16) and act_id IN (' . $this->getMonthActIds($i, 2017) . ')')
                            ->scalar() / (int)date('t', mktime(0, 0, 0, $i, (int)date('d', time()), 2017));
                else $income17 = 0;

                if($i<10) $month = '0'.$i;
                else $month = $i;

                $weigth16['name'] = '2016';
                $weigth16['data'][] = (float)Snapshot::find()->select(['AVG(weight)'])->where('date like "%2016-'.$month.'-%"')->scalar();

                $weigth17['name'] = '2017';
                $weigth17['data'][] = (float)Snapshot::find()->select(['AVG(weight)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $spent16['name'] = 'sp2016';
                $spent16['data'][] = (float)Snapshot::find()->select(['AVG(spent)'])->where('date like "%2016-'.$month.'-%"')->scalar();

                $spent17['name'] = 'sp2017';
                $spent17['data'][] = (float)Snapshot::find()->select(['AVG(spent)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $incomes16['name'] = 'inc2016';
                $incomes16['data'][] = $income16;

                $incomes17['name'] = 'inc2017';
                $incomes17['data'][] = $income17;


                $oz16['name'] = '2016';
                $oz16['data'][] = (float)Snapshot::find()->select(['AVG(oz)'])->where('date like "%2016-'.$month.'-%"')->scalar();

                $oz17['name'] = '2017';
                $oz17['data'][] = (float)Snapshot::find()->select(['AVG(oz)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $doll16['name'] = 'Доллар-2016';
                $doll16['data'][] = (float)Snapshot::find()->select(['AVG(doll)'])->where('date like "%2016-'.$month.'-%"')->scalar();

                $doll17['name'] = 'Доллар-2017';
                $doll17['data'][] = (float)Snapshot::find()->select(['AVG(doll)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $euro16['name'] = 'Евро-2016';
                $euro16['data'][] = (float)Snapshot::find()->select(['AVG(euro)'])->where('date like "%2016-'.$month.'-%"')->scalar();

                $euro17['name'] = 'Евро-2017';
                $euro17['data'][] = (float)Snapshot::find()->select(['AVG(euro)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $el112['name'] = '112-2017';
                $el112['data'][] = (float)Snapshot::find()->select(['AVG(el112)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $el111['name'] = '111-2017';
                $el111['data'][] = (float)Snapshot::find()->select(['AVG(el111)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $el11217['name'] = '112-2017';
                $el11217['data'][] = (float)Snapshot::find()->select(['AVG(el112)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $el11117['name'] = '111-2017';
                $el11117['data'][] = (float)Snapshot::find()->select(['AVG(el111)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $el11216['name'] = '112-2016';
                $el11216['data'][] = (float)Snapshot::find()->select(['AVG(el112)'])->where('date like "%2016-'.$month.'-%"')->scalar();

                $el11116['name'] = '111-2016';
                $el11116['data'][] = (float)Snapshot::find()->select(['AVG(el111)'])->where('date like "%2016-'.$month.'-%"')->scalar();

                $hot_wat16['name'] = 'hot-2016';
                $hot_wat16['data'][] = (float)Snapshot::find()->select(['AVG(water_hot)'])->where('date like "%2016-'.$month.'-%"')->scalar();

                $hot_wat17['name'] = 'hot-2017';
                $hot_wat17['data'][] = (float)Snapshot::find()->select(['AVG(water_hot)'])->where('date like "%2017-'.$month.'-%"')->scalar();

                $cold_wat16['name'] = 'cold-2016';
                $cold_wat16['data'][] = (float)Snapshot::find()->select(['AVG(water_cold)'])->where('date like "%2016-'.$month.'-%"')->scalar();

                $cold_wat17['name'] = 'cold-2017';
                $cold_wat17['data'][] = (float)Snapshot::find()->select(['AVG(water_cold)'])->where('date like "%2017-'.$month.'-%"')->scalar();

            }

        //return $this->getMaxMonthActId(11, 2016);
        

        //$weights = implode(',', $arr);
        //return var_dump($incomes16);
        return $this->renderPartial('graf',['weigth16' => json_encode($weigth16),
                                            'weigth17' => json_encode($weigth17),
                                            'spent16' => json_encode($spent16),
                                            'spent17' => json_encode($spent17),
                                            'incomes16' => json_encode($incomes16),
                                            'incomes17' => json_encode($incomes17),
                                            'doll16' => json_encode($doll16),
                                            'doll17' => json_encode($doll17),
                                            'euro16' => json_encode($euro16),
                                            'euro17' => json_encode($euro17),
                                            'oz16' => json_encode($oz16),
                                            'oz17' => json_encode($oz17),
                                            'el11117' => json_encode($el11117),
                                            'el11217' => json_encode($el11217),
                                            'el11116' => json_encode($el11116),
                                            'el11216' => json_encode($el11216),
                                            'cold_wat16' => json_encode($cold_wat16),
                                            'cold_wat17' => json_encode($cold_wat17),
                                            'hot_wat16' => json_encode($hot_wat16),
                                            'hot_wat17' => json_encode($hot_wat17),
                                           ]);
    }

    /**
     * Таблицы турнирные клубов и сборных футбола
     * @return string
     */
    function actionFootball(){
        if ($user = Yii::$app->getRequest()->getQueryParam('user')) {


            if (!$user) return 'Доступ запрещн!';
            $clubs = TeamSum::find()
                ->where("is_club = 1 and is_tour_visual = 1")
                ->orderBy(["cash_balls" => SORT_DESC, "cash_g_get" => SORT_DESC])
                ->all();
            $countries = TeamSum::find()
                ->where("is_club = 0 and is_tour_visual = 1")
                ->orderBy(["cash_balls" => SORT_DESC, "cash_g_get" => SORT_DESC])
                ->all();
            //return var_dump($clubs);

            return $this->renderPartial('football', ['clubs' => $clubs, 'countries' => $countries]);
        }
    }


    /**
     * Формирование плейлиста для радио по ключевым словам
     * @return string
     */
    function actionRadio(){
        if ($user = Yii::$app->getRequest()->getQueryParam('user')) {

            if (!$user) return 'Доступ запрещн!';



            if (Yii::$app->getRequest()->getQueryParam('request')) {

                $words = Yii::$app->getRequest()->getQueryParam('request');

                //$words = urldecode($rec);

               // return var_dump(ord($words[0]).'-'.$words[0].PHP_EOL.$words[1].$words[2].$words[3].$words[4].$words[5].$words[6].$words[7]);

               // return mb_check_encoding($words);

                //$words = iconv("UTF-16", "UTF-8", $words);


              // return var_dump(mb_detect_encoding($rec, "ASCII, UTF-16, UTF-8, UTF-32"));

                //return var_dump(rawurldecode($words));

                try {
                    $f = fopen("/home/romanych/radio/dio/playlist.txt", 'w');
                } catch (\ErrorException $e) {
                    return $e->getMessage();
                }

                $dibilizmy = Items::find()->where(["source_id" => 17])->all();
                shuffle($dibilizmy);
                $limerik = Items::find()->where(["source_id" => 27])->all();
                shuffle($limerik);

                // $this->songs = [];

                $arr_theme = explode(',', $words);

                //return var_dump($arr_theme);

                if (empty($arr_theme))
                    $this->songs = [];

                else {
                    foreach ($arr_theme as $theme) {

                        $query = new Query();

                        $songs_ids = $query->from('songtexts')
                            ->match($theme)
                            ->all();

                        shuffle($songs_ids);

                        //return var_dump($songs_ids);


                        foreach ($songs_ids as $arr_item_rec) {
                            foreach ($arr_item_rec as $id) {
                                $this->songs[SongText::findOne((int)$id)->source->author->name] = SongText::findOne((int)$id);
                            }
                        }

                        //return var_dump($this->songs);

                        $query_items_ids = $query->from('items')
                            ->match($theme)
                            ->all();

                        shuffle($query_items_ids);

                        foreach ($query_items_ids as $arr_item_rec) {
                            foreach ($arr_item_rec as $id) {
                                $this->songs[Items::findOne((int)$id)->source->author->name] = Items::findOne((int)$id);
                            }
                        }
                    }
                }


                shuffle($this->songs);

                $songs = [];

                foreach ($this->songs as $item) {
                    if ($item instanceof Items && $item->audio_link) {
                        fwrite($f, "/home/romanych/Музыка/Thoughts_and_klassik/new_ideas/" . $item->audio_link . PHP_EOL);
                        $songs[$item->source->author->name.' - '.$item->source->title] = $item->title;
                    }

                    if ($item instanceof SongText){
                        fwrite($f, "/home/romanych/Музыка/Thoughts_and_klassik" . $item->link . PHP_EOL);
                        $songs[$item->source->author->name.' - '.$item->source->title] = $item->title;
                    }


                }

                fclose($f);
                return $this->renderPartial('radio_pl', ['songs' => $songs]);
            }

            return $this->renderPartial('radio_form');

        }
    }

    /**
     * Максимальный айдишник действия для данного месяца-года
     * @param $month
     * @param $year
     * @return int
     */
    function getMaxMonthActId($month, $year){

        $time_max_month = mktime(0, 0, 0, $month, (int)date('t', mktime(0, 0, 0, $month)), $year) + 9*60*60;
        return   (int)DiaryActs::find()
            ->select('MAX(id)')
            ->where('time <'.$time_max_month)
            ->scalar();
    }

    /**
     * Получаеем айдишники действий по месяцу и году
     * @param $month
     * @param $year
     * @return string
     */
    function getMonthActIds($month, $year){
        $time_max_month = mktime(0, 0, 0, $month, (int)date('t', mktime(0, 0, 0, $month)), $year) + 9*60*60;
        $time_min_month = mktime(0, 0, 0, $month, 1, $year) + 9*60*60;
        $ids =  implode(',', ArrayHelper::map(DiaryActs::find()
            ->where('time <'.$time_max_month.' and time >'.$time_min_month)
            ->all(), 'id', 'id'));
        if($ids) return $ids;
        else return null;
    }


    /**
     * Запомнить
     * @return string
     */
    function actionRemember(){
        if ($user = Yii::$app->getRequest()->getQueryParam('user')) {

            if (!$user) return 'Доступ запрещн!';

            return file_get_contents("/home/romanych/public_html/plis/basic/data/remember.html");

        }
    }

    /**
     * Выучил
     * @return string
     */
    function actionLearned() {
        if ($user = Yii::$app->getRequest()->getQueryParam('user')) {
            //return $user;

            if (!$user) return 'Доступ запрещн!';
            
            $learned_items = Items::find()->where(['learned' => 2])->all();
            foreach ($learned_items as $item){
                $item->learned = 1;
                $item->update(false);
            }
            $act = new DiaryActs();
            $act->model_id = 14;
            $act->user_id = Yii::$app->getRequest()->getQueryParam('user');
            $act->mark = 3;
            $act->mark_status = 0;
            $act->save(false);

        }
    }

    /**
     * Работа с проектами
     * @return string
     */
    function actionProject(){
        if ($user = Yii::$app->getRequest()->getQueryParam('user')) {
           // return $user;

            if (!$user) return 'Доступ запрещн!';
            
            //$ideas = Idea::find()->all();

            if (Yii::$app->getRequest()->getQueryParam('request')) {
                $idea = new Idea();
                $idea->title = Yii::$app->getRequest()->getQueryParam('request');
                $idea->save(false);

                return $this->renderPartial('idea_work', ['idea' => $idea, 'user' => $user]);

            }

            if (Yii::$app->getRequest()->getQueryParam('find')) {


                //return var_dump(Idea::find()->where('title like "%'.Yii::$app->getRequest()->getQueryParam('find').'%"')->one());

                $idea = Idea::find()->where('title like "%'.Yii::$app->getRequest()->getQueryParam('find').'%"')->one();

                if($idea) {
                    $bound_items = explode(',', $idea->items);
                    //return var_dump($bound_items);
                    return $this->renderPartial('idea_work', ['idea' => $idea, 'user' => $user, 'bound_items' => $bound_items]);
                }
                else return 'uups!';

            }

            if (Yii::$app->getRequest()->getQueryParam('edited') && Yii::$app->getRequest()->getQueryParam('id')) {

                $edited_idea = Idea::findOne((int)Yii::$app->getRequest()->getQueryParam('id'));
                $edited_idea->text = Yii::$app->getRequest()->getQueryParam('edited');

                if($edited_idea->save(false)) return "<p>Изменения сохранены</p>";
                else return "<p>Ошибка</p>";


            }

            return $this->renderPartial('add_idea_form');


        }
    }

    /**
     * Привязка айтемов к проекту
     * @return string
     */
    function actionBindProjectItem(){
        if ($user = Yii::$app->getRequest()->getQueryParam('user')) {
            //return $user;

            if (!$user) return 'Доступ запрещн!';

            if (Yii::$app->getRequest()->getQueryParam('idea') &&  Yii::$app->getRequest()->getQueryParam('id')) {

                $idea = Idea::find()->where('title like "%' . Yii::$app->getRequest()->getQueryParam('idea') . '%"')->one();
                if($idea) {
                    $idea->items .= Yii::$app->getRequest()->getQueryParam('id').",";
                    $idea->update(false);
                    return "<p>Привязано!</p>";
                }
                else return "Ошибка";

            }
        }

    }
    

    function actionNews(){
        if ($user = Yii::$app->getRequest()->getQueryParam('user')) {
            //return $user;

            if (!$user) return 'Доступ запрещн!';
            
            $news = NsbNews::find()->limit(20)->orderBy('id DESC')->all();

            //return var_dump($news);

            return $this->renderPartial('news', ['news' => $news, 'user' => $user]);
            
            
        }
    }


    function actionTrue($id){
       return TestAnswers::findOne($id)->true;
    }



}