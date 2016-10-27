<?php

namespace common\models\stat;

use Yii;

/**
 * This is the model class for table "stat_daily_device".
 *
 * @property integer $id
 * @property string $client_device
 * @property integer $date
 * @property integer $total_number
 * @property string $updated_time
 * @property string $created_time
 */
class StatDailyDevice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_daily_device';
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
            [['updated_time', 'created_time'], 'safe'],
            [['client_device'], 'string', 'max' => 50],
            [['date', 'client_device'], 'unique', 'targetAttribute' => ['date', 'client_device'], 'message' => 'The combination of Client Device and Date has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_device' => 'Client Device',
            'date' => 'Date',
            'total_number' => 'Total Number',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
