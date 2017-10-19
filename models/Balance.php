<?php

namespace app\models;


use app\models\behaviors\NumberBehavior;
use Yii;

/**
 * This is the model class for table "balance".
 *
 * @property integer $id
 * @property integer $user_id
 * @property double $balance
 */
class Balance extends \yii\db\ActiveRecord
{
    
    const SCENARIO_BALANCE = 'balance';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['balance'], 'number'],
        ];
    }
    
    public function behaviors() {
        return [
            [
                'class' => NumberBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['balance'],
                ],
            ],
        ];
    }
    
    
    
     public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getUserName() {
        return $this->user->username;    
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User Id',
            'userName' => 'User name',
            'balance' => 'Balance',
        ];
    }
    
}
