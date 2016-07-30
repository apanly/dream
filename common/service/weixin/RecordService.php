<?php
namespace common\service\weixin;


use common\models\user\User;
use common\models\user\UserMessageHistory;
use common\models\user\UserOpenidUnionid;
use common\models\weixin\WxHistory;
use common\service\SpiderService;

class RecordService {

    public static function add($xml,$source = "" ){

        $data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $type = trim($data->MsgType);
        $from_openid = $data->FromUserName;
        $to_openid = $data->ToUserName;
        $date_now = date("Y-m-d H:i:s");

        switch($type){
            case "location":
                $content = trim($data->Label);
                break;
            case "voice":
                $content = trim($data->Recognition);
                break;
            case "image":
                $content = trim($data->PicUrl);
                break;
            case "link":
                $content = trim($data->Title);
                break;
            case "shortvideo":
                $content = trim($data->ThumbMediaId);
                break;
            case "event":
                $content = trim($data->Event);
                break;
            default:
                $content = trim($data->Content);
                break;
        }

        $model_wx_history = new WxHistory();
        $model_wx_history->from_openid = $from_openid;
        $model_wx_history->to_openid = $to_openid;
        $model_wx_history->type = $type;
        $model_wx_history->content = $content;
        $model_wx_history->text = $xml;
        $model_wx_history->source = $source;
        $model_wx_history->created_time = $date_now;
        $model_wx_history->save(0);

        if( filter_var($content, FILTER_VALIDATE_URL) !== FALSE ){
            SpiderService::add($content);
        }

        if( in_array( $type, [ "text" ] )  && substr($content,0,1) == "#" ){
            $bind_info = UserOpenidUnionid::findOne( [ 'other_openid' => strval($from_openid) ]  );
            if( !$bind_info ){
                $unique_name = md5($from_openid);
                $user_info  = User::findOne(['unique_name' => $unique_name]);
                if( !$user_info ){
                    $model_user = new User();
                    $model_user->nickname = "微信用户".substr($from_openid,-10);
                    $model_user->unique_name = $unique_name;
                    $model_user->updated_time = $date_now;
                    $model_user->created_time = $date_now;
                    $model_user->save(0);
                    $user_info = $model_user;
                }

                $model_bind = new UserOpenidUnionid();
                $model_bind->uid = $user_info['uid'];
                $model_bind->openid = $from_openid;
                $model_bind->unionid = '';
                $model_bind->other_openid = $from_openid;
                $model_bind->updated_time = $date_now;
                $model_bind->created_time = $date_now;
                $model_bind->save(0);
            }

            if( $bind_info ){
                $model_message = new UserMessageHistory();
                $model_message->uid = $bind_info['uid'];
                $model_message->type = 1;
                $model_message->content = ltrim($content,"#");
                $model_message->status = 1;
                $model_message->updated_time = $date_now;
                $model_message->created_time = $date_now;
                $model_message->save(0);
            }
        }
    }

    
} 