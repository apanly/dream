<?php

namespace common\models\games;

use Yii;

/**
 * This is the model class for table "doubanmz".
 *
 * @property integer $id
 * @property string $hash_key
 * @property string $title
 * @property string $image_url
 * @property string $src_url
 * @property integer $status
 * @property string $created_time
 */
class Doubanmz extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doubanmz';
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
            [['status'], 'integer'],
            [['created_time'], 'safe'],
            [['hash_key'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 50],
            [['image_url', 'src_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash_key' => 'Hash Key',
            'title' => 'Title',
            'image_url' => 'Image Url',
            'src_url' => 'Src Url',
            'status' => 'Status',
            'created_time' => 'Created Time',
        ];
    }
}
