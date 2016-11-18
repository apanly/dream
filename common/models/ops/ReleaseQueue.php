<?php

namespace common\models\ops;

use Yii;

/**
 * This is the model class for table "release_queue".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $repo
 * @property integer $status
 * @property string $content
 * @property string $note
 * @property string $updated_time
 * @property string $created_time
 */
class ReleaseQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'release_queue';
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
            [['uid', 'content'], 'required'],
            [['uid', 'status'], 'integer'],
            [['content'], 'string'],
            [['updated_time', 'created_time'], 'safe'],
            [['repo'], 'string', 'max' => 20],
            [['note'], 'string', 'max' => 255],
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
            'repo' => 'Repo',
            'status' => 'Status',
            'content' => 'Content',
            'note' => 'Note',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
