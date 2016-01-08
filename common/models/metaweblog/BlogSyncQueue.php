<?php

namespace common\models\metaweblog;

use Yii;

/**
 * This is the model class for table "blog_sync_queue".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property string $type
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class BlogSyncQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_sync_queue';
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
            [['blog_id'], 'required'],
            [['blog_id', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['type'], 'string', 'max' => 10]
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
            'type' => 'Type',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
