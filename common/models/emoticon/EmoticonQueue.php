<?php

namespace common\models\emoticon;

use Yii;

/**
 * This is the model class for table "emoticon_queue".
 *
 * @property integer $id
 * @property integer $source
 * @property integer $type
 * @property string $title
 * @property string $url
 * @property string $uniq_key
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class EmoticonQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emoticon_queue';
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
            [['source', 'type', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 500],
            [['uniq_key'], 'string', 'max' => 32],
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
            'source' => 'Source',
            'type' => 'Type',
            'title' => 'Title',
            'url' => 'Url',
            'uniq_key' => 'Uniq Key',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
