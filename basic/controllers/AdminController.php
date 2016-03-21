<?php
namespace app\controllers;

use app\components\BackEndController;

class AdminController extends BackEndController
{
    public $layout = 'admin';


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUsermod()
    {
        //$this->layout = 'main';
        return $this->render('usermod');
    }

}