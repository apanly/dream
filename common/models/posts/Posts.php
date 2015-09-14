<?php

namespace common\models\posts;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $title
 * @property integer $type
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
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
            [['uid', 'type', 'status'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['updated_time', 'created_time'], 'safe'],
            [['title', 'tags'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'title' => 'Title',
            'type' => 'Type',
            'content' => 'Content',
            'tags' => 'Tags',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
