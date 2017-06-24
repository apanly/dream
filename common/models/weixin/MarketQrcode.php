<?php

namespace common\models\weixin;

use Yii;

/**
 * This is the model class for table "market_qrcode".
 *
 * @property integer $id
 * @property string $name
 * @property string $qrcode
 * @property string $extra
 * @property string $expired_time
 * @property integer $total_scan_count
 * @property integer $total_reg_count
 * @property string $updated_time
 * @property string $created_time
 */
class MarketQrcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'market_qrcode';
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
            [['expired_time', 'updated_time', 'created_time'], 'safe'],
            [['total_scan_count', 'total_reg_count'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['qrcode'], 'string', 'max' => 62],
            [['extra'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'qrcode' => 'Qrcode',
            'extra' => 'Extra',
            'expired_time' => 'Expired Time',
            'total_scan_count' => 'Total Scan Count',
            'total_reg_count' => 'Total Reg Count',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
