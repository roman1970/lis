<?php
namespace app\modules\bardzilla;

//use app\config\out;

class Bardzilla extends \yii\base\Module
{
    public $returnUrl = ["/bardzilla/default/index"];

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/bardzilla/views'];
        \Yii::$app->view->theme->baseUrl = '@web/themes/bardzilla' /*. $this->controllerMap->theme*/;

    }

}