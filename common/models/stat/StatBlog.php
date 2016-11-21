<?php

namespace common\models\stat;

use Yii;

/**
 * This is the model class for table "stat_blog".
 *
 * @property integer $id
 * @property string $date
 * @property integer $today_post_number
 * @property integer $total_post_number
 * @property integer $total_unpost_number
 * @property integer $total_original_number
 * @property integer $total_hot_number
 * @property string $updated_time
 * @property string $created_time
 */
class StatBlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_blog';
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
            [['today_post_number', 'total_post_number', 'total_unpost_number', 'total_original_number', 'total_hot_number'], 'integer'],
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
            'today_post_number' => 'Today Post Number',
            'total_post_number' => 'Total Post Number',
            'total_unpost_number' => 'Total Unpost Number',
            'total_original_number' => 'Total Original Number',
            'total_hot_number' => 'Total Hot Number',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
