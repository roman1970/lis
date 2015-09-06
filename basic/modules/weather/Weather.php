<?php
namespace app\modules\weather;

//use app\config\out;

class Weather extends \yii\base\Module
{
    public $returnUrl = ["/weather/default/index"];

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/landberry/views'];
        \Yii::$app->view->theme->baseUrl = '@app/themes/landberry' /*. $this->controllerMap->theme*/;
    }

}