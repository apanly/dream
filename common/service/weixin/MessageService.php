<?php
namespace common\service\weixin;

use common\models\weixin\MarketQrcode;
use common\models\weixin\OauthMember;
use common\models\weixin\QrcodeScanHistory;
use common\models\weixin\WxMsgHistory;
use common\models\weixin\WxWallHistory;
use common\service\BaseService;
use common\service\SpiderService;

class MessageService extends BaseService {

    public static function add($xml ){

        $data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $type = trim($data->MsgType);
        $from_openid = $data->FromUserName;
		$from_openid = (string)$from_openid;
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

        $model_wx_history = new WxMsgHistory();
        $model_wx_history->from_openid = $from_openid;
        $model_wx_history->to_openid = $to_openid;
        $model_wx_history->type = $type;
        $model_wx_history->content = $content;
        $model_wx_history->text = $xml;
        $model_wx_history->created_time = $date_now;
        $model_wx_history->save(0);

		if( filter_var($content, FILTER_VALIDATE_URL) !== FALSE ){
			SpiderService::add($content);
		}

		//保证用户一定在加入到数据表队列
		$member_info = OauthMember::findOne([ 'openid' => $from_openid ]);
		if( !$member_info ){
			$model_member = new OauthMember();
			$model_member->openid = $from_openid;
			$model_member->created_time = $model_member->updated_time = date("Y-m-d H:i:s");
			if( $model_member->save( 0 ) ){
				$member_info = $model_member;
			}
			WxQueueListService::addQueue( "info",[ "openid" => $from_openid ] );
		}


        if( in_array( $type, [ "event" ] ) && $content == "subscribe" ){
			$event_key = $data->EventKey;
			if( $event_key ){
				$qrcode_key = str_replace( "qrscene_","",$event_key );
				$qrcode_info = MarketQrcode::findOne( [ 'id' => $qrcode_key ]);
				if( $qrcode_info ){
					$qrcode_info->total_scan_count += 1;
					$qrcode_info->updated_time = date("Y-m-d H:i:s");
					$qrcode_info->update( 0 );

					$model_scan_history = new QrcodeScanHistory();
					$model_scan_history->openid = $from_openid;
					$model_scan_history->qrcode_id = $qrcode_info['id'];
					$model_scan_history->created_time = date("Y-m-d H:i:s");
					$model_scan_history->save( 0 );
				}
			}
        }


		if( in_array( $type, [ "text" ] )  && substr($content,0,1) == "#" ){
			if( $member_info ){
				$model_message = new WxWallHistory();
				$model_message->member_id = $member_info['id'];
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