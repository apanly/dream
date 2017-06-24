<?php

namespace admin\controllers;

use admin\components\AdminUrlService;
use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\weixin\OauthMember;
use common\models\weixin\WxMsgHistory;
use common\service\GlobalUrlService;


class WechatController extends BaseController{
    public function actionIndex(){
        $p = intval( $this->get("p",1) );
        if(!$p){
            $p = 1;
        }

		$query = WxMsgHistory::find();
		$total_count = $query->count();
		$offset = ($p - 1) * $this->page_size;
		$list = $query->orderBy([ 'id' => SORT_DESC ] )
			->offset($offset)->limit( $this->page_size )
			->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);

		$data = [];
		if( $list ){
			$user_mapping = DataHelper::getDicByRelateID( $list,OauthMember::className(),"from_openid","openid",["id","nickname","avatar"]);
			foreach( $list as $_item ){
				$tmp_user_info = isset( $user_mapping[ $_item['from_openid'] ] )?$user_mapping[ $_item['from_openid'] ]:'';
				$data[] = [
					'id' => $_item['id'],
					'member_id' => $tmp_user_info?$tmp_user_info['id']:0,
					"nickname" => $tmp_user_info?DataHelper::encode( $tmp_user_info['nickname'] ):'',
					"avatar" => ( $tmp_user_info && $tmp_user_info['avatar'] )?GlobalUrlService::buildPicStaticUrl("avatar","/{$tmp_user_info['avatar']}",[ 'w' => 100,'h' => 100 ]):GlobalUrlService::buildStaticUrl("/images/wap/no_avatar.png"),
					'type' => $_item['type'],
					'content' => $_item['content'],
					'text' => $_item['text'],
				];
			}
		}


		return $this->render("index",[
			"data" => $data,
			"page_info" => $page_info,
			'search_conditions' => []
		]);

    }

	public function actionMember(){
		$p = intval( $this->get("p",1) );
		if(!$p){
			$p = 1;
		}
		$query = OauthMember::find();
		$total_count = $query->count();
		$offset = ($p - 1) * $this->page_size;
		$list = $query->orderBy([ 'id' => SORT_DESC ] )
			->offset($offset)->limit( $this->page_size )
			->all();

		$page_info = DataHelper::ipagination([
			"total_count" => $total_count,
			"page_size" => $this->page_size,
			"page" => $p,
			"display" => 10
		]);

		$data = [];
		if( $list ){
			foreach( $list as $_item ){
				$data[] = [
					'id' => $_item['id'],
					'nickname' => DataHelper::encode( $_item['nickname'] ),
					"avatar" => $_item['avatar']?GlobalUrlService::buildPicStaticUrl("avatar","/{$_item['avatar']}",[ 'w' => 100,'h' => 100 ]):GlobalUrlService::buildStaticUrl("/images/wap/no_avatar.png"),
					'sex' => $_item['sex'],
					'country' => $_item['country'],
					'province' => $_item['province'],
					'city' => $_item['city'],
					'created_time' => $_item['created_time']
				];
			}
		}

		return $this->render("member",[
			"data" => $data,
			"page_info" => $page_info,
			'search_conditions' => []
		]);
	}

	public function actionReply(){
		$member_id = $this->get( "member_id",0 );
		if( !$member_id ){
			return $this->redirect( AdminUrlService::buildUrl( "/wechat/index" ) );
		}

		$member_info = OauthMember::findOne([ 'id' => $member_id ]);
		if( !$member_info ){
			return $this->redirect( AdminUrlService::buildUrl( "/wechat/index" ) );
		}

		$list = WxMsgHistory::find()->where([ 'from_openid' => $member_info['openid'] ])
			->orderBy([ 'id' => SORT_DESC ] )->limit( 10 )->all();
		$data = [];
		if( $list ){
			foreach( $list as $_item ){
				$data[] = [
					'id' => $_item['id'],
					'member_id' => $member_info?$member_info['id']:0,
					"nickname" => $member_info?DataHelper::encode( $member_info['nickname'] ):'',
					"avatar" => ( $member_info && $member_info['avatar'] )?GlobalUrlService::buildPicStaticUrl("avatar","/{$member_info['avatar']}",[ 'w' => 100,'h' => 100 ]):GlobalUrlService::buildStaticUrl("/images/wap/no_avatar.png"),
					'type' => $_item['type'],
					'content' => $_item['content']
				];
			}
		}

		return $this->render( "reply",[
			"data" => $data,
			"member_info" => $member_info
		] );
	}
}