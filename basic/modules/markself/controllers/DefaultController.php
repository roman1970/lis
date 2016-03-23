<?php

namespace app\modules\markself\controllers;

use app\components\FrontEndController;
use app\models\ArticlesContent;
use app\models\ContactForm;
use app\models\Visit;
use Yii;
use app\models\Categories;
use app\models\Author;
use app\models\Source;
use yii\data\Pagination;
//use yii\web\Controller;
//use app\modules\bardzilla\models\Songs;
use app\models\Articles;


class DefaultController extends FrontEndController
{

    public function actionIndex()
    {

        return $this->render('index');

    }




}