<?php

namespace app\controllers;

use app\models\Comments;
use Yii;

class CommentsController extends \yii\web\Controller
{
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionCreate(){
        if(Yii::$app->getRequest()->getQueryParam('name')) var_dump(Yii::$app->getRequest()->getQueryParam('host'));
        else echo 'no_name';

        if(Yii::$app->getRequest()->getQueryParam('body')) var_dump(Yii::$app->getRequest()->getQueryParam('body'));
        else echo 'no_body';


        $model = new Comments();
        if ($model->load(Yii::$app->request->post())) {
            $model->name = Yii::$app->request->post('Comments')['name'];
            $model->body = Yii::$app->request->post('Comments')['body'];
            $model->save();
        }
    }

}
