<?php

namespace tests\models;

use app\models\LoginForm;
use Codeception\Specify;
use app\models\User;
use app\models\Balance;

class BalanceFormTest extends \Codeception\Test\Unit
{
    private $model;
    
    protected function _before()
    {
       $user =  User::findOne(['username' => 'test']);
       if(!empty($user)){
            $balance = Balance::findOne(['user_id'=>$user->id]);
            $balance->delete();
            $user->delete();
       }
    }

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'username' => 'test',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
    }
    
    public function testBalanceAfterUserCreate(){
        
        $this->model = new LoginForm([
            'username' => 'test',
        ]);
        $this->model->login();
                
       $balance = Balance::findOne(['user_id'=>\Yii::$app->user->id]);
       expect_that($balance->balance == 0);
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'username' => 'test',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
    }
    
    

}
