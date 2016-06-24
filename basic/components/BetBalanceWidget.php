<?php
namespace app\components;

use app\models\Totpredict;
use yii\base\Widget;
use yii\helpers\Url;

class BetBalanceWidget extends Widget
{
    public $user_id;
    public $balance;
    public $strict_predict;
    public $result;
    public $bad_predict;
    public $module_path;

    public function init()
    {
        parent::init();
        $this->balance = Totpredict::find()
            ->select('SUM(bet_balance)')
            ->where(['user_id' => $this->user_id])
            ->scalar();
        $this->strict_predict = Totpredict::find()
            ->select('COUNT(status)')
            ->where(['user_id' => $this->user_id])
            ->andWhere(['status' => 3])
            ->scalar();
        $this->result = Totpredict::find()
            ->select('COUNT(status)')
            ->where(['user_id' => $this->user_id])
            ->andWhere(['status' => 2])
            ->scalar();
        $this->bad_predict = Totpredict::find()
            ->select('COUNT(status)')
            ->where(['user_id' => $this->user_id])
            ->andWhere(['status' => 1])
            ->scalar();

    }

    public function run()
    {
        return $this->render('balance', ['balance' => $this->balance,
                                        'strict' => $this->strict_predict,
                                        'result' => $this->result,
                                        'bed_predict' => $this->bad_predict]);
    }

    public function getViewPath()
    {
        return Url::to('@app'. $this->module_path. DIRECTORY_SEPARATOR . 'views');
    }

    public function getPastDates($day_before=1){
        return date("Y-m-d", time() - (60 * 60 * 24)*$day_before);
    }



}