<?php

namespace app\modules\knoledges\controllers;

use app\components\CommentsWidget;
use app\components\FrontEndController;
use app\models\ArticlesContent;
use app\models\Author;
use app\models\Comments;
use app\models\ContactForm;
use app\models\Source;
use app\models\TestAnswers;
use app\models\TestQuestions;
use app\models\UploadForm;
use Yii;
use app\models\Categories;
use yii\data\Pagination;

use app\models\Articles;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\UploadedFile;


class DefaultController extends FrontEndController
{
    public $cat_id;
    public $article_id;
    public $articles = [];
    public $title;
    public $source;
    public $author;
    public static $content_id;

    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['tablo'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
    */

    /**
     * @return string
     */
    public function actionIndex()
    {
        if(isset(Yii::$app->request->get()['id'])){
            return $this->render('tablo');
        }
        elseif (isset(Yii::$app->request->get()['eng'])){
            $rand_item = rand(0,(count(TestQuestions::find()->where('cat_id = 213 and used = 0')->all())-1));
            $test = TestQuestions::find()->where('cat_id = 213 and used = 0')->all()[$rand_item];
            $test->used = 1;
            $test->update();

            return $this->render('@app/modules/rockncontroll/views/default/english',
                ['test' => $test]
            );
        }
        else{
            $tests = TestQuestions::find()->where(['cat_id' => 205])->all();

            $test = $tests[rand(0,count($tests)-1)];

            return $this->render('index',
                ['test' => $test]
            );
        }


    }
    
    public function actionTablo(){
        //return var_dump(Yii::$app->request->get()['id']);
        //return var_dump($_SERVER['HTTP_REFERER']);
        //return $this->redirect(Yii::$app->request->referrer);
        if(Yii::$app->request->get()['id']){
            return $this->render('tablo');
        }
        else {
            //return var_dump('g');
            $tests = TestQuestions::find()->where(['cat_id' => 205])->all();

            $test = $tests[rand(0,count($tests)-1)];

            // $cats = Categories::find()->where('site_id ='.$this->site->id)->roots()->all();
            // $articles = Articles::find()->where('site_id ='.$this->site->id.' or site_id = 13')->all();

            //$cats = Categories::find()->leaves()->all();

            return $this->render('index',
                ['test' => $test]
            );
        }
    }

    public function actionEnglish(){

        $test = TestQuestions::find()->where(['cat_id' => 213])->all()[0];

        return $this->render('english',
            ['test' => $test]
        );
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

            if($model->save(false)) return "<script>
                if($.cookie('name')) $('.field-comments-name').html( 'Привет, ' +  $.cookie('name'));

            </script><p style='color: green'>Ответ опубликован</p>";


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

    /**
     * Проверяем, верен ли ответ
     * @param $id
     * @return int
     */
    function actionTrue($id){
        return TestAnswers::findOne($id)->true;
    }

    /**
     * Отдаём вопрос теста
     * @return string
     */
    function actionQuestion(){
        if(isset(Yii::$app->request->get()['id'])){
            $id = Yii::$app->request->get()['id'];
            //return 2;
            $answer = TestAnswers::findOne($id);

            if(isset(TestQuestions::find()->where('cat_id = 213 and id >'.$answer->question_id)->all()[0])) {
                $test = TestQuestions::find()->where('cat_id = 213 and id >'.$answer->question_id)->all()[0];

                return $this->renderPartial('question',
                    ['test' => $test]);
            }

            else return '<p class="big_font_with_padding">Тест закончен</p>';

        }
    }

    function actionQuestionEnd(){
        $used_tests = TestQuestions::find()->where('cat_id = 213 and used = 1')->all();

        foreach ($used_tests as $test){
            $test->used = 0;
            $test->update();
        }
        return '<p class="big_font_with_padding">Тест закончен</p>';
    }
    
   

}