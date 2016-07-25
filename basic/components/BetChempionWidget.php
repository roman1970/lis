<?php
namespace app\components;

use app\models\Totpredict;
use app\models\Totuser;
use yii\base\Widget;
use yii\helpers\Url;

class BetChempionWidget extends Widget
{
    public $user_id;
    public $user_sum;
    public $module_path;
    public $users_status;


    public function init()
    {
        parent::init();
        $this->user_sum = Totpredict::getUsersBalls();
        $this->user_sum = Totuser::find()->orderBy('balance DESC')->all();
        //$this->users_status = Totpredict::getUsersStatus();

    }

    public function run()
    {
        return $this->render('usersum', ['user_sum' => $this->user_sum,
            'user_id' => $this->user_id
            ]);
    }

    public function getViewPath()
    {
        return Url::to('@app' . $this->module_path . DIRECTORY_SEPARATOR . 'views');
    }

    public function getPastDates($day_before = 1)
    {
        return date("Y-m-d", time() - (60 * 60 * 24) * $day_before);
    }
}
