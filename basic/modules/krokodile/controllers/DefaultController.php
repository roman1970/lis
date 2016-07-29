<?php

namespace app\modules\krokodile\controllers;

use app\components\CommentsWidget;
use app\components\FrontEndController;
use app\components\RadioCommentsWidget;
use app\models\ArticlesContent;
use app\models\Author;
use app\models\Comments;
use app\models\ContactForm;
use app\models\RadioComment;
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
        return $this->render('noradio',['comment' => $comment]);
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


}