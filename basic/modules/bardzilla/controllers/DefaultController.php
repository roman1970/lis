<?php

namespace app\modules\bardzilla\controllers;

use app\components\FrontEndController;
use app\models\ArticlesContent;
use Yii;
use app\models\Categories;
//use yii\web\Controller;
//use app\modules\bardzilla\models\Songs;
use app\models\Articles;


class DefaultController extends FrontEndController
{
    public $cat_id;

    /**
     * @return string
     */
    public function actionIndex()
    {

        $cats = Categories::find()->roots()->all();
        //$cats = Categories::find()->leaves()->all();

        return $this->render('index', ['cats' => $cats]);

    }

    public function actionShow() {


        $this->cat_id = Yii::$app->getRequest()->getQueryParam('id') ? Yii::$app->getRequest()->getQueryParam('id') : null;
        $cat_obg = Categories::find()
            ->where('id = '. $this->cat_id)
            ->one();

        $allContent = Articles::find()
            ->where('cat_id = '. $this->cat_id)
            ->all();


        $allArticles = ArticlesContent::find()
            ->joinWith(['articles' => function ($query) {
                $query->andWhere('cat_id = '. $this->cat_id);
            },])
            ->all();

        return $this->renderPartial($cat_obg->action,
            ['articles' => $allArticles, 'content' => $allContent]);

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

    public function actionShowсhildrenсat($root) {
        $rootCat = Menu::findOne(['name' => $root]);
        $children = $rootCat->children()->all();
        return $this->renderPartial('children', ['cats' => $children]);
    }





}