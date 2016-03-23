<?php
namespace app\modules\markself;

//use app\config\out;

class Markself extends \yii\base\Module
{
    public $returnUrl = ["/markself/default/index"];
    public $loginUrl = ["/markself/security/login"];

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/markself/views'];
        \Yii::$app->view->theme->baseUrl = '@web/themes/markself' /*. $this->controllerMap->theme*/;

    }

}