<?php

namespace common\models\applog;

use Yii;

/**
 * This is the model class for table "admin_access_log".
 *
 * @property integer $id
 * @property integer $target_type
 * @property integer $target_id
 * @property integer $act_type
 * @property string $login_name
 * @property string $refer_url
 * @property string $target_url
 * @property string $query_params
 * @property string $ua
 * @property string $ip
 * @property string $note
 * @property integer $status
 * @property string $created_time
 */
class AdminAccessLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_access_log';
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
            [['target_type', 'target_id', 'act_type', 'status'], 'integer'],
            [['created_time'], 'safe'],
            [['login_name'], 'string', 'max' => 50],
            [['refer_url', 'target_url', 'ua'], 'string', 'max' => 255],
            [['query_params', 'note'], 'string', 'max' => 1000],
            [['ip'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'target_type' => 'Target Type',
            'target_id' => 'Target ID',
            'act_type' => 'Act Type',
            'login_name' => 'Login Name',
            'refer_url' => 'Refer Url',
            'target_url' => 'Target Url',
            'query_params' => 'Query Params',
            'ua' => 'Ua',
            'ip' => 'Ip',
            'note' => 'Note',
            'status' => 'Status',
            'created_time' => 'Created Time',
        ];
    }
}
