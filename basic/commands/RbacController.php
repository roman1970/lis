<?php
namespace app\commands;
use Yii;
use yii\console\Controller;
use app\components\rbac\UserRoleRule;

class RbacController extends Controller
{


    public function actionInit()
    { /*
        $auth = Yii::$app->authManager;	
        $auth->removeAll(); //удаляем старые данные

        //Создадим для примера права для доступа к админке
        //$dashboard = $auth->createPermission('dashboard');
        //$dashboard->description = 'Админ панель';
        //$auth->add($dashboard);

        //Включаем наш обработчик
        $rule = new UserRoleRule();
        //var_dump($rule); exit;
        $auth->add($rule);
        //Добавляем роли
        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $user->ruleName = $rule->name;
        $auth->add($user);
        $moder = $auth->createRole('moder');
        $moder->description = 'Модератор';
        $moder->ruleName = $rule->name;
        $auth->add($moder);
        //Добавляем потомков
        $auth->addChild($moder, $user);
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $moder);
        $adminRole = $auth->getRole('admin');
        $auth->assign($adminRole, 1);
*/
        $authManager = \Yii::$app->authManager;

        // Create roles
        $moder  = $authManager->createRole('moder');
        $user  = $authManager->createRole('user');
        $admin  = $authManager->createRole('admin');

        // Create simple, based on action{$NAME} permissions
        $login  = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');
        $error  = $authManager->createPermission('error');
        $signUp = $authManager->createPermission('sign-up');
        $index  = $authManager->createPermission('index');
        $view   = $authManager->createPermission('view');
        $update = $authManager->createPermission('update');
        $delete = $authManager->createPermission('delete');

        // Add permissions in Yii::$app->authManager
        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($error);
        $authManager->add($signUp);
        $authManager->add($index);
        $authManager->add($view);
        $authManager->add($update);
        $authManager->add($delete);


        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserRoleRule();
        $authManager->add($userGroupRule);

        // Add rule "UserGroupRule" in roles
        $user->ruleName  = $userGroupRule->name;
        $moder->ruleName  = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;

    }
}