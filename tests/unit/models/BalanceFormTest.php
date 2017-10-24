<?php

namespace tests\models;

use app\models\LoginForm;
use app\models\BalanceForm;
use Codeception\Specify;
use app\models\User;
use app\models\Balance;
use app\models\BalanceHistory;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;
    

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testBalanceNoUser()
    {
       $user =  User::findOne(['username' => 'test']);
       if(!empty($user)){
            $user->delete();
       }
        
        $this->model = new LoginForm([
            'username' => 'admin',
        ]);
        $this->model->login();
        $this->model = new BalanceForm([
            'user' => 'test',
            'balance'=> 10.25,
        ]);
        $this->model->submit();
        $user =  User::findOne(['username' => 'test']); 
        expect_that(!empty($user));
        expect_that($user->balance == 10.25);
       
    }
    
    public function testBalanceIsUser()
    {
        $this->model = new LoginForm([
            'username' => 'admin',
        ]);
        $this->model->login();
        $this->model = new BalanceForm([
            'user' => 'test',
            'balance'=> 1.001,
        ]);
        $this->model->submit();
        $user =  User::findOne(['username' => 'test']); 
        expect_that(!empty($user));
        expect_that($user->balance == 11.25);
       
    }
    
    public function testBalanceIsNotNumber()
    {
        $this->model = new LoginForm([
            'username' => 'admin',
        ]);
        $this->model->login();
        $this->model = new BalanceForm([
            'user' => 'test',
            'balance'=> 'aa',
        ]);
        
        expect('balance in not number',$this->model->validate())->false();
       
    }
    

}
