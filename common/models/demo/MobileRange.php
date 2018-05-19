<?php

namespace common\models\demo;

use Yii;

/**
 * This is the model class for table "mobile_range".
 *
 * @property integer $id
 * @property integer $prefix
 * @property string $provice
 * @property string $city
 * @property string $operator
 * @property string $zone
 * @property string $code
 */
class MobileRange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mobile_range';
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
            [['prefix'], 'integer'],
            [['provice', 'city', 'operator'], 'string', 'max' => 50],
            [['zone'], 'string', 'max' => 10],
            [['code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prefix' => 'Prefix',
            'provice' => 'Provice',
            'city' => 'City',
            'operator' => 'Operator',
            'zone' => 'Zone',
            'code' => 'Code',
        ];
    }
}
