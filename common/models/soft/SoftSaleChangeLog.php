<?php

namespace common\models\soft;

use Yii;

/**
 * This is the model class for table "soft_sale_change_log".
 *
 * @property integer $id
 * @property integer $soft_id
 * @property integer $quantity
 * @property string $total_price
 * @property string $discount_price
 * @property string $pay_price
 * @property integer $member_id
 * @property string $created_time
 */
class SoftSaleChangeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'soft_sale_change_log';
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
            [['soft_id', 'quantity', 'member_id'], 'integer'],
            [['price' ], 'number'],
            [['created_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'soft_id' => 'Soft ID',
            'quantity' => 'Quantity',
            'price' => 'price',
            'member_id' => 'Member ID',
            'created_time' => 'Created Time',
        ];
    }
}
