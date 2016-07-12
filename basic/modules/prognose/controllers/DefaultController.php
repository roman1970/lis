<?php

namespace app\modules\prognose\controllers;

use app\components\FrontEndController;
use app\models\Matches;
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
        $this->layout = '@app/themes/prognose/views/layouts/pagein';


            if($this->userIfUserLegal($id)){
                    $now_id = 1;

                    $users_predicted_matches = implode(',',ArrayHelper::map(Totpredict::find()->where(['user_id' => $this->current_user->id])->all(), 'id', 'match_id'));

                    $all = Totmatch::find()->all();
                        foreach ($all as $one) {
                            /*echo date('Y-m-d H:i:s', Totmatch::formatMatchDateToTime(explode(' ', $one->date)[0]))." "
                                .Totmatch::formatMatchDateToTime(explode(' ', $one->date)[0])." ".time()."<br>";
                            var_dump(Totmatch::formatMatchDateToTime(explode(' ', $one->date)[0]) >= time());
                            */
                            if(Totmatch::formatMatchDateToTime(explode(' ', $one->date)[0])+36000 <= time()) {
                                $now_id = $one->id;
                            }
                        }
                

                    if($users_predicted_matches)
                        $match_list = Totmatch::find()
                            ->where("id NOT IN (".$users_predicted_matches.") AND id > ".$now_id)
                            ->all();
                    else $match_list = Totmatch::find()
                        ->where("id > ".$now_id)
                        ->all();

                    return $this->render('group', ['user' => $this->current_user, 'match_list' => $match_list]);
                }

       return $this->render('index');

    }

    public function actionMatch(){
        $this->layout = '@app/themes/prognose/views/layouts/pagein';

        if(!Totpredict::find()->where(['user_id' => 6, 'match_id' => Yii::$app->getRequest()->getQueryParam('match') ])->one() &&
            Yii::$app->getRequest()->getQueryParam('match') !== null) {
            $pred_comp = new Totpredict();
            $pred_comp->match_id = Yii::$app->getRequest()->getQueryParam('match');
            $pred_comp->user_id = 6;
            $pred_comp->host_g = mt_rand(0,3);
            $pred_comp->guest_g = mt_rand(0,3);
            $pred_comp->save(false);

        }

        if(Yii::$app->getRequest()->getQueryParam('host_g') !== null && Yii::$app->getRequest()->getQueryParam('guest_g') !== null) {

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

           $predicted = Totpredict::find()->where(['user_id' => $this->current_user->id])
               ->limit(20)
               ->orderBy('id DESC')
               ->all();
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



}