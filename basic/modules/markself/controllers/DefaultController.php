<?php

namespace app\modules\markself\controllers;

use app\components\FrontEndController;
use app\models\MarkActions;
use app\models\MarkGroup;
use app\models\MarkIt;
use app\models\MarkUser;
use app\models\UploadForm;
use Yii;
use yii\web\UploadedFile;

//use yii\web\Controller;
//use app\modules\bardzilla\models\Songs;


class DefaultController extends FrontEndController
{
    public $current_user;

    public function actionIndex()
    {
        //var_dump($_POST);
        $uploadFile = new UploadForm();
        //if($_FILES) {var_dump($_FILES); exit;}

        if (Yii::$app->request->isPost) {
            $uploadFile->file = UploadedFile::getInstance($uploadFile, 'file');
            //var_dump($uploadFile); exit;


            if ($uploadFile->file && $uploadFile->validate()) {
                $uploadFile->file->saveAs('uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension);

            }

            else  {
                print_r($uploadFile->getErrors()) ;
                exit;
            }
        }

        return $this->render('index', ['uploadFile' => $uploadFile]);
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
                    $model->date = date('Y-m-d', time() - 60 * 60 * 24);


                    if($model->validate()) {
                        try {
                           if(!$model->save()) return "ОШИБКА СОХРАНЕНИЯ ДАННЫХ!";


                        } catch (\ErrorException $e) {

                            return "Не получилось(((... " . $e->getMessage();

                        }
                    }
                    else return "Ошибка при заполнении формы - оценки должны быть 1,2,3,4 или 5";

                }
            }
            $user_mod = MarkUser::findOne(Yii::$app->getRequest()->getQueryParam('user'));


            $average  = MarkIt::getAverageForDateAndUser($date, Yii::$app->getRequest()->getQueryParam('user'));

            try {
                $deposite = (int)round(($average - 4) * 100);
                $user_mod->money += $deposite;
                $user_mod->update(false);

            } catch (\ErrorException $e) {
                return $e->getMessage() . " ошибка кошелька";
            }


            try {
                $this->addRandActionToSomeUser($response, 8);
            } catch (\ErrorException $e) {
                return $e->getMessage() . "У друга 8";
            }
            try {
                $this->addRandActionToSomeUser($response, 9);
            } catch (\ErrorException $e) {
                return $e->getMessage() . "У друга 9";
            }

            return 1;





            //$date = Yii::$app->formatter->asDate(Yii::$app->getRequest()->getQueryParam('date'), "dd-mm-yyyy");
            //return  "Данные сохранены";


        }

        else {
            return "Ошибка";
        }



    }


    public function actionStat($id){
        $this->layout = '@app/themes/markself/views/layouts/pagein';

        if($this->userIfUserLegal($id)){
            $date = date("Y-m-d", time() - 60 * 60 * 24);
                $marks = MarkIt::find()->where(['date' => $date, 'user_id' => $this->current_user->id])->all();

                if(count($marks)) {
                    $sum = 0;
                    foreach ($marks as $mark) {
                        $sum += (int)$mark->ball;
                    }
                    $average = round($sum / (count($marks)), 1);
                    return $this->render('stat', ['user' => $this->current_user, 'marks' => $marks, 'avmark' => $average]);
                }

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