<?php

namespace console\modules\blog\controllers;

use common\models\posts\RichMedia;
use common\models\weixin\WxHistory;
use console\modules\blog\Blog;
use common\service\weixin\Wechat;
use Yii;

class Rich_mediaController extends Blog{
    private $cur_path = "/data/logs/cur/rich_media.log";

    /**
     * 有redis做队列就好了,这样就不用这样处理了
     * 木办法，现在的主机配置有点差
     */
    public function actionRun(){
        $date_now = date("Y-m-d H:i:s");
        $id = $this->getCurId( $this->cur_path );
        $rich_media_list = WxHistory::find()
            ->where(['type' => ["image","voice","video"] ])
            ->andWhere([">","id",$id])
            ->orderBy("id asc")
            ->limit(10)
            ->all();

        if( !$rich_media_list ){
            return $this->echoLog("{$date_now} no data");
        }

        foreach( $rich_media_list as $_rich_info ){
            $thumb_url = "";
            $src_url = "";
            $type = $_rich_info['type'];
            switch( $type ){
                case "image":
                    $src_url = $_rich_info["content"];
                    break;
                case "voice":
                case "video":
                    list($src_url,$thumb_url) = $this->getMediaInfo( $_rich_info["text"] );
                    break;
            }

            if( !$src_url ){
                continue;
            }

            $this->saveRichMedia($type,$src_url,$thumb_url);
            $this->setCurId($this->cur_path,$_rich_info['id']);
        }
    }

    /**
     * 上传下载多媒体文件
     * http://mp.weixin.qq.com/wiki/10/78b15308b053286e2a66b33f0f0f5fb6.html
     * 需要高级权限，逼良为娼呀！！
     * 使用伪登录解析源码获取了
     */
    private function getMediaInfo($xml){
        $data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return ["",""];
    }


    private function saveRichMedia($type,$src_url,$thumb_url = ""){
        if( !$src_url ){
            return true;
        }
        $hash_url = md5($src_url);
        $has_in = RichMedia::findOne(['hash_url' => $hash_url]);
        if( $has_in ){
            return true;
        }
        $date_now = date("Y-m-d H:i:s");

        $data = file_get_contents($src_url);
        if( !$data ){
            return false;
        }

        $upload_dir_pic1 = Yii::$app->params['upload']['pic1'];
        $file_type = "jpeg";
        switch($type){
            case "voice":
                $file_type = "mp3";
                break;
            case "video":
                $file_type = "mp4";
                break;
        }

        $folder_name = date("Ymd",strtotime($date_now));
        $upload_dir = $upload_dir_pic1.$folder_name;
        if( !file_exists($upload_dir) ){
            mkdir($upload_dir);
        }

        $file_name = "{$folder_name}/{$hash_url}.{$file_type}";

        file_put_contents($upload_dir_pic1.$file_name,$data);

        $exif_info = @exif_read_data($upload_dir_pic1.$file_name,0,true);

        $model_rich_media = new RichMedia();
        $model_rich_media->type = $type;
        $model_rich_media->src_url = "/{$file_name}";
        $model_rich_media->hash_url = $hash_url;
        $model_rich_media->thumb_url = $thumb_url;
        $model_rich_media->status = 0;
        $model_rich_media->exif = json_encode($exif_info);
        $model_rich_media->updated_time = $date_now;
        $model_rich_media->created_time = $date_now;
        $model_rich_media->save(0);
        return true;
    }

    private function test(){
        $option = [
            "account" => "1586538192@qq.com",
            "password" => "xxx"
        ];
        $wechat = new Wechat( $option );
    }
}