<?php
namespace app\components;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
//use yii\filters\VerbFilter;
//use app\models\LoginForm;
//use app\models\ContactForm;
use app\components\BaseController;
use app\modules\weather\models\Weather;

class FrontEndController extends BaseController
{
    public $theme;

    public function init()
    {
        //if(isset($_GET['siteParamIdForTheme'])) {$this->theme = $_GET['siteParamIdForTheme'];}
        //if(isset($_GET['admin'])) {$this->theme = 'admin';}
        //@TODO $_GET сделать через request
        if (isset($_GET['siteParamIdForTheme'])) {
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