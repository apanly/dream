<?php

namespace common\models\data;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 * @property integer $province_id
 * @property string $province
 * @property string $province_alias_name
 * @property integer $city_id
 * @property string $city
 * @property integer $area_id
 * @property string $area
 * @property integer $region_id
 * @property string $region_name
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
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
            [['id', 'name', 'province_id', 'province', 'city_id', 'city', 'area_id', 'area'], 'required'],
            [['id', 'province_id', 'city_id', 'area_id', 'region_id'], 'integer'],
            [['name', 'province', 'province_alias_name', 'city', 'area', 'region_name'], 'string', 'max' => 20],
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
            'province_id' => 'Province ID',
            'province' => 'Province',
            'province_alias_name' => 'Province Alias Name',
            'city_id' => 'City ID',
            'city' => 'City',
            'area_id' => 'Area ID',
            'area' => 'Area',
            'region_id' => 'Region ID',
            'region_name' => 'Region Name',
        ];
    }
}
