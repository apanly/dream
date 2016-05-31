<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $uid
 * @property string $nickname
 * @property string $avatar
 * @property string $mobile
 * @property string $updated_time
 * @property string $created_time
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
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
            [['updated_time', 'created_time'], 'safe'],
            [['nickname'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 500],
            [['mobile'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'nickname' => 'Nickname',
            'avatar' => 'Avatar',
            'mobile' => 'Mobile',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
