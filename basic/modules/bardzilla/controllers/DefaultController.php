<?php

namespace app\modules\bardzilla\controllers;

use app\components\FrontEndController;
use app\models\ArticlesContent;
use Yii;
use app\models\Categories;
use yii\data\Pagination;
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

    /**
     * Показывает контент
     * @return string
     * @TODO Нужно предусмотреть возможность вывода разного контента, привязаного к одной категории
     *
     */
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
            },]);
       // var_dump($allArticles); exit;

        $countQuery = clone $allArticles;
        $pages = new Pagination(['totalCount' => $countQuery->count(),
                                'pageSize'=>$allContent[0]->onepages,
                                'forcePageParam' => false,
                                'pageSizeParam' => false,
                                ]);
        $models = $allArticles->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->renderPartial($cat_obg->action,
            [//'articles' => $allArticles,
                'content' => $allContent,
                'articles' => $models,
                'pages' => $pages,
                'cat' => $this->cat_id
            ]);

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

    /**
     * Получает массив умных фраз
     *
     * @return array
     */
    public function actionGetphrases(){
        $arr = [];
        if(__DIR__ == '/home/romanych/public_html/plis/basic/modules/bardzilla/controllers') {

            $allPhrases = ArticlesContent::find()
                ->joinWith(['articles' => function ($query) {
                    $query->andWhere('cat_id = 35');
                },])
                ->all();
            // var_dump($allPhrases); exit;
        }
        else {
            $allPhrases = ArticlesContent::find()
                ->joinWith(['articles' => function ($query) {
                    $query->andWhere('cat_id = 5');
                },])
                ->all();
            // var_dump($allPhrases); exit;
        }

        foreach($allPhrases as $phrase){
            $arr[] = $phrase->body;
        }

        return  json_encode($arr);

    }





}