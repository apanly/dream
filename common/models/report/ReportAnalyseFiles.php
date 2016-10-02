<?php

namespace common\models\report;

use Yii;

/**
 * This is the model class for table "report_analyse_files".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $source
 * @property string $file_path
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class ReportAnalyseFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_analyse_files';
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
            [['type', 'source', 'status'], 'integer'],
            [['source'], 'required'],
            [['updated_time', 'created_time'], 'safe'],
            [['file_path'], 'string', 'max' => 100]
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
            'source' => 'Source',
            'file_path' => 'File Path',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
