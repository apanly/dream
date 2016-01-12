<?php

namespace common\models\posts;

use Yii;

/**
 * This is the model class for table "posts_recommend".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property integer $relation_blog_id
 * @property double $title_rate
 * @property double $content_rate
 * @property double $tags_rate
 * @property integer $score
 * @property string $updated_time
 * @property string $created_time
 */
class PostsRecommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts_recommend';
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
            [['blog_id', 'relation_blog_id', 'score'], 'integer'],
            [['title_rate', 'content_rate', 'tags_rate'], 'number'],
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
            'relation_blog_id' => 'Relation Blog ID',
            'title_rate' => 'Title Rate',
            'content_rate' => 'Content Rate',
            'tags_rate' => 'Tags Rate',
            'score' => 'Score',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
