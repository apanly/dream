<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property string $hash_key
 * @property string $filepath
 * @property string $filename
 * @property string $file_url
 * @property integer $target_id
 * @property string $created_time
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
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
            [['target_id'], 'required'],
            [['target_id'], 'integer'],
            [['created_time'], 'safe'],
            [['hash_key'], 'string', 'max' => 32],
            [['filepath', 'filename'], 'string', 'max' => 50],
            [['file_url'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash_key' => 'Hash Key',
            'filepath' => 'Filepath',
            'filename' => 'Filename',
            'file_url' => 'File Url',
            'target_id' => 'Target ID',
            'created_time' => 'Created Time',
        ];
    }
}
