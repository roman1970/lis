<?php
namespace app\modules\khl;

use Yii;

class Khl extends \yii\base\Module
{
    public $returnUrl = ["/khl/default/index"];

    public function init()
    {
        parent::init();
        //\Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/theme1/views'];     
        //\Yii::$app->view->theme->baseUrl = '@web/themes/theme1';
    }



}
