<?php

namespace common\models\pay;

use Yii;

/**
 * This is the model class for table "pay_order_item".
 *
 * @property integer $id
 * @property integer $pay_order_id
 * @property integer $member_id
 * @property integer $quantity
 * @property string $price
 * @property string $discount
 * @property integer $target_type
 * @property integer $target_id
 * @property string $note
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class PayOrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_order_item';
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
            [['pay_order_id', 'member_id', 'quantity', 'target_type', 'target_id', 'status'], 'integer'],
            [['price', 'discount'], 'number'],
            [['updated_time', 'created_time'], 'safe'],
            [['note'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_order_id' => 'Pay Order ID',
            'member_id' => 'Member ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'discount' => 'Discount',
            'target_type' => 'Target Type',
            'target_id' => 'Target ID',
            'note' => 'Note',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
