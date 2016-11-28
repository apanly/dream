<?php

namespace common\models\stat;

use Yii;

/**
 * This is the model class for table "stat_access".
 *
 * @property integer $id
 * @property string $date
 * @property integer $total_number
 * @property integer $total_ip_number
 * @property integer $total_uv_number
 * @property integer $total_new_user_number
 * @property integer $total_returned_user_number
 * @property string $updated_time
 * @property string $created_time
 */
class StatAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_access';
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
            [['date', 'updated_time', 'created_time'], 'safe'],
            [['total_number', 'total_ip_number', 'total_uv_number', 'total_new_user_number', 'total_returned_user_number'], 'integer'],
            [['date'], 'unique'],
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
            'total_number' => 'Total Number',
            'total_ip_number' => 'Total Ip Number',
            'total_uv_number' => 'Total Uv Number',
            'total_new_user_number' => 'Total New User Number',
            'total_returned_user_number' => 'Total Returned User Number',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
