<?php
namespace app\modules\user;

class Module extends \dektrium\user\Module
{
    public $controllerMap = [
        'admin'    => 'app\controllers\user\AdminController',
        'security' => 'app\controllers\user\SecurityController',
        //'admin'    => 'app\controllers\user\AdminController',
        //'security' => 'user\controllers\SecurityController',
        'registration' => 'dektrium\user\controllers\RegistrationController',
        'recovery'     => 'dektrium\user\controllers\RecoveryController',
        'settings'     => 'dektrium\user\controllers\SettingsController',
        'profile'      => 'dektrium\user\controllers\ProfileController',
    ];
}
