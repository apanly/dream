<?php

namespace common\models\soft;

use Yii;

/**
 * This is the model class for table "soft_queue".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $pay_id
 * @property string $data
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class SoftQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'soft_queue';
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
            [['member_id', 'pay_id', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['data'], 'string', 'max' => 500],
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
            'pay_id' => 'Pay ID',
            'data' => 'Data',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
