<?php

namespace app\workers;

use Yii;

class BalanceWorker
{
    protected $user_id_from;
    protected $user_id_to;
    protected $balance;
    protected $balanceHistory;




    //get user_id to send balance
    public function __construct(\app\models\BalanceForm $balance){
        $user = \app\models\User::findOne(['username'=>$balance->user]);
        $this->balanceHistory = new \app\models\BalanceHistory;
        if(empty($user)){
            $user =  \app\models\User::create($balance->user);
        }
        $this->user_id_to    =     $user->id;
        $this->balance       =     $balance->balance;
        $this->user_id_from  =     $balance->user_id_from;
    }
    
    //move balance from one user to another
    public function movebalance(){ 
        $balance_from = \app\models\User::findOne(['id'=>$this->user_id_from]);  
        $balance_to = \app\models\User::findOne(['id'=>$this->user_id_to]);
        
        \app\models\User::getDb()->transaction(function($db) use ($balance_from,$balance_to) {
            $balance_from->balance-= $this->balance;         
            $balance_to->balance+= $this->balance;
            
            
            $this->balanceHistory->user_id_from = $this->user_id_from;
            $this->balanceHistory->user_id_to = $this->user_id_to;
            $this->balanceHistory->balance = $this->balance;
            if($balance_from->update() && $balance_to->update() && $this->balanceHistory->save()){
                return true;
            }
        });
        return false;
        
    }
    
}