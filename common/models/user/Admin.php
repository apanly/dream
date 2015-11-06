<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $uid
 * @property string $nickname
 * @property string $mobile
 * @property string $email
 * @property string $password
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class Admin extends \yii\db\ActiveRecord
{

    private $pass_salt = "yc^U2MvA@Or3rq@Y";

    public function getEncryptPassword($password){
        return md5(md5($this->pass_salt.$password));
    }

    public function ckeckPassword($password){
        return $this->password == $this->getEncryptPassword($password);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('blog');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['nickname'], 'string', 'max' => 20],
            [['mobile'], 'string', 'max' => 11],
            [['email'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'UID',
            'nickname' => 'Nickname',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'password' => 'Password',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
