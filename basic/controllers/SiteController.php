<?php

namespace app\controllers;

use app\models\Weather;
use Yii;
use yii\filters\AccessControl;
//use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\BackEndController;
//use app\components\Helper;
use dektrium\user\models\User as User;

class SiteController extends BackEndController
{
   //public $layout = 'landing';

    public function behaviors()
    {
        return [
            /*'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
		     [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            */
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        $names = User::findByUsername('roman');
        return $this->render('about', ['names' => $names]);
    }

    public function actionSend(){
        if(Yii::$app->getRequest()->getQueryParam('name'))
            $name = Yii::$app->getRequest()->getQueryParam('name');
        else $name = "";

        if(Yii::$app->getRequest()->getQueryParam('email'))
            $email = Yii::$app->getRequest()->getQueryParam('email');
        else $email = "";

        if(Yii::$app->getRequest()->getQueryParam('message'))
            $message = (int)Yii::$app->getRequest()->getQueryParam('message');
        else $message = "";

        if(Yii::$app->getRequest()->getQueryParam('phone'))
            $phone = (int)Yii::$app->getRequest()->getQueryParam('phone');
        else $phone = "";

        if (empty($_POST['name'])) {

            $address = "r0man4ernyshev@gmail.com";
            $sub = "Письмо с сайта qplis";

            $mes = "Автор указал такое имя: $name \r\n Оставил такой E-mail: $email
            \r\n Оставил такой телефон : $phone \r\n Содержание письма: $message";


            $send = mail ($address,$sub,$mes,"Content-type:text/plain; charset = utf-8; From: $email");
            if ($send == 'true')
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        echo "Bot!";

    }
}
