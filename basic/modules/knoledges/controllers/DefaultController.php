<?php

namespace app\modules\knoledges\controllers;

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
    public $cat_id;
    public $article_id;
    public $articles = [];
    public $title;
    public $source;
    public $author;
    public static $content_id;

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

    /**
     * Показываем контент
     * @param $id
     * @return string
     */
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

    /**
     * Добавление комментариев
     * @return string
     */
    public function actionAddcomment(){

        $model = new Comments();

            $model->body = Yii::$app->request->post('Comments')['body'];
            if(Yii::$app->getRequest()->getQueryParam('name'))
                $model->name = Yii::$app->getRequest()->getQueryParam('name');

            if(Yii::$app->getRequest()->getQueryParam('body'))
                $model->body = Yii::$app->getRequest()->getQueryParam('body');

            if(Yii::$app->getRequest()->getQueryParam('content_id'))
                self::$content_id = $model->article_content_id = (int)Yii::$app->getRequest()->getQueryParam('content_id');

            $model->status = 'published';

            if($model->save(false)) return "<p style='color: green'>Ответ опубликован</p>";

        return "<p style='color: red'>Попробуйте ещё раз чуть позже</p>";

    }

    /**
     * Вызов виджета комментариев без перезагрузки
     * @param $id
     * @throws \Exception
     */
    public function actionCallcomm($id){
        if($id)
            echo CommentsWidget::widget(['article_id' => $id,
            'module_path' => \Yii::$app->view->theme->baseUrl]);
        else echo 'ooppps!';
    }



}