<?php

namespace common\models\face;

use Yii;

/**
 * This is the model class for table "face_queue".
 *
 * @property integer $id
 * @property integer $source
 * @property string $url
 * @property string $uniq_key
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class FaceQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'face_queue';
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
            [['source', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['url'], 'string', 'max' => 500],
            [['uniq_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
            'url' => 'Url',
            'uniq_key' => 'Uniq Key',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
