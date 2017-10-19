<?php

namespace app\workers;

use Yii;

class BalanceHistoryWorker  
{
    
    protected $balanceHistory;
    
    
    //get DI
    public function __construct(\app\models\BalanceHistory $balanceHistory){
        $this->balanceHistory = $balanceHistory;
    }
    
    //save history after balance operation
    public function saveBalanceHistory($user_id_from,$user_id_to,$balance){ 
        $this->balanceHistory->user_id_from = $user_id_from;
        $this->balanceHistory->user_id_to = $user_id_to;
        $this->balanceHistory->balance = $balance;
        if($this->balanceHistory->save()){
            return true;
        }else{
            return false;
        }
        
    }
    
    
    
}