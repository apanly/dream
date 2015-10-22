<?php

namespace common\models\health;

use Yii;

/**
 * This is the model class for table "health_day".
 *
 * @property integer $id
 * @property integer $date
 * @property integer $quantity
 * @property string $updated_time
 * @property string $created_time
 */
class HealthDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'health_day';
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
            [['updated_time', 'created_time'], 'safe']
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
            'quantity' => 'Quantity',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
