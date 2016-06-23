<?php

namespace app\modules\prognose\controllers;

use app\components\FrontEndController;
use app\models\Totmatch;
use app\models\Totpredict;
use app\models\Totuser;
use Yii;
use yii\helpers\ArrayHelper;

//use yii\web\Controller;
//use app\modules\bardzilla\models\Songs;


class DefaultController extends FrontEndController
{
    public $current_user;

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionLogin(){

        if(Yii::$app->getRequest()->getQueryParam('name') && Yii::$app->getRequest()->getQueryParam('pseudo')) {
            $name = Yii::$app->getRequest()->getQueryParam('name');
            $pseudo = Yii::$app->getRequest()->getQueryParam('pseudo');

            $user = Totuser::find()
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

    public function actionRegistration(){


        if(Yii::$app->getRequest()->getQueryParam('name') && Yii::$app->getRequest()->getQueryParam('pseudo')) {

            $user = new Totuser();
            $user->name = Yii::$app->getRequest()->getQueryParam('name');
            $user->pseudo = Yii::$app->getRequest()->getQueryParam('pseudo');
            if($user->validate()) {
                try {
                    $user->save();
                    return "Вы успешно зарегистрированы - Войдите";
                } catch (\ErrorException $e) {
                    return "Не получилось(((... Попробуйте позже ещё раз...";
                }
            }
            else return "Ошибка при заполнении формы";
            //else return "Не получилось(((... Попробуйте позже ещё раз...";
        }


        return $this->render('registration');

    }

    /**
     * Прогноз
     * @param $id
     * @return string
     */
    public function actionPrognose($id){


            if($this->userIfUserLegal($id)){

                    $users_predicted_matches = implode(',',ArrayHelper::map(Totpredict::find()->where(['user_id' => $this->current_user->id])->all(), 'id', 'match_id'));

                    $match_list = Totmatch::find()->where("id NOT IN (".$users_predicted_matches.")")->all();
                    //var_dump($users_predicted_matches); exit;

                    return $this->render('group', ['user' => $this->current_user, 'match_list' => $match_list]);
                }

       return $this->render('index');

    }

    public function actionMatch(){
        $this->layout = '@app/themes/prognose/views/layouts/pagein';

        if(Yii::$app->getRequest()->getQueryParam('host_g') && Yii::$app->getRequest()->getQueryParam('guest_g')) {

            $predict = new Totpredict();

            $predict->guest_g = Yii::$app->getRequest()->getQueryParam('guest_g');
            $predict->host_g = Yii::$app->getRequest()->getQueryParam('host_g');
            $predict->user_id = Yii::$app->getRequest()->getQueryParam('user');
            $predict->match_id = Yii::$app->getRequest()->getQueryParam('match');

            if($predict->save()) return "<span style='color:green'>Прогноз сохранен</span>";
            else return "<span style='color:red'>Ошибка сохранения</span>";
        }

        return "Ошибка";

    }


    public function actionPredicted($id){
        $this->layout = '@app/themes/prognose/views/layouts/pagein';
        //echo $id; exit;

        if($this->userIfUserLegal($id)){

           $predicted = Totpredict::find()->where(['user_id' => $this->current_user->id])->all();
            //var_dump($predicted); exit;
            return $this->render('stat', ['user' => $this->current_user, 'predicted' => $predicted]);

        }

        return $this->render('index');

    }

    /**
     * Проверка юзера
     * @param $cuser
     * @return bool
     */
    private function userIfUserLegal($cuser){

        $max_id = Totuser::find()
            ->select('MAX(id)')
            ->scalar();

        $i = 0;
        while ($i <= $max_id) {
            $i++;
            if ($user = Totuser::findOne($i)) {
                if (md5($user->id) == $cuser) {
                    $this->current_user = $user;
                    return true;
                }
            }
        }

        return false;

    }


    /**
     * Добавление случайно оцененных действий пользователю
     * @param array $response_for_core_user
     * @param int $user_id
     * @return bool|string
     */
    private function addRandActionToSomeUser($response_for_core_user, $user_id){
        for($i=0; $i < 15; $i++ ){
            if(isset($response_for_core_user[$i])){
                $model = new MarkIt();
                $model->ball = rand(3, 5);
                $model->action_id = $response_for_core_user[$i]['act'];
                $model->user_id = $user_id;
                $model->date = date('Y-m-d', time() - 60 * 60 * 24);


                if($model->validate()) {
                    try {
                        if(!$model->save()) return "ОШИБКА СОХРАНЕНИЯ ДАННЫХ!";

                    } catch (\ErrorException $e) {
                        return "Не получилось(((... ";

                    }
                }
                else return "Ошибка при заполнении формы - оценки должны быть 1,2,3,4 или 5";

            }
        }
        return true;

    }



}