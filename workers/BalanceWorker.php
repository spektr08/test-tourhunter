<?php

namespace app\workers;

use Yii;

class BalanceWorker
{
    protected $user_id_from;
    protected $user_id_to;
    protected $balance;
    
    
    //get user_id to send balance
    public function __construct(\app\models\BalanceForm $balance){
        $user = \app\models\User::findOne(['username'=>$balance->user]);
        if(empty($user)){
            $user =  \app\models\User::create($balance->user);
        }
        $this->user_id_to = $user->id;
        $this->balance =  $balance->balance;
        $this->user_id_from= $balance->user_id_from;
    }
    
    //move balance from one user to another
    public function movebalance(){ 
        $balance_from = \app\models\Balance::findOne(['user_id'=>$this->user_id_from]);
        $balance_from->balance-= $this->balance;        
        $balance_to = \app\models\Balance::findOne(['user_id'=>$this->user_id_to]);
        $balance_to->balance+= $this->balance;
        if($balance_to->update() && $balance_from->update()){
            return $this->user_id_to;
        }else{
            return false;
        }
        
    }
    
    
    
}