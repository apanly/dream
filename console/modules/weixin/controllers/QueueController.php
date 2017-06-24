<?php

namespace console\modules\weixin\controllers;

use common\models\weixin\OauthMember;
use common\models\weixin\WxQueueList;
use common\service\QiniuUploadService;
use common\service\weixin\RequestService;
use common\service\weixin\WechatConfigService;
use common\service\weixin\WxQueueListService;

class QueueController extends BaseController {
	/**
	 * php yii weixin/queue/run
	 */
	public function actionRun( ){
		$list = WxQueueList::find()->where([ 'status' => -1  ])->orderBy([ 'id' =>SORT_ASC ])->limit( 10 )->all();
		if( !$list ){
			return $this->echoLog( 'no data to handle ~~' );
		}

		foreach( $list as $_item ){
			$this->echoLog("queue_id:{$_item['id']}");
			sleep( 1 );
			switch ( $_item['queue_name'] ){
				case "info":
					$this->handleInfo( $_item );
					break;
				case  "avatar":
					$this->handleMemberAvatar( $_item );
					break;
			}

			$_item->status = 1;
			$_item->updated_time = date("Y-m-d H:i:s");
			$_item->update( 0 );
		}

		return $this->echoLog("it's over ~~");
	}

	private function handleInfo( $item ){
		$data = @json_decode( $item['data'],true );

		if( !isset( $data['openid'] ) || !$data['openid'] ){
			return false;
		}


		$member_info = OauthMember::findOne([ 'openid' => $data['openid'] ]);
		if( $member_info ){
			return false;
		}

		$config = WechatConfigService::getConfig();
		RequestService::setConfig( $config['appid'],$config['apptoken'],$config['appsecret'] );
		$access_token = RequestService::getAccessToken();
		$info = RequestService::send( "user/info?access_token={$access_token}&openid={$data['openid']}&lang=zh_CN" );
		if( $info ){
			$model_member = new OauthMember();
			$model_member->openid = isset( $info['openid'] )?$info['openid']:'';
			$model_member->nickname = isset( $info['nickname'] )?$info['nickname']:'';
			$model_member->sex = isset( $info['sex'] )?$info['sex']:'0';
			$model_member->country = isset( $info['country'] )?$info['country']:'';
			$model_member->province = isset( $info['province'] )?$info['province']:'';
			$model_member->city = isset( $info['city'] )?$info['city']:'';
			$model_member->headimgurl = isset( $info['headimgurl'] )?$info['headimgurl']:'';
			$model_member->subscribe = isset( $info['subscribe'] )?$info['subscribe']:'0';
			$model_member->created_time = $model_member->updated_time = date("Y-m-d H:i:s");
			if( $model_member->save( 0 ) ){
				WxQueueListService::addQueue( "avatar",[ "member_id" => $model_member->id,"avatar_url"  => $model_member->headimgurl] );
			}
		}
		return true;
	}

	private function handleMemberAvatar( $item ){
		$data = @json_decode( $item['data'],true );

		if( !isset( $data['member_id'] ) || !isset( $data['avatar_url']) ){
			return false;
		}


		if( !$data['member_id'] || !$data['avatar_url'] ){
			return false;
		}

		$member_info = OauthMember::findOne([ 'id' => $data['member_id'] ]);
		if( !$member_info ){
			return false;
		}
		$upload_target  = new QiniuUploadService();
		$ret = $upload_target->saveFile( $data['avatar_url'],"avatar" );
		if( $ret && isset( $ret[0] )){
			$member_info->avatar = $ret[0]['key'];
			$member_info->update( 0 );
		}
		return true;
	}
}
