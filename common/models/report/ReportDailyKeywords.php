<?php

namespace common\models\report;

use Yii;

/**
 * This is the model class for table "report_daily_keywords".
 *
 * @property integer $id
 * @property integer $type
 * @property string $date
 * @property string $word
 * @property string $uniq_key
 * @property integer $click_number
 * @property integer $display_number
 * @property string $params
 * @property string $updated_time
 * @property string $created_time
 */
class ReportDailyKeywords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_daily_keywords';
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
            [['type', 'click_number', 'display_number'], 'integer'],
            [['date', 'updated_time', 'created_time'], 'safe'],
            [['word'], 'string', 'max' => 100],
            [['uniq_key'], 'string', 'max' => 32],
            [['params'], 'string', 'max' => 2000],
            [['uniq_key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'date' => 'Date',
            'word' => 'Word',
            'uniq_key' => 'Uniq Key',
            'click_number' => 'Click Number',
            'display_number' => 'Display Number',
            'params' => 'Params',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
