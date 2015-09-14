<?php

namespace common\models\posts;

use Yii;

/**
 * This is the model class for table "posts_tags".
 *
 * @property integer $id
 * @property integer $posts_id
 * @property string $tag
 */
class PostsTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts_tags';
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
            [['posts_id'], 'integer'],
            [['tag'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'posts_id' => 'Posts ID',
            'tag' => 'Tag',
        ];
    }
}
