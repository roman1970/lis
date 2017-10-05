<?php
namespace app\modules\rockncontroll\controllers;

use yii\rest\ActiveController;

class ItemapiController extends ActiveController
{
   public $modelClass = 'app\models\Items';

   /* Declare actions supported by APIs (Added in api/modules/v1/components/controller.php too) */
   public function actions(){
      $actions = parent::actions();
      unset($actions['create']);
      unset($actions['update']);
      unset($actions['delete']);
      unset($actions['view']);
      unset($actions['index']);
      return $actions;
   }

   public function checkAccess($action, $model = null, $params = [])
   {
      // check if the user can either edit or delete the listing
      // eliminate the exception ForbiddenHttpException if there are no access rights
      if ($action === 'update' || $action === 'delete') {
        var_dump($model);
      }
   }
   
}