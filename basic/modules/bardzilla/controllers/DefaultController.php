<?php

namespace app\modules\bardzilla\controllers;

use app\components\FrontEndController;
use app\models\ArticlesContent;
use Yii;
//use yii\web\Controller;
//use app\modules\bardzilla\models\Songs;
use app\models\Articles;


class DefaultController extends FrontEndController
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionShowrymes() {

        $articles = new ArticlesContent();
        $allArticles = $articles::find()
            ->joinWith(['articles' => function ($query) {
                $query->andWhere('cat_id = 1');
            },])
            ->all();


        return $this->renderPartial('showrymes', ['articles' => $allArticles]);

    }

    public function actionShowaudio() {

        $articles = new ArticlesContent();
        $allArticles = $articles::find()
            ->joinWith(['articles' => function ($query) {
                $query->andWhere('cat_id = 2');

            },])
            ->all();


        return $this->renderPartial('showaudio', ['articles' => $allArticles]);

    }


    public function actionShowlikes($id) {

        $article = ArticlesContent::findOne($id);

        return $this->renderPartial('showlikes', ['article' => $article]);

    }

    public function actionSetlikes() {

        /*  $articles = new ArticlesContent();
          $allArticles = $articles::find()
              ->with(['articles' => function ($query) {
                  $query->andWhere('cat_id = 2');
              },])
              ->all();
         */


    }





}