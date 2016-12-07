<?php

namespace app\modules\krokodile\controllers;

use app\components\CommentsWidget;
use app\components\FrontEndController;
use app\components\RadioCommentsWidget;
use app\models\ArticlesContent;
use app\models\Author;
use app\models\Comments;
use app\models\ContactForm;
use app\models\Items;
use app\models\RadioComment;
use app\models\SongText;
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
        $comment = new RadioComment();


        return $this->render('index',['comment' => $comment]);

    }
    
    public function actionNoradio(){
        $comment = new RadioComment();
        $texts = SongText::find()->limit(10)->all();
        return $this->render('noradio',['comment' => $comment, 'texts' => $texts]);
    }

    /**
     * Добавление комментариев
     * @return string
     */
    public function actionAddcomment(){

        $model = new RadioComment();

        $model->body = Yii::$app->request->post('RadioComment')['body'];
        if(Yii::$app->getRequest()->getQueryParam('name'))
            $model->name = Yii::$app->getRequest()->getQueryParam('name');

        if(Yii::$app->getRequest()->getQueryParam('body'))
            $model->body = Yii::$app->getRequest()->getQueryParam('body');

        $model->status = 'published';

        if($model->save(false)) return /*"
                <script>
                if($.cookie('name')) $('.field-comments-name').html( 'Привет, ' +  $.cookie('name'));

            </script>
            ".
        */
            "<p style='color: green'>Ответ опубликован</p>"
        ;


        return "<p style='color: red'>Попробуйте ещё раз чуть позже</p>";

    }

    /**
     * Вызов виджета комментариев без перезагрузки
     * 
     * @throws \Exception
     */
    public function actionCallcomm(){
      
            echo RadioCommentsWidget::widget([
                'module_path' => \Yii::$app->view->theme->baseUrl]);

    }

    /**
     * Случайный айтем
     * @return string
     */
    function actionRandItem(){
        //return 45;
        $thoughts = Items::find()
            ->where("source_id = 27 or source_id = 17 or
            source_id = 37 or source_id = 336 or source_id = 528 or cat_id = 104 or cat_id = 94")
            ->andWhere('cens = 0')
            ->orderBy('id ASC')
            ->all();
        $random_ind = rand(0, count($thoughts)-1);
        
        if($thoughts[$random_ind])
            return "document.getElementById('rand').innerHTML = \"".addcslashes(nl2br($thoughts[$random_ind]->text, false), "\r\n\"\'")."<br><span style='font-size: 15px'> (".$thoughts[$random_ind]->source->title. " - " .
            $thoughts[$random_ind]->source->author->name.")</span>"."\";";
        else return "document.getElementById('rand').innerHTML = 'Доброго Вам Времени!';";
    }



}