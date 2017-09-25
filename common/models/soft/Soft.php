<?php

namespace common\models\soft;

use Yii;

/**
 * This is the model class for table "soft".
 *
 * @property integer $id
 * @property string $sn
 * @property string $title
 * @property integer $type
 * @property string $content
 * @property string $tags
 * @property string $image_url
 * @property string $preview_url
 * @property string $down_url
 * @property string $origin_info_url
 * @property integer $need_buy
 * @property string $price
 * @property integer $free_number
 * @property integer $apply_number
 * @property integer $status
 * @property integer $comment_count
 * @property integer $view_count
 * @property string $updated_time
 * @property string $created_time
 */
class Soft extends \yii\db\ActiveRecord
{
	public function setUniqueSn( ){
		do{
			$sn = md5( "soft_".time() );
			$sn = mb_substr($sn,5,8);
		}while( Soft::findOne([ 'sn' => $sn ]) );

		$this->sn = $sn;
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'soft';
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
            [['type', 'need_buy', 'free_number', 'apply_number', 'status', 'comment_count', 'view_count'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['price'], 'number'],
            [['updated_time', 'created_time'], 'safe'],
            [['sn'], 'string', 'max' => 20],
            [['title', 'tags'], 'string', 'max' => 250],
            [['image_url', 'preview_url', 'down_url', 'origin_info_url'], 'string', 'max' => 256],
            [['sn'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sn' => 'Sn',
            'title' => 'Title',
            'type' => 'Type',
            'content' => 'Content',
            'tags' => 'Tags',
            'image_url' => 'Image Url',
            'preview_url' => 'Preview Url',
            'down_url' => 'Down Url',
            'origin_info_url' => 'Origin Info Url',
            'need_buy' => 'Need Buy',
            'price' => 'Price',
            'free_number' => 'Free Number',
            'apply_number' => 'Apply Number',
            'status' => 'Status',
            'comment_count' => 'Comment Count',
            'view_count' => 'View Count',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
