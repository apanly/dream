<?php

namespace common\models\applog;

use Yii;

/**
 * This is the model class for table "stat_daily_uuid".
 *
 * @property integer $id
 * @property string $uuid
 * @property integer $date
 * @property integer $total_number
 * @property string $created_time
 */
class StatDailyUuid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_daily_uuid';
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
            [['date', 'total_number'], 'integer'],
            [['created_time'], 'safe'],
            [['uuid'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'date' => 'Date',
            'total_number' => 'Total Number',
            'created_time' => 'Created Time',
        ];
    }
}
