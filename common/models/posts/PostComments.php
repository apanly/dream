<?php

namespace common\models\posts;

use Yii;

/**
 * This is the model class for table "post_comments".
 *
 * @property integer $id
 * @property integer $log_id
 * @property integer $post_id
 * @property integer $ds_post_id
 * @property integer $ds_thread_id
 * @property string $author_name
 * @property string $author_email
 * @property string $author_url
 * @property string $ip
 * @property string $ds_created_time
 * @property string $content
 * @property integer $parent_id
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class PostComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_comments';
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
            [['log_id', 'post_id', 'ds_post_id', 'ds_thread_id', 'parent_id', 'status'], 'integer'],
            [['ds_created_time', 'updated_time', 'created_time'], 'safe'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['author_name'], 'string', 'max' => 40],
            [['author_email'], 'string', 'max' => 50],
            [['author_url'], 'string', 'max' => 512],
            [['ip'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'log_id' => 'Log ID',
            'post_id' => 'Post ID',
            'ds_post_id' => 'Ds Post ID',
            'ds_thread_id' => 'Ds Thread ID',
            'author_name' => 'Author Name',
            'author_email' => 'Author Email',
            'author_url' => 'Author Url',
            'ip' => 'Ip',
            'ds_created_time' => 'Ds Created Time',
            'content' => 'Content',
            'parent_id' => 'Parent ID',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
