<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $login_name
 * @property string $login_pwd
 * @property string $salt
 * @property string $email
 * @property string $avatar
 * @property string $last_ip
 * @property string $last_city
 * @property integer $last_city_id
 * @property string $last_active_time
 * @property string $reg_ip
 * @property string $reg_city
 * @property integer $reg_city_id
 * @property string $updated_time
 * @property string $created_time
 */
class Member extends \yii\db\ActiveRecord
{
	public function setPassword( $password ) {

		$this->login_pwd = $this->getSaltPassword($password);
	}

	public function setSalt( $length = 16 ){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
		$salt = '';
		for ( $i = 0; $i < $length; $i++ ){
			$salt .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
		$this->salt = $salt;
	}

	public function getSaltPassword($password) {
		return md5( $password.md5( $this->salt ) );
	}

	public function verifyPassword($password) {
		return $this->login_pwd === $this->getSaltPassword($password);
	}
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
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
            [['last_city_id', 'reg_city_id'], 'integer'],
            [['last_active_time', 'updated_time', 'created_time'], 'safe'],
            [['login_name'], 'string', 'max' => 20],
            [['login_pwd', 'salt', 'last_ip', 'reg_ip'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 60],
            [['avatar'], 'string', 'max' => 500],
            [['last_city', 'reg_city'], 'string', 'max' => 10],
            [['email'], 'unique'],
            [['login_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login_name' => 'Login Name',
            'login_pwd' => 'Login Pwd',
            'salt' => 'Salt',
            'email' => 'Email',
            'avatar' => 'Avatar',
            'last_ip' => 'Last Ip',
            'last_city' => 'Last City',
            'last_city_id' => 'Last City ID',
            'last_active_time' => 'Last Active Time',
            'reg_ip' => 'Reg Ip',
            'reg_city' => 'Reg City',
            'reg_city_id' => 'Reg City ID',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
