<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_openid_unionid".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $openid
 * @property string $unionid
 * @property string $updated_time
 * @property string $created_time
 */
class UserOpenidUnionid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_openid_unionid';
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
            [['uid'], 'required'],
            [['uid'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['openid', 'unionid'], 'string', 'max' => 50],
            [['uid', 'openid'], 'unique', 'targetAttribute' => ['uid', 'openid'], 'message' => 'The combination of Uid and Openid has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'openid' => 'Openid',
            'unionid' => 'Unionid',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
