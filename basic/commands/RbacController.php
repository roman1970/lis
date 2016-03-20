<?php
namespace app\commands;
use Yii;
use yii\console\Controller;
use app\components\rbac\UserRoleRule;

class RbacController extends Controller
{


    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "author" role and give this role the "createPost" permission
        $user = $auth->createRole('author');
        $auth->add($user);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($user, 2);
        $auth->assign($admin, 1);

    }
}