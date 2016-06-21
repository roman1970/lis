<?php
namespace app\modules\prognose;

//use app\config\out;

class Prognose extends \yii\base\Module
{
    public $returnUrl = ["/prognose/default/index"];
    public $loginUrl = ["/prognose/security/login"];

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/prognose/views'];
        \Yii::$app->view->theme->baseUrl = '@web/themes/prognose' /*. $this->controllerMap->theme*/;

    }

}