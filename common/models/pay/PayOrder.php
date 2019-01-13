<?php

namespace common\models\pay;

use Yii;

/**
 * This is the model class for table "pay_order".
 *
 * @property integer $id
 * @property string $order_sn
 * @property integer $member_id
 * @property integer $target_type
 * @property integer $pay_type
 * @property integer $pay_source
 * @property string $total_price
 * @property string $discount
 * @property string $pay_price
 * @property string $pay_sn
 * @property string $note
 * @property integer $status
 * @property integer $queue_status
 * @property string $pay_time
 * @property string $updated_time
 * @property string $created_time
 */
class PayOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_order';
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
            [['member_id', 'target_type', 'pay_type', 'pay_source', 'status', 'queue_status'], 'integer'],
            [['total_price', 'discount', 'pay_price'], 'number'],
            [['pay_time', 'updated_time', 'created_time'], 'safe'],
            [['order_sn'], 'string', 'max' => 40],
            [['pay_sn'], 'string', 'max' => 128],
            [['note'], 'string', 'max' => 500],
            [['order_sn'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_sn' => 'Order Sn',
            'member_id' => 'Member ID',
            'target_type' => 'Target Type',
            'pay_type' => 'Pay Type',
            'pay_source' => 'Pay Source',
            'total_price' => 'Total Price',
            'discount' => 'Discount',
            'pay_price' => 'Pay Price',
            'pay_sn' => 'Pay Sn',
            'note' => 'Note',
            'status' => 'Status',
            'queue_status' => 'Queue Status',
            'pay_time' => 'Pay Time',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
