<?php

namespace app\controllers;

use app\commands\CountryController;
use app\models\Matches;
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
   public $layout = 'landing';

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
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');


            return $this->refresh('#contact');
        }

        if(Yii::$app->getRequest()->getQueryParam('hhash')) {
            //var_dump(CountryController::actionTestUnicValTable('app/commands/Matches',));
            $records = Matches::find()
                ->select(["date, COUNT(date) as cnt"])
                ->where('id > 70000')
                ->groupBy('date')
                ->all();

            foreach ($records as $rec){
                echo $rec['cnt'] ." - ". $rec['date'] . "<br>";
            }
            exit;
        }

        return $this->render('contact_lend', [
            'model' => $model,
        ]);
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

}
