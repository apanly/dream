<?php

namespace common\models\oauth;

use Yii;

/**
 * This is the model class for table "oauth_bind".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $client_type
 * @property string $openid
 * @property string $extra
 * @property string $created_time
 */
class OauthBind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oauth_bind';
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
            [['uid'], 'integer'],
            [['extra'], 'required'],
            [['extra'], 'string'],
            [['created_time'], 'safe'],
            [['client_type'], 'string', 'max' => 20],
            [['openid'], 'string', 'max' => 80],
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
            'client_type' => 'Client Type',
            'openid' => 'Openid',
            'extra' => 'Extra',
            'created_time' => 'Created Time',
        ];
    }
}
