<?php

namespace common\models\search;

use Yii;

/**
 * This is the model class for table "index_search".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $book_id
 * @property integer $post_id
 * @property string $search_key
 * @property string $image
 * @property string $updated_time
 * @property string $created_time
 */
class IndexSearch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'index_search';
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
            [['book_id', 'post_id'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 1000],
            [['search_key'], 'string', 'max' => 1024],
            [['image'], 'string', 'max' => 200]
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
            'description' => 'Description',
            'book_id' => 'Book ID',
            'post_id' => 'Post ID',
            'search_key' => 'Search Key',
            'image' => 'Image',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
