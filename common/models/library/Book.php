<?php

namespace common\models\library;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $isbn
 * @property string $bartype
 * @property string $name
 * @property string $subtitle
 * @property string $creator
 * @property string $binding
 * @property string $pages
 * @property string $publish_date
 * @property string $publishing_house
 * @property string $tags
 * @property string $summary
 * @property string $image_url
 * @property string $origin_image_url
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
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
            [['name', 'binding', 'tags', 'summary'], 'required'],
            [['name', 'summary'], 'string'],
            [['publish_date', 'updated_time', 'created_time'], 'safe'],
            [['status'], 'integer'],
            [['isbn'], 'string', 'max' => 20],
            [['bartype', 'pages'], 'string', 'max' => 10],
            [['subtitle', 'creator', 'publishing_house', 'image_url', 'origin_image_url'], 'string', 'max' => 255],
            [['binding'], 'string', 'max' => 50],
            [['tags'], 'string', 'max' => 500],
            [['isbn'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'isbn' => 'Isbn',
            'bartype' => 'Bartype',
            'name' => 'Name',
            'subtitle' => 'Subtitle',
            'creator' => 'Creator',
            'binding' => 'Binding',
            'pages' => 'Pages',
            'publish_date' => 'Publish Date',
            'publishing_house' => 'Publishing House',
            'tags' => 'Tags',
            'summary' => 'Summary',
            'image_url' => 'Image Url',
            'origin_image_url' => 'Origin Image Url',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
