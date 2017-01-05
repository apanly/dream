<?php

namespace common\models\awephp;

use Yii;

/**
 * This is the model class for table "awe_menu".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property integer $doc_id
 * @property integer $weight
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class AweMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'awe_menu';
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
            [['parent_id', 'doc_id', 'weight', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'doc_id' => 'Doc ID',
            'weight' => 'Weight',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
