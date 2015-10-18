<?php
namespace app\modules\russia2018;

//use app\config\out;

class Russia2018 extends \yii\base\Module
{
    public $returnUrl = ["/russia2018/default/index"];

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/russia2018/views'];
        \Yii::$app->view->theme->baseUrl = '@web/themes/russia2018' /*. $this->controllerMap->theme*/;

    }

}