<?php

namespace common\models\stat;

use Yii;

/**
 * This is the model class for table "stat_daily_browser".
 *
 * @property integer $id
 * @property integer $date
 * @property string $client_browser
 * @property integer $total_number
 * @property string $updated_time
 * @property string $created_time
 */
class StatDailyBrowser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_daily_browser';
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
            [['client_browser'], 'string', 'max' => 50],
            [['date', 'client_browser'], 'unique', 'targetAttribute' => ['date', 'client_browser'], 'message' => 'The combination of Date and Client Browser has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'client_browser' => 'Client Browser',
            'total_number' => 'Total Number',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
