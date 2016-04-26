<?php

namespace app\tests;

//use app\models\User;

use app\models\MarkUser;
use app\tests\TestCaseT;

require(__DIR__ . '/_bootstrap.php');

class UserTest extends TestCaseT {

    /*

    public function testValidateEmptyValues(){
        $user = new MarkUser();

        $this->assertFalse($user->validate(), 'model not valid');
        $this->assertArrayHasKey('name', $user->getErrors(), 'check name error');
        $this->assertArrayHasKey('pseudo', $user->getErrors(), 'check pseudo error');

    }

    public function testValidateWrongValues(){
        $user = new MarkUser([
            'name' => 'wrong @ name',
            'pseudo' => 'wrong @ pseudo'
        ]);

        $this->assertFalse($user->validate(), 'validate incorrect name and pseudo');
        $this->assertArrayHasKey('name', $user->getErrors(), 'check incorrect name error');
        $this->assertArrayHasKey('pseudo', $user->getErrors(), 'check incorrect pseudo error');
    }

    public function testValidateCorrectValues(){

        $user = new MarkUser([
            'name' => 'correct_name',
            'pseudo' => 'correct_pseudo'
        ]);

        $this->assertTrue($user->validate(), 'correct model is valid');
    }
    */

    public function testSaveIntoDatabase(){
        $user = new MarkUser([
            'name' => 'TestUserName',
            'pseudo' => 'TestUserPseudo'
        ]);

        $this->assertTrue($user->save(), 'model is saved');

    }
}

/*
$test = new UserTest();
$test->testValidateEmptyValues();

$test = new UserTest();
$test->testValidateWrongValues();

$test = new UserTest();
$test->testValidateCorrectValues();
*/

$class = new \ReflectionClass('app\tests\UserTest');
foreach($class->getMethods() as $method)
{
    if(substr($method->name, 0, 4) == 'test') { //считаем тестами методы, начинающиеся с префикса test
        echo 'Test ' . $method->class . '::' . $method->name . PHP_EOL . PHP_EOL;
        /** @var TestCaseT $test */

        $test = new $method->class;
       // var_dump($test);
        $test->{$method->name}();
        echo PHP_EOL;
    }

}
