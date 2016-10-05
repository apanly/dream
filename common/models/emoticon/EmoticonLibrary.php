<?php

namespace common\models\emoticon;

use Yii;

/**
 * This is the model class for table "emoticon_library".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property integer $cdn_source
 * @property string $cdn_rule
 * @property integer $group_id
 * @property string $group_name
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class EmoticonLibrary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emoticon_library';
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
            [['cdn_source', 'group_id', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['url', 'cdn_rule'], 'string', 'max' => 500],
            [['group_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'cdn_source' => 'Cdn Source',
            'cdn_rule' => 'Cdn Rule',
            'group_id' => 'Group ID',
            'group_name' => 'Group Name',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
