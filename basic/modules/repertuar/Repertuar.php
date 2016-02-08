<?php

namespace app\modules\repertuar;

class Repertuar extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\repertuar\controllers';
    public $returnUrl = ["/repertuar/default/index"];
    public $layout = 'main';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
