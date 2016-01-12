<?php

namespace common\models\posts;

use Yii;

/**
 * This is the model class for table "posts_recommend_queue".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class PostsRecommendQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts_recommend_queue';
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
            [['blog_id', 'status'], 'integer'],
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
            'blog_id' => 'Blog ID',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
