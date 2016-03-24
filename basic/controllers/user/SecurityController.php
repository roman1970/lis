<?php
namespace app\controllers\user;

use dektrium\user\controllers\SecurityController as BaseSecurityController;
use dektrium\user\models\LoginForm;
use Yii;
use yii\web\Response;


class SecurityController extends BaseSecurityController
{
    /**
     * Displays the login page.
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $model = \Yii::createObject(LoginForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login() && (Yii::$app->user->identity->getId() == 1
        || Yii::$app->user->identity->getId() == 4)) {
            return $this->redirect(\Yii::$app->urlManager->createUrl("admin/index"));
        }

        elseif ($model->load(Yii::$app->getRequest()->post()) && $model->login()){
            return $this->redirect(\Yii::$app->urlManager->createUrl("admin/usermod"));
        }

        elseif(Yii::$app->getRequest()->post()) return 'l';


        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }


}