<?php

namespace app\modules\bardzilla\controllers;

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
    public $cat_id;
    public $article_id;
    public $articles = [];
    public $source;
    public $author;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $visit = new Visit();
        if(isset($_SERVER['REMOTE_ADDR'])) $visit->ip = $_SERVER['REMOTE_ADDR'];
        //if(isset($_SERVER['HTTP_REFERER'])) $visit->refer = $_SERVER['HTTP_REFERER'];
        $visit->refer = self::get_all_ip();
        $visit->browser = implode(';',$_SERVER);
        $visit->save(false);
        //var_dump($_SERVER['REMOTE_ADDR']); exit;

        $cats = Categories::find()->where('site_id ='.$this->site->id)->roots()->all();


        if(__DIR__ == '/home/romanych/public_html/plis/basic/modules/bardzilla/controllers') {

            $songs = ArticlesContent::find()
                ->where(['articles_id' => 22])->all(); $rand_song = $songs[rand(0,count($songs))];

        }
        else {
            $songs = ArticlesContent::find()
                ->where(['articles_id' => 3])->all(); $rand_song = $songs[rand(0,count($songs))];

        }

        return $this->render('index', ['cats' => $cats, 'article' => $rand_song]);

    }

    /**
     * Показывает контент
     * @return string
     * @TODO Нужно предусмотреть возможность вывода разного контента, привязаного к одной категории
     *
     */
    public function actionShow()
    {

        $this->cat_id = Yii::$app->getRequest()->getQueryParam('id') ? Yii::$app->getRequest()->getQueryParam('id') : null;
        $cat_obg = Categories::find()
            ->where('id = ' . $this->cat_id)
            ->one();

        $allContent = Articles::find()
            ->where('cat_id = ' . $this->cat_id)
            ->all();
        $allArticlesForPager = Articles::find()
            ->where(['cat_id' => $this->cat_id]);

        $countQueryCont = clone $allArticlesForPager;
        $pagesGlobal = new Pagination(['totalCount' => $countQueryCont->count(),
            'pageSize' => 1,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        $artPages = $allArticlesForPager->offset($pagesGlobal->offset)
            ->limit($pagesGlobal->limit)
            ->all();


           foreach ($allContent as $article) {
            //var_dump($this->cat_id);
           $this->article_id = $article->id;

            $article = Articles::findOne($this->article_id);


            $allArticles = ArticlesContent::find()
                ->where(['articles_id' => $this->article_id])
                ->orderBy(['id' => SORT_DESC]);

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

            $this->articles[]  = ['article' => $article,'contents' => $models, 'pages' => $pages,
                'source' => $this->source,
                'author' => $this->author
               ];


        }

        //var_dump($this->articles); exit;
        return $this->renderPartial($cat_obg->action,
            [
                'articles' => $this->articles,
                'cat' => $this->cat_id,
                'pagesGlobal' =>  $pagesGlobal,
                'artPages' => $artPages,
                'cat_obg' => $cat_obg,

            ]);



    }

    /**
     * Счётчик посещения страниц
     * @return bool
     * @throws \Exception
     */
    public function actionCounter(){

        $this->article_id = Yii::$app->getRequest()->getQueryParam('id') ? Yii::$app->getRequest()->getQueryParam('id') : null;
        $article = ArticlesContent::find()
            ->where('id = '. $this->article_id)
            ->one();
        $article->count++;
        if($article->update()) return true;
        else return false;
    }

    /**
     * Показывает и считает аудио-страницы
     * @param $id
     * @return string
     */
    public function actionShowlikes($id) {

        $article = ArticlesContent::findOne($id);
        $article->count++;
        $article->update();

        return $this->renderPartial('showlikes', ['article' => $article]);

    }

    /**
     * Устанавливает и показывает лайки
     * @param $id
     * @return mixed
     */
    public function actionSetlikes($id) {

        $article = ArticlesContent::findOne($id);
        $article->likes++;
        $article->update();

        return 'лайков '.$article->likes.' - прослушиваний '.$article->count;

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


    /**
     * Обрабатываем контактную форму
     * @return string|\yii\web\Response
     */
    public function actionContacts()
    {

        /* Создаем экземпляр класса */
        $model = new ContactForm();

        if(Yii::$app->request->get()){
            $model->name = Yii::$app->getRequest()->getQueryParam('name');
            $model->email = Yii::$app->getRequest()->getQueryParam('email');
            $model->body = Yii::$app->getRequest()->getQueryParam('text');
            $model->subject = 'subj';
            if($model->contact(Yii::$app->params['adminEmail']))
            return true;
            else return Yii::$app->params['adminEmail'];
        }

        else {
            return false;
        }



    }

    /**
     * Получаем все ip из $_SERVER
     * @return string
     */
    function get_all_ip() {
        $ip_pattern="#(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)#";
        $ret="";
        foreach ($_SERVER as $k => $v) {
            if (substr($k,0,5)=="HTTP_" AND preg_match($ip_pattern,$v)) $ret.=$k.": ".$v."\n";
        }
        return $ret;
    }





}