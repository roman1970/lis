<?php

namespace app\modules\knoledges\controllers;

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
    public $cat_id;
    public $article_id;
    public $articles = [];
    public $title;
    public $source;
    public $author;

    /**
     * @return string
     */
    public function actionIndex()
    {

        $cats = Categories::find()->where('site_id ='.$this->site->id)->roots()->all();
        $articles = Articles::find()->where('site_id ='.$this->site->id)->all();

        //$cats = Categories::find()->leaves()->all();

        return $this->render('index', ['cats' => $cats, 'articles' => $articles]);

    }

    public function actionShow($id){
        $article = Articles::findOne($id);
        $comment = new Comments();
        $this->title = $article->title;
        $allArticles = ArticlesContent::find()
            ->where(['articles_id' => $id]);

        //var_dump($allArticles); exit;

        $countQuery = clone $allArticles;
        $pages = new Pagination(['totalCount' => $countQuery->count(),
            'pageSize' => isset($article->onepages) ? $article->onepages : 0,
            'forcePageParam' => false,
            'pageSizeParam' => false,


        ]);
        $models = $allArticles->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $this->source = Source::find()->where(['id' => $models[0]->source_id])->one()->title;
        $this->author = Author::find()->where(['id' => Source::find()->where(['id' => $models[0]->source_id])->one()->author_id])->one()->name;


        return $this->render('view', ['articles' => $allArticles, 'contents' => $models, 'pages' => $pages,
            'title' => $this->title, 'source' => $this->source, 'author' => $this->author, 'comment' => $comment]);


    }

    public function actionAddcomment(){
        $model = new Comments();
        if ($model->load(Yii::$app->request->post())) {
            var_dump($model);
            $model->name = Yii::$app->request->post('Comments')['name'];
            $model->body = Yii::$app->request->post('Comments')['body'];
            $model->save();
        }

    }



}