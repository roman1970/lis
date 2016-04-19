<?php
namespace app\modules\magazin;

//use app\config\out;

class Magazin extends \yii\base\Module
{
    public $returnUrl = ["/magazin/default/index"];

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/magazin/views'];
        \Yii::$app->view->theme->baseUrl = '@web/themes/magazin' /*. $this->controllerMap->theme*/;

    }

}