<?php

namespace common\models\search;

use Yii;

/**
 * This is the model class for table "spider_queue".
 *
 * @property integer $id
 * @property string $url
 * @property string $hash_url
 * @property integer $status
 * @property integer $post_id
 * @property string $updated_time
 * @property string $created_time
 */
class SpiderQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'spider_queue';
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
            [['status', 'post_id'], 'integer'],
            [['post_id'], 'required'],
            [['updated_time', 'created_time'], 'safe'],
            [['url'], 'string', 'max' => 500],
            [['hash_url'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'hash_url' => 'Hash Url',
            'status' => 'Status',
            'post_id' => 'Post ID',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
