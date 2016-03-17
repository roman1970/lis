<?php
namespace app\components;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
//use yii\filters\VerbFilter;
//use app\models\LoginForm;
use app\models\Qpsites;
use app\components\BaseController;


class FrontEndController extends BaseController
{
    public $theme;
    public $site;

    public function init()
    {
        //if(isset($_GET['siteParamIdForTheme'])) {$this->theme = $_GET['siteParamIdForTheme'];}
        //if(isset($_GET['admin'])) {$this->theme = 'admin';}
        //@TODO $_GET сделать через request
        if (isset($_GET['siteParamIdForTheme'])) {
            try {
                $this->site = Qpsites::find()->where(['theme' => $_GET['siteParamIdForTheme']])->one();
            } catch (\ErrorException $e) {
                echo "Forbidden";
            }

            $this->theme = $_GET['siteParamIdForTheme'];
           // $site = new Qpsites;
            //var_dump($site); exit;
            //$this->defaultR
            //\Yii::$app->view->theme->pathMap = ['app/views' => 'app/themes/landberry/views'];
            //\Yii::$app->view->theme->baseUrl = '@app/themes/landberry';
            \Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/' . $this->theme . '/views'];
            \Yii::$app->view->theme->baseUrl = '@web/themes/' . $this->theme;


        }

    }

}