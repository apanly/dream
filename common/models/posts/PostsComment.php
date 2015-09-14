<?php

namespace common\models\posts;

use Yii;

/**
 * This is the model class for table "posts_comment".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $content
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class PostsComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts_comment';
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
            [['post_id', 'status'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['updated_time', 'created_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'content' => 'Content',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
