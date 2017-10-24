<?php
 
namespace app\models;
 
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\behaviors\NumberBehavior;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property integer $status
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
 
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => NumberBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['balance'],
                ],
            ],
        ];
    }
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username'], 'string'],
            [['balance'], 'number']
        ];
    }
    
    
    
 
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
 
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
 
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
 
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    public function getName()
    {
        return $this->username;
    }
 
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
         return false;
    }
 
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
       throw new NotSupportedException('"validatePassword" is not implemented.');
    }
    
    /**
     * Validates AuthKey
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validateAuthKey($key)
    {
       return false;
       throw new NotSupportedException('"validateAuthKey" is not implemented.');
    }
 
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        throw new NotSupportedException('"setPassword" is not implemented.');
    }
 
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        throw new NotSupportedException('"generateAuthKey" is not implemented.');
    }
    
    
    public static function create($name) {
        $model = User::find()->where(['username' => $name])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = $name;
            $user->balance = 0;
            if ($user->save()) {
                return $user;
            }
        }
        return $model;
    }

}