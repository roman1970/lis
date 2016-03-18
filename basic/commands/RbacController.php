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

    }
}