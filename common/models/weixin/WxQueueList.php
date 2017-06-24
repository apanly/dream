<?php

namespace common\models\weixin;

use Yii;

/**
 * This is the model class for table "wx_queue_list".
 *
 * @property integer $id
 * @property string $queue_name
 * @property string $data
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class WxQueueList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_queue_list';
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
            [['status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['queue_name'], 'string', 'max' => 30],
            [['data'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'queue_name' => 'Queue Name',
            'data' => 'Data',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
