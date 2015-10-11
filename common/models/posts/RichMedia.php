<?php

namespace common\models\posts;

use Yii;

/**
 * This is the model class for table "rich_media".
 *
 * @property integer $id
 * @property string $title
 * @property string $type
 * @property string $src_url
 * @property string $hash_url
 * @property string $thumb_url
 * @property string $gps
 * @property string $tiff
 * @property integer $status
 * @property string $exif
 * @property string $description
 * @property string $updated_time
 * @property string $created_time
 */
class RichMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rich_media';
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
            [['gps', 'tiff', 'exif'], 'required'],
            [['gps', 'tiff', 'exif'], 'string'],
            [['status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['title'], 'string', 'max' => 200],
            [['type'], 'string', 'max' => 10],
            [['src_url', 'thumb_url'], 'string', 'max' => 500],
            [['hash_url'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 1000]
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
            'type' => 'Type',
            'src_url' => 'Src Url',
            'hash_url' => 'Hash Url',
            'thumb_url' => 'Thumb Url',
            'gps' => 'Gps',
            'tiff' => 'Tiff',
            'status' => 'Status',
            'exif' => 'Exif',
            'description' => 'Description',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
