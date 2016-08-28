<?php
namespace app\controllers;

use app\components\BackEndController;
use app\components\TranslateHelper;
use app\models\Author;
use app\models\ArticlesContent;
use app\models\AuthorSearch;
use yii\helpers\Url;
use Yii;
use yii\data\ActiveDataProvider;

class AuthorController extends BackEndController
{
    public $layout = 'admin';

    public function actionIndex()
    {
        /*
        $authors = Author::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $authors,
        ]);

        return $this->render('index', ['authors' => $dataProvider]);
        */

        $searchModel = new AuthorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', ['authors' => $dataProvider, 'searchModel' => $searchModel]);
    }

    /**
     * Создание автораа
     * @return string
     */
    public function actionCreate()
    {
        $model = new Author();


        if ($model->load(Yii::$app->request->post())) {
            $model->name = Yii::$app->request->post('Author')['name'];
            $model->status = Yii::$app->request->post('Author')['status'];
            $model->country_id = Yii::$app->request->post('Author')['country_id'];

            $model->save(false);

            $authors = Author::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $authors,
            ]);

            return $this->redirect(Url::toRoute('author/index'));

        } else {

            return $this->render('_form', [
                'model' => $model,

            ]);
        }

    }

}