<?php

namespace common\models\applog;

use Yii;

/**
 * This is the model class for table "access_logs".
 *
 * @property integer $id
 * @property string $referer
 * @property string $target_url
 * @property string $user_agent
 * @property string $ip
 * @property string $created_time
 */
class AccessLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_logs';
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
            [['created_time'], 'safe'],
            [['referer'], 'string', 'max' => 300],
            [['target_url'], 'string', 'max' => 500],
            [['user_agent'], 'string', 'max' => 200],
            [['ip'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referer' => 'Referer',
            'target_url' => 'Target Url',
            'user_agent' => 'User Agent',
            'ip' => 'Ip',
            'created_time' => 'Created Time',
        ];
    }
}
