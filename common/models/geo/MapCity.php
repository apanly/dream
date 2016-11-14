<?php

namespace common\models\geo;

use Yii;

/**
 * This is the model class for table "map_city".
 *
 * @property integer $id
 * @property integer $province_id
 * @property string $province_name
 * @property integer $city_id
 * @property string $city_name
 * @property integer $district_id
 * @property string $district_name
 * @property integer $region_id
 * @property string $updated_time
 * @property string $created_time
 */
class MapCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map_city';
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
            [['id'], 'required'],
            [['id', 'province_id', 'city_id', 'district_id', 'region_id'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['province_name', 'city_name', 'district_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province_id' => 'Province ID',
            'province_name' => 'Province Name',
            'city_id' => 'City ID',
            'city_name' => 'City Name',
            'district_id' => 'District ID',
            'district_name' => 'District Name',
            'region_id' => 'Region ID',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
