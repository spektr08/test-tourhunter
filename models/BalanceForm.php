<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class BalanceForm extends Model
{
    public $user;
    public $balance;
    public $user_id_from;
    public $user_id_to;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['balance', 'user'], 'required'],
            [['balance'], 'number','min'=>0],
            ['user', 'compare', 'compareValue' => Yii::$app->user->identity->name, 'operator' => '!=', 'type' => 'string'],
            
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'user' => 'User',
            'balance' => 'Blance',
        ];
    }

    
     public function submit(){
        $this->user_id_from = Yii::$app->user->id;
        $balanceWorker = new \app\workers\BalanceWorker($this);
        $this->user_id_to = $balanceWorker->movebalance(); 
        return true;
    }
}
