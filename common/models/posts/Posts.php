<?php

namespace common\models\posts;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $sn
 * @property integer $uid
 * @property string $title
 * @property integer $type
 * @property integer $original
 * @property integer $hot
 * @property string $content
 * @property string $tags
 * @property string $image_url
 * @property integer $status
 * @property integer $comment_count
 * @property integer $view_count
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
            [['uid', 'type', 'original', 'hot', 'status', 'comment_count', 'view_count'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['updated_time', 'created_time'], 'safe'],
            [['sn'], 'string', 'max' => 20],
            [['title', 'tags'], 'string', 'max' => 250],
            [['image_url'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sn' => 'Sn',
            'uid' => 'Uid',
            'title' => 'Title',
            'type' => 'Type',
            'original' => 'Original',
            'hot' => 'Hot',
            'content' => 'Content',
            'tags' => 'Tags',
            'image_url' => 'Image Url',
            'status' => 'Status',
            'comment_count' => 'Comment Count',
            'view_count' => 'View Count',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
