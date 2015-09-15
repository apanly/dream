<?php
namespace common\service\weixin;


use common\models\weixin\WxHistory;

class RecordService {

    public static function add($xml){

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
        $model_wx_history->created_time = $date_now;
        $model_wx_history->save(0);

    }
} 