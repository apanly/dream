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
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $headimgurl
 * @property string $avatar
 * @property integer $subscribe
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
            [['sex', 'subscribe'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['openid', 'nickname', 'country', 'province', 'city'], 'string', 'max' => 100],
            [['headimgurl', 'avatar'], 'string', 'max' => 300],
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
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'headimgurl' => 'Headimgurl',
            'avatar' => 'Avatar',
            'subscribe' => 'Subscribe',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
