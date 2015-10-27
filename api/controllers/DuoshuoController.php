<?php

namespace api\controllers;

use common\components\HttpLib;
use common\components\UtilHelper;
use common\models\posts\PostComments;
use Yii;
use api\controllers\common\AuthController;

class DuoshuoController extends AuthController
{
    private $secret = "ef6e0180e1a4c81b746d3e912248336d";
    private $short_name = 'guowei';

    private $cur_path = "/data/logs/cur/duoshuo_comments.log";


    public function actionCallback(){
        $request = Yii::$app->request;
        if( !$request->isPost ){
            return $this->renderJSON();
        }

        if( !$this->check_signature($_POST) ){
            return $this->renderJSON([],"验证失败!!",-1);
        }

        $list = $this->getCommentsFromDuoshuo();
        $this->saveComments($list);
        return $this->renderJSON();
    }


    private function getCommentsFromDuoshuo(){
        $data = [];

        $url = "http://api.duoshuo.com/log/list.json";
        $params = [
            'short_name' => $this->short_name,
            'secret' => $this->secret,
            'since_id' => 0,
            'limit' => 200,
            'order' => 'asc'
        ];
        $url .= "?".http_build_query($params);
        $target = new HttpLib();
        $data_res = $target->get($url);
        if( $data_res['response']['code'] != 200 ){
            return $data;
        }
        $commemt_list = @json_decode($data_res['body'],true);
        if( $commemt_list && $commemt_list['code'] == 0 ){
            $data = $commemt_list["response"];
        }
        return $data;
    }

    private function saveComments($list){
        if( !$list ){
            return true;
        }

        foreach( $list as $_item ){
            $tmp_action = $_item['action'];
            $this->setCurId($this->cur_path,$_item['log_id']);

            $date_now = date("Y-m-d H:i:s");

            if( $tmp_action == "create" ){//保存
                $tmp_meta = $_item['meta'];

                $post_comment_info = PostComments::findOne([
                    "ds_post_id" => $tmp_meta["post_id"]
                ]);

                if( $post_comment_info ){
                    continue;
                }

                $model_post_comments =    new PostComments();
                $model_post_comments->log_id = $_item['log_id'];
                $model_post_comments->post_id = $tmp_meta['thread_key'];
                $model_post_comments->ds_post_id = $tmp_meta["post_id"];
                $model_post_comments->ds_thread_id = $tmp_meta["thread_id"];
                $model_post_comments->author_name = $tmp_meta["author_name"]?$tmp_meta["author_name"]:'';
                $model_post_comments->author_email = $tmp_meta['author_email']?$tmp_meta['author_email']:'';
                $model_post_comments->author_url = $tmp_meta['author_url']?$tmp_meta['author_url']:'';
                $model_post_comments->ip = $tmp_meta['ip']?$tmp_meta['ip']:'';
                $model_post_comments->ds_created_time = date("Y-m-d H:i:s",strtotime($tmp_meta['created_at']));
                $model_post_comments->content = $tmp_meta['message'];
                $model_post_comments->parent_id = $tmp_meta['parent_id']?$tmp_meta['parent_id']:0;
                $model_post_comments->status = 1;
                $model_post_comments->updated_time = $date_now;
                $model_post_comments->created_time = $date_now;
                $model_post_comments->save(0);
            }else{
                $post_ids = $_item['meta'];
                if( !$post_ids ){
                    continue;
                }
                foreach( $post_ids as $_post_id ){
                    $post_comment_info = PostComments::findOne([
                        "ds_post_id" => $_post_id
                    ]);
                    if( !$post_comment_info ){
                        continue;
                    }
                    $post_comment_info->status = ($tmp_action == "approve")?1:0;
                    $post_comment_info->updated_time = $date_now;
                    $post_comment_info->update(0);
                }
            }

        }

        return true;
    }

    private function check_signature($input){

        $signature = $input['signature'];
        unset($input['signature']);

        ksort($input);
        $baseString = http_build_query($input, null, '&');
        $expectSignature = base64_encode($this->hmacsha1($baseString, $this->secret));
        if ($signature !== $expectSignature) {
            return false;
        }
        return true;
    }

    private function hmacsha1($data, $key) {
        if (function_exists('hash_hmac'))
            return hash_hmac('sha1', $data, $key, true);

        $blocksize=64;
        if (strlen($key)>$blocksize)
            $key=pack('H*', sha1($key));
        $key=str_pad($key,$blocksize,chr(0x00));
        $ipad=str_repeat(chr(0x36),$blocksize);
        $opad=str_repeat(chr(0x5c),$blocksize);
        $hmac = pack(
            'H*',sha1(
                ($key^$opad).pack(
                    'H*',sha1(
                        ($key^$ipad).$data
                    )
                )
            )
        );
        return $hmac;
    }

    public function getCurId($path){
        if( !file_exists( $path) ){
            return 0;
        }
        return file_get_contents($path);
    }

    public function setCurId($path,$id){
        file_put_contents($path,$id);
    }


}