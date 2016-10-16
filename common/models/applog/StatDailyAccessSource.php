<?php

namespace common\models\applog;

use Yii;

/**
 * This is the model class for table "stat_daily_access_source".
 *
 * @property integer $id
 * @property string $source
 * @property integer $date
 * @property integer $total_number
 * @property string $created_time
 */
class StatDailyAccessSource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_daily_access_source';
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
            [['source'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
            'date' => 'Date',
            'total_number' => 'Total Number',
            'created_time' => 'Created Time',
        ];
    }
}
