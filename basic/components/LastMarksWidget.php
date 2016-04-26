<?php
namespace app\components;

use app\models\MarkIt;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Comments;
use yii\helpers\Url;

class LastMarksWidget extends Widget
{
    public $user_id;
    public $marks = [];
    public $module_path;

    public function init()
    {
        parent::init();
        if ($this->user_id != null) {
            for($i=0; $i < 15; $i++) {
                $this->marks[$this->getPastDates($i)] =
                    ($mrk = MarkIt::getAverageForDateAndUser($this->getPastDates($i), $this->user_id)) ? $mrk : 0;

            }

        }

    }

    public function run()
    {
        return $this->render('marks', ['marks' => $this->marks]);
    }

    public function getViewPath()
    {
        return Url::to('@app'. $this->module_path. DIRECTORY_SEPARATOR . 'views');
    }

    public function getPastDates($day_before=1){
        return date("Y-m-d", time() - (60 * 60 * 24)*$day_before);
    }



}