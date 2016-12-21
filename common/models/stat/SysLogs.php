<?php

namespace common\models\stat;

use Yii;

/**
 * This is the model class for table "sys_logs".
 *
 * @property integer $id
 * @property integer $type
 * @property string $file_key
 * @property string $note
 * @property string $updated_time
 * @property string $created_time
 */
class SysLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_logs';
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
            [['type'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['file_key'], 'string', 'max' => 100],
            [['note'], 'string', 'max' => 500],
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
            'file_key' => 'File Key',
            'note' => 'Note',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
