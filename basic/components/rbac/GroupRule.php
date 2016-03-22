<?php
namespace app\components\rbac;

use yii\rbac\Rule;

class GroupRule extends Rule {
    public $name = 'group';


    public function execute($user, $item, $params)
    {
        if (!\Yii::$app->user->isGuest) {
            $role = \Yii::$app->authManager->getItemsByUser($user);

            if ($item->name === 'superadmin') {
                return true;
            } else
                return false;

        }
    }

}