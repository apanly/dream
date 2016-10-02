<?php

namespace common\models\report;

use Yii;

/**
 * This is the model class for table "report_auth_history".
 *
 * @property integer $id
 * @property integer $type
 * @property string $params
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class ReportAuthHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_auth_history';
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
            [['type', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['params'], 'string', 'max' => 3000]
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
            'params' => 'Params',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
