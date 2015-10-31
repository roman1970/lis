<?php
namespace app\modules\knoledges;

//use app\config\out;

class Knoledges extends \yii\base\Module
{
    public $returnUrl = ["/knoledges/default/index"];

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/knoledges/views'];
        \Yii::$app->view->theme->baseUrl = '@web/themes/knoledges' /*. $this->controllerMap->theme*/;

    }

}