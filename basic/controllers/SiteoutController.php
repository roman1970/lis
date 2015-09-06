<?php

namespace app\controllers;

use app\models\Weather;
use Yii;
use yii\filters\AccessControl;
//use yii\web\Controller;
use yii\filters\VerbFilter;
//use app\models\LoginForm;
//use app\models\ContactForm;
use app\components\FrontEndController;

class SiteoutController extends FrontEndController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
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

        $modelWeather = new Weather();
        $last = $modelWeather::find()
            ->where(['city_id' => 1938])
            ->limit(10)
            ->all();

        return $this->render('index', [
            'model' => $last,
        ]);
    }

}