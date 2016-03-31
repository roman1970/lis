<?php
namespace app\modules\krokodile;

//use app\config\out;

class Krokodile extends \yii\base\Module
{
    public $returnUrl = ["/krokodile/default/index"];

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/krokodile/views'];
        \Yii::$app->view->theme->baseUrl = '@web/themes/krokodile' /*. $this->controllerMap->theme*/;

    }

}