<?php

namespace common\models\games;

use Yii;

/**
 * This is the model class for table "music".
 *
 * @property integer $id
 * @property string $song_id
 * @property integer $type
 * @property string $cover_image
 * @property string $lrc
 * @property string $song_url
 * @property string $song_title
 * @property string $song_author
 * @property string $text
 * @property string $format_data
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class Music extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'music';
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
            [['type', 'status'], 'integer'],
            [['lrc', 'text', 'format_data'], 'required'],
            [['lrc', 'text', 'format_data'], 'string'],
            [['updated_time', 'created_time'], 'safe'],
            [['song_id'], 'string', 'max' => 64],
            [['cover_image', 'song_url'], 'string', 'max' => 500],
            [['song_title'], 'string', 'max' => 100],
            [['song_author'], 'string', 'max' => 30],
            [['song_id', 'type'], 'unique', 'targetAttribute' => ['song_id', 'type'], 'message' => 'The combination of Song ID and Type has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'song_id' => 'Song ID',
            'type' => 'Type',
            'cover_image' => 'Cover Image',
            'lrc' => 'Lrc',
            'song_url' => 'Song Url',
            'song_title' => 'Song Title',
            'song_author' => 'Song Author',
            'text' => 'Text',
            'format_data' => 'Format Data',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
