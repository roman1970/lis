<?php
namespace app\controllers;

use app\components\BackEndController;
use app\models\Articles;
use app\models\ArticlesContent;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Yii;
use yii\data\ActiveDataProvider;

class JstestsController extends BackEndController
{
    public $layout = 'admin';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFunctions(){

        if(Yii::$app->getRequest()->getQueryParam('n')) $function = Yii::$app->getRequest()->getQueryParam('n');
        else throw new \Exception('нет такой функции!');

        return $this->render($function);
    }
}