<?php
namespace app\components;

use app\models\MarkIt;
use yii\base\Widget;
use yii\helpers\Url;

class UserAvgMarkWidget extends Widget
{
    public $user_id;
    public $group_id;
    public $user_avg;
    public $module_path;

    public function init()
    {
        parent::init();

        $this->user_avg = MarkIt::getThisGroupUsersAverageMark($this->group_id);

    }

    public function run()
    {
        return $this->render('users_marks', ['marks' => $this->user_avg]);
    }

    public function getViewPath()
    {
        return Url::to('@app'. $this->module_path. DIRECTORY_SEPARATOR . 'views');
    }



}