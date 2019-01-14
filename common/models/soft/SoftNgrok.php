<?php

namespace common\models\soft;

use Yii;

/**
 * This is the model class for table "soft_ngrok".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $pay_order_id
 * @property string $prefix_domain
 * @property string $auth_token
 * @property string $start_time
 * @property string $end_time
 * @property string $updated_time
 * @property string $created_time
 */
class SoftNgrok extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'soft_ngrok';
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
            [['member_id', 'pay_order_id'], 'integer'],
            [['start_time', 'end_time'], 'required'],
            [['start_time', 'end_time', 'updated_time', 'created_time'], 'safe'],
            [['prefix_domain'], 'string', 'max' => 15],
            [['auth_token'], 'string', 'max' => 32],
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
            'pay_order_id' => 'Pay Order ID',
            'prefix_domain' => 'Prefix Domain',
            'auth_token' => 'Auth Token',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
