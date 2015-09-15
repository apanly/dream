<?php

namespace common\models\weixin;

use Yii;

/**
 * This is the model class for table "wx_history".
 *
 * @property integer $id
 * @property string $from_openid
 * @property string $to_openid
 * @property string $type
 * @property string $content
 * @property string $text
 * @property string $created_time
 */
class WxHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_history';
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
            [['text'], 'required'],
            [['text'], 'string'],
            [['created_time'], 'safe'],
            [['from_openid', 'to_openid'], 'string', 'max' => 64],
            [['type'], 'string', 'max' => 20],
            [['content'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_openid' => 'From Openid',
            'to_openid' => 'To Openid',
            'type' => 'Type',
            'content' => 'Content',
            'text' => 'Text',
            'created_time' => 'Created Time',
        ];
    }
}
