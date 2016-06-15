<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_message_history".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $type
 * @property string $content
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class UserMessageHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_message_history';
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
            [['uid', 'type', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'type' => 'Type',
            'content' => 'Content',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
