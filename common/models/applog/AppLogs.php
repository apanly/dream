<?php

namespace common\models\applog;

use Yii;

/**
 * This is the model class for table "app_logs".
 *
 * @property integer $id
 * @property string $app_name
 * @property string $request_uri
 * @property string $content
 * @property string $ip
 * @property string $ua
 * @property string $cookies
 * @property string $created_time
 */
class AppLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_logs';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dream_log');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['created_time'], 'safe'],
            [['app_name'], 'string', 'max' => 30],
            [['request_uri'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 500],
            [['ua', 'cookies'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_name' => 'App Name',
            'request_uri' => 'Request Uri',
            'content' => 'Content',
            'ip' => 'Ip',
            'ua' => 'Ua',
            'cookies' => 'Cookies',
            'created_time' => 'Created Time',
        ];
    }
}
