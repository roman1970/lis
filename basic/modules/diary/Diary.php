<?php
namespace app\modules\diary;

use Yii;

class Diary extends \yii\base\Module
{
    public $returnUrl = ["/diary/default/index"];
    
    public function init()
    {
       parent::init();
        //\Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/theme1/views'];     
        //\Yii::$app->view->theme->baseUrl = '@web/themes/theme1';
    }
    
    
    
}
