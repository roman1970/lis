<?php

namespace tests;

//use app\models\User;

use app\models\MarkUser;

require(__DIR__ . '/_bootstrap.php');

class UserTest {

    protected function assert($condition, $messages = ''){
        echo $messages;
        if($condition){
            echo ' OK ' . PHP_EOL;
        } else {
            echo ' Fail ' . PHP_EOL;
        }
    }

    public function testValidateEmptyValues(){
        $user = new MarkUser();

        $this->assert($user->validate() == false, 'model not valid');
        $this->assert(array_key_exists('name', $user->getErrors()), 'check name error');
        $this->assert(array_key_exists('pseudo', $user->getErrors()), 'check pseudo error');

    }
}

$test = new UserTest();
$test->testValidateEmptyValues();
