<?php
namespace app\modules\rockncontroll;

use Yii;

class Module extends \yii\base\Module
{
    public $returnUrl = ["/rockncontroll/default/index"];
    
    public function init()
    {
       // echo 'gg'; exit;
       parent::init();
        \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/rockncontroll/views'];
        \Yii::$app->view->theme->baseUrl = '@web/themes/rockncontroll' /*. $this->controllerMap->theme*/;
    }
    
    
    
}
