<?php

namespace app\modules\markself\controllers;

use app\components\FrontEndController;
use app\models\MarkActions;
use app\models\MarkGroup;
use app\models\MarkIt;
use app\models\MarkUser;
use Yii;

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

            $user = MarkUser::find()
                ->where("name like('%" . $name . "') and pseudo like('" . $pseudo . "')")
                ->one();
            if($user) {

                //$session = Yii::$app->session;
                //$session->open();
                //$session->set('user', $user->id);
                //return $this->render('group', ['name' => $_SESSION['user']]);
                return md5($user->id);
            }
            else return $this->render('login');

        }

        else {
            return $this->render('login');
        }


    }

    public function actionRegistration(){


        if(Yii::$app->getRequest()->getQueryParam('name') && Yii::$app->getRequest()->getQueryParam('pseudo')) {

            $user = new MarkUser();
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
     * Выбор группы
     * @param $id
     * @return string
     */
    public function actionChoosegroup($id){

        $this->layout = '@app/themes/markself/views/layouts/pagein';

                if($this->userIfUserLegal($id)){

                    $groups = MarkGroup::find()->all();

                    return $this->render('group', ['user' => $this->current_user, 'groups' => $groups]);
                }

       return $this->render('index');

    }

    /**
     * Показывает оцениваемые действия
     * @return string
     */
    public function actionMarkact() {

        if(Yii::$app->getRequest()->getQueryParam('group') && Yii::$app->getRequest()->getQueryParam('user')) {

            $group = Yii::$app->getRequest()->getQueryParam('group');
            $user = Yii::$app->getRequest()->getQueryParam('user');

            $this->layout = '@app/themes/markself/views/layouts/pagein';


            if($this->userIfUserLegal($user)){

                $actions = MarkActions::find()
                    ->where(['group_id' => $group])->all();

                $group_name = MarkGroup::findOne($group)->name;


                return $this->render('mark_actions', ['user' => $this->current_user, 'actions' => $actions, 'group_name' => $group_name ]);
            }


        }

        return $this->render('index');

    }


    /**
     * Создаём оцениваемые действия
     */
    public function actionMarkday(){

        if(Yii::$app->getRequest()->getQueryParam('acts') &&
            Yii::$app->getRequest()->getQueryParam('user')) {
            //$this->layout = '@app/themes/markself/views/layouts/pagein';

            $date = date("Y-m-d", time() - 60 * 60 * 24);
            if(MarkIt::find()->where(['date' => $date, 'user_id' => Yii::$app->getRequest()->getQueryParam('user')])->one())
                return "Вы уже оценили вчерашний день! До завтра!";


            $acts = Yii::$app->getRequest()->getQueryParam('acts');
            $response = json_decode($acts, true); // преобразование строки в формате json в ассоциативный массив
            for($i=0; $i < 10; $i++ ){
                if(isset($response[$i])){
                    $model = new MarkIt();
                    $model->ball = $response[$i]['mrk'];
                    $model->action_id = $response[$i]['act'];
                    $model->user_id = Yii::$app->getRequest()->getQueryParam('user');


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


            //$date = Yii::$app->formatter->asDate(Yii::$app->getRequest()->getQueryParam('date'), "dd-mm-yyyy");
            return  "Данные сохранены";


        }

        else {
            return var_dump(Yii::$app->getRequest()->getQueryParam('date'));
        }



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