<?php

namespace common\models\weixin;

use Yii;

/**
 * This is the model class for table "wx_wall_history".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $type
 * @property string $content
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class WxWallHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_wall_history';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dream_wechat');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'type', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'type' => 'Type',
            'content' => 'Content',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
