<?php

namespace common\models\metaweblog;

use Yii;

/**
 * This is the model class for table "blog_sync_mapping".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property string $cto51_id
 * @property string $csdn_id
 * @property string $sina_id
 * @property string $netease_id
 * @property string $oschina_id
 * @property string $cnblogs_id
 * @property string $updated_time
 * @property string $created_time
 */
class BlogSyncMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_sync_mapping';
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
            [['blog_id'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['cto51_id', 'csdn_id', 'sina_id', 'netease_id', 'oschina_id', 'cnblogs_id'], 'string', 'max' => 64]
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
            'cto51_id' => 'Cto51 ID',
            'csdn_id' => 'Csdn ID',
            'sina_id' => 'Sina ID',
            'netease_id' => 'Netease ID',
            'oschina_id' => 'Oschina ID',
            'cnblogs_id' => 'Cnblogs ID',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
