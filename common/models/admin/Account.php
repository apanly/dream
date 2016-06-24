<?php

namespace common\models\admin;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property integer $id
 * @property string $title
 * @property string $account
 * @property string $pwd
 * @property string $description
 * @property string $updated_time
 * @property string $created_time
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
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
            [['updated_time', 'created_time'], 'safe'],
            [['title', 'account'], 'string', 'max' => 100],
            [['pwd'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'account' => 'Account',
            'pwd' => 'Pwd',
            'description' => 'Description',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
