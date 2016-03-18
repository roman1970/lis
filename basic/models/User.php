<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    
    const ROLE_USER = 1;
    const ROLE_MODER = 5;
    const ROLE_ADMIN = 10;

    private static $users;
   
    public function register()
    {
       
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
      return new static(static::find()->where(['id' => $id])->asArray()->one());
    }
     
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public function rules(){
        ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_MODER, self::ROLE_ADMIN]];
    }

    /**
     * @inheritdoc
     *
     */
     
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function isUserAdmin($username)
    {
        if (static::findOne(['username' => $username, 'role' => self::ROLE_ADMIN]))
        {
            return true;
        } else {
            return false;
        }
    }
}
