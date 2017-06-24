<?php

namespace common\models\weixin;

use Yii;

/**
 * This is the model class for table "oauth_member".
 *
 * @property integer $id
 * @property string $openid
 * @property string $nickname
 * @property integer $sex
 * @property string $avatar
 * @property string $updated_time
 * @property string $created_time
 */
class OauthMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oauth_member';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dream_wechat');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['openid', 'nickname'], 'string', 'max' => 100],
            [['avatar'], 'string', 'max' => 200],
            [['openid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'nickname' => 'Nickname',
            'sex' => 'Sex',
            'avatar' => 'Avatar',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
