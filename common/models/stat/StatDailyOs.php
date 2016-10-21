<?php

namespace common\models\stat;

use Yii;

/**
 * This is the model class for table "stat_daily_os".
 *
 * @property integer $id
 * @property string $client_os
 * @property integer $date
 * @property integer $total_number
 * @property string $updated_time
 * @property string $created_time
 */
class StatDailyOs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_daily_os';
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
            [['client_os'], 'string', 'max' => 50],
            [['date', 'client_os'], 'unique', 'targetAttribute' => ['date', 'client_os'], 'message' => 'The combination of Client Os and Date has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_os' => 'Client Os',
            'date' => 'Date',
            'total_number' => 'Total Number',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
