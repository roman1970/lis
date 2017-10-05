<?php
namespace app\controllers;

use yii\rest\ActiveController;

class ItemapiController extends ActiveController
{
   public $modelClass = 'app\models\Items';
}