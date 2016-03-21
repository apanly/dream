<?php

namespace common\models\mate;

use Yii;

/**
 * This is the model class for table "mate_list".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $mobile
 * @property integer $person_num
 * @property string $created_time
 */
class MateList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mate_list';
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
            [['person_num'], 'integer'],
            [['created_time'], 'safe'],
            [['nickname', 'mobile'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'mobile' => 'Mobile',
            'person_num' => 'Person Num',
            'created_time' => 'Created Time',
        ];
    }
}
