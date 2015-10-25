<?php

namespace common\models\health;

use Yii;

/**
 * This is the model class for table "health_log".
 *
 * @property integer $id
 * @property integer $date
 * @property string $hash_key
 * @property integer $quantity
 * @property string $time_from
 * @property string $time_to
 * @property double $lat
 * @property double $lng
 * @property string $created_time
 */
class HealthLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'health_log';
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
            [['date', 'quantity'], 'integer'],
            [['quantity', 'lat'], 'required'],
            [['time_from', 'time_to', 'created_time'], 'safe'],
            [['lat', 'lng'], 'number'],
            [['hash_key'], 'string', 'max' => 32]
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
            'hash_key' => 'Hash Key',
            'quantity' => 'Quantity',
            'time_from' => 'Time From',
            'time_to' => 'Time To',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'created_time' => 'Created Time',
        ];
    }
}
