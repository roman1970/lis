<?php

namespace app\modules\markself\controllers;

use app\components\FrontEndController;
use app\models\ArticlesContent;
use app\models\ContactForm;
use app\models\MarkUser;
use app\models\Visit;
use Yii;
use app\models\Categories;
use app\models\Author;
use app\models\Source;
use yii\data\Pagination;
//use yii\web\Controller;
//use app\modules\bardzilla\models\Songs;
use app\models\Articles;
use yii\helpers\Url;


class DefaultController extends FrontEndController
{
    public static $current_user;

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
        $max_id = MarkUser::find()
            ->select('MAX(id)')
            ->scalar();

        $i = 0;
        while ($i <= $max_id){
            $i++;
            if($user = MarkUser::findOne($i)) {
                if(md5($user->id) == $id){
                    self::$current_user = $user->id;
                    return $this->render('group', ['name' => $user->id ]);
                }

            }

        }

       return "Ошибка";

    }



}