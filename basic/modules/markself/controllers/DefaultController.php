<?php

namespace app\modules\markself\controllers;

use app\components\FrontEndController;
use app\models\MarkActions;
use app\models\MarkGroup;
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
            Yii::$app->getRequest()->getQueryParam('date')) {
            //$this->layout = '@app/themes/markself/views/layouts/pagein';

            //$model = new MarkActions();
            $date = Yii::$app->formatter->asDate(Yii::$app->getRequest()->getQueryParam('date'), "dd-mm-yyyy");
            return  Yii::$app->getRequest()->getQueryParam('acts'). '  '.$date ;

            /*
            $model->name = Yii::$app->getRequest()->getQueryParam('name');
            $model->group_id = Yii::$app->getRequest()->getQueryParam('group_id');
            if($model->validate()) {
                try {
                    $model->save();
                    return "Данные сохранены";
                } catch (\ErrorException $e) {
                    return "Не получилось(((... Попробуйте позже ещё раз...";
                }
            }
            else return "Ошибка при заполнении формы";
            //else return "Не получилось(((... Попробуйте позже ещё раз...";
             */
        }

        else {
            return "oppps";
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