<?php

namespace app\models;

use Yii;
use app\models\behaviors\NumberBehavior;

/**
 * This is the model class for table "balance_history".
 *
 * @property integer $id
 * @property integer $user_id_from
 * @property integer $user_id_to
 * @property double $balance
 * @property string $date
 */
class BalanceHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'balance_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id_from', 'user_id_to'], 'integer'],
            [['balance'], 'number'],
            [['date'], 'safe'],
        ];
    }
    
    
    public function behaviors() {
        return [
            [
                'class' => NumberBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['balance'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id_from' => 'User Id From',
            'user_id_to' => 'User Id To',
            'balance' => 'Balance',
            'date' => 'Date',
        ];
    }
    
    public function getUsername($user_id){
        $user =  User::findOne(['id'=>$user_id]);
        if(!empty($user)){
            return $user->username;
        }
    }
}
