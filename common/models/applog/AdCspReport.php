<?php

namespace common\models\applog;

use Yii;

/**
 * This is the model class for table "ad_csp_report".
 *
 * @property integer $id
 * @property string $url
 * @property string $report_content
 * @property string $ua
 * @property string $ip
 * @property string $updated_time
 * @property string $created_time
 */
class AdCspReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_csp_report';
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
            [['report_content'], 'required'],
            [['report_content'], 'string'],
            [['updated_time', 'created_time'], 'safe'],
            [['url', 'ua'], 'string', 'max' => 500],
            [['ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'report_content' => 'Report Content',
            'ua' => 'Ua',
            'ip' => 'Ip',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
