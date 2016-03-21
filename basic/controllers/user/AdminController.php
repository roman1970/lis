<?php
namespace app\controllers\user;

use app\models\User;
use dektrium\user\controllers\AdminController as BaseAdminController;
use dektrium\user\models\UserSearch;
use yii\helpers\Url;

class AdminController extends BaseAdminController
{
    public function actionCreate()
    {

        /** @var User $user */
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->create()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been created'));

            return $this->redirect(['update', 'id' => $user->id]);
        }

        return $this->render('create', [
            'user' => $user,
        ]);
    }

    public function  actionIndex(){
        //$this->layout = 'main';
        Url::remember('', 'actions-redirect');
        $searchModel  = \Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    public function actionInfo($id)
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);

        return $this->render('_info', [
            'user' => $user,
        ]);
    }

}