<?php

namespace app\modules\krokodile\controllers;

use app\components\CommentsWidget;
use app\components\FrontEndController;
use app\models\ArticlesContent;
use app\models\Author;
use app\models\Comments;
use app\models\ContactForm;
use app\models\Source;
use Yii;
use app\models\Categories;
use yii\data\Pagination;

use app\models\Articles;


class DefaultController extends FrontEndController
{

    /**
     * @return string
     */
    public function actionIndex()
    {

        //$cats = Categories::find()->where('site_id ='.$this->site->id)->roots()->all();
        //$articles = Articles::find()->where('site_id ='.$this->site->id)->all();

        //$cats = Categories::find()->leaves()->all();

        return $this->render('index');

    }
    
    public function actionNoradio(){
        return $this->render('noradio');
    }


}