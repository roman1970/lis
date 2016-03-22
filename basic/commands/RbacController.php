<?php
namespace app\commands;
use app\components\MyManager;
use app\components\rbac\GroupRule;
use Yii;
use yii\console\Controller;
use app\components\rbac\UserRoleRule;
use yii\web\IdentityInterface;

class RbacController extends Controller
{

    public function actionInit()
    {

        $auth = new MyManager();
        $auth->init();

        $auth->removeAll(); //удаляем старые данные
        // Rules
        $groupRule = new GroupRule();

        $auth->add($groupRule);

        // Roles
        $user = $auth->createRole('user');
        $user->description = 'User';
        $user->ruleName = $groupRule->name;
        $auth->add($user);

        $moderator = $auth->createRole(' moderator ');
        $moderator ->description = 'Moderator ';
        $moderator ->ruleName = $groupRule->name;
        $auth->add($moderator);
        $auth->addChild($moderator, $user);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $admin->ruleName = $groupRule->name;
        $auth->add($admin);
        $auth->addChild($admin, $moderator);

        $superadmin = $auth->createRole('superadmin');
        $superadmin->description = 'Superadmin';
        $superadmin->ruleName = $groupRule->name;
        $auth->add($superadmin);
        $auth->addChild($superadmin, $admin);

        //var_dump($auth->getRoles()); exit;

        // Superadmin assignments
        $auth->assign($superadmin, 1);


    }
}