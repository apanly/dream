<?php

namespace common\models\weixin;

use Yii;

/**
 * This is the model class for table "oauth_access_token".
 *
 * @property integer $id
 * @property string $access_token
 * @property string $expired_time
 * @property string $created_time
 */
class OauthAccessToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oauth_access_token';
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
            [['expired_time', 'created_time'], 'safe'],
            [['access_token'], 'string', 'max' => 600],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_token' => 'Access Token',
            'expired_time' => 'Expired Time',
            'created_time' => 'Created Time',
        ];
    }
}
