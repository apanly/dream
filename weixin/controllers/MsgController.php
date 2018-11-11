<?php
namespace weixin\controllers;

use common\service\SpiderService;
use common\service\weixin\MsgCryptService;
use common\service\weixin\WechatConfigService;
use common\service\weixin\MessageService;

use common\components\DataHelper;
use common\models\search\IndexSearch;
use common\service\bat\QQMusicService;
use common\service\GlobalUrlService;


class MsgController extends BaseController{

    public function actionIndex( ){
		if( !$this->checkSignature() ){
			$this->record_log( "校验错误" );
			return 'error signature ~~';
		}

		if( array_key_exists('echostr',$_GET) && $_GET['echostr']){//用于微信第一次认证的
			return $_GET['echostr'];
		}

		//因为很多都设置了register_globals禁止,不能用$GLOBALS["HTTP_RAW_POST_DATA"];
		$xml_data = file_get_contents("php://input");
		$this->record_log( "[xml_data]:". $xml_data );
		if( !$xml_data ){
			return 'error xml ~~';
		}

		$msg_signature = trim( $this->get("msg_signature","") );
		$timestamp = trim( $this->get("timestamp","") );
		$nonce = trim( $this->get("nonce","") );

		$config = WechatConfigService::getConfig();
		$target = new MsgCryptService( $config['apptoken'], $config['aeskey'], $config['appid']);
		$err_code = $target->decryptMsg($msg_signature, $timestamp, $nonce, $xml_data, $decode_xml);
		if ( $err_code != 0) {
			return 'error decode ~~';
		}

		$this->record_log( '[decode_xml]:'.$decode_xml );

		MessageService::add( $decode_xml );

		$xml_obj = simplexml_load_string($decode_xml, 'SimpleXMLElement', LIBXML_NOCDATA);

		$from_username = $xml_obj->FromUserName;
		$to_username = $xml_obj->ToUserName;
		$msg_type = $xml_obj->MsgType;//信息类型
		$reply_time = time();

		$res = [ 'type'=>'text','data'=>$this->help() ];

		switch ( $msg_type ){
			case "text":
				$kw = trim( $xml_obj->Content );
				if( in_array($kw ,["商城账号","商城帐号","账号","帐号","订餐小程序","小程序"] ) ){
					$res = [ 'type'=>'text','data'=> '用户名：54php.cn，密码：123456，个人QQ群：325264502' ];
				}else{
					$res = $this->parseText( $xml_obj );
				}
				break;
			case "event":
				$res = $this->parseEvent( $xml_obj );
				break;
			default:
				break;
		}

		switch($res['type']){
			case "rich":
				$plain_data = $this->richTpl($from_username,$to_username,$res['data']);
				break;
			default:
				$plain_data = $this->textTpl($from_username,$to_username,$res['data']);
		}

		$encrypt_msg = '';
		$this->record_log( $plain_data );
		$err_code = $target->encryptMsg($plain_data, $reply_time, $nonce,$encrypt_msg);
		if ( $err_code != 0) {
			return 'error encode ~~';
		}
		return $encrypt_msg;
    }


	private function parseText($dataObj){
		$keyword = trim($dataObj->Content);
		$cmd_tip = substr($keyword,0,1);
		switch ( $cmd_tip ){
			case "@"://搜歌曲
				return $this->searchMusicByKw($keyword);
				break;
			case "#"://微信墙
				$data = [
					[
						'title' => '上墙成功',
						'description' => "点击这里，进入列表查看",
						'picurl' => GlobalUrlService::buildPic1Static("/20160531/7ba8f923c344a5af480cd76dd358e196.jpg",[ 'w' => 800]),
						'url' =>  GlobalUrlService::buildWapUrl("/wechat_wall/index")
					]
				];
				return ['type' => "rich" ,"data" => $this->getRichXml($data)];
				break;
			default:
				if (preg_match('/(http:\/\/)|(https:\/\/)/i', $keyword)) {
					SpiderService::add( $keyword);
					return ['type'=> "text",'data'=> $this->urlTips() ];
				}
				break;
		}

		switch( $keyword ){
			case "上墙" :
				return ['type' => "text" ,"data" => $this->wallTip() ];
				break;
		}

		return $this->getDataByKeyword($keyword,trim($dataObj->FromUserName));
	}

	private function parseEvent($dataObj){
		$resType = "text";
		$resData = $this->help();
		$event = $dataObj->Event;
		switch($event){
			case "subscribe":
				$resData = $this->subscribeTips();
				break;
			case "CLICK":
				$eventKey = trim($dataObj->EventKey);
				switch($eventKey){
				}
				break;
		}
		return ['type'=>$resType,'data'=>$resData];
	}

	private function textTpl($fromUsername,$toUsername,$data){
		$textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        <FuncFlag>0</FuncFlag>
        </xml>";
		return sprintf($textTpl, $fromUsername, $toUsername, time(), "text", $data);
	}

	private function richTpl($fromUsername,$toUsername,$data){
		$tpl = <<<EOT
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
%s
</xml>
EOT;
		return sprintf($tpl, $fromUsername, $toUsername, time(), $data);

	}

	private function getDataByKeyword($keyword,$fromUsername = ''){

		$search_key =  ['LIKE' ,'search_key','%'.strtr($keyword,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false];
		$mixed_list = IndexSearch::find()->where($search_key)->orderBy("id desc")->limit(5)->all();
		$list = [];
		if( $mixed_list ){
			$domain_static = \Yii::$app->params['domains']['static'];
			foreach($mixed_list as $_item){
				$tmp_image = "{$domain_static}/wx/".mt_rand(1,7).".jpg";
				if( $_item['image'] ){
					$tmp_image = $_item['image'];
				}

				if( $_item['post_id'] ){
					$tmp_url = GlobalUrlService::buildWapUrl("/default/info",['id' => $_item['post_id'],'woid' => trim($fromUsername) ]);
				}else{
					$tmp_url = GlobalUrlService::buildWapUrl("/library/info",['id' => $_item['book_id'] ,'woid' => trim($fromUsername)]);
				}

				$list[] = [
					"title" => $_item['title'],
					"description" => $_item['title'],
					"picurl" => $tmp_image,
					"url" => $tmp_url
				];
			}
		}

		$data = $list?$this->getRichXml($list):$this->help();
		$type = $list?"rich":"text";
		return ['type' => $type ,"data" => $data];
	}


	private function searchMusicByKw($kw){
		$songs = QQMusicService::search($kw);
		$list = [];
		if( $songs ){
			foreach( $songs as $_song_info ){
				$list[] = [
					"title" => $_song_info['song_author']." -- ".$_song_info['song_title'],
					"description" => '',
					"picurl" => $_song_info['cover_image'],
					"url" => $_song_info['view_url']
				];
			}
		}
		$data = $list?$this->getRichXml($list):"抱歉没有搜索到关于 {$kw} 的歌曲";
		$type = $list?"rich":"text";
		return ['type' => $type ,"data" => $data];
	}


	private function getRichXml($list){
		$article_count = count( $list );
		$article_content = "";
		foreach($list as $_item){
			$article_content .= "
<item>
<Title><![CDATA[{$_item['title']}]]></Title>
<Description><![CDATA[{$_item['description']}]]></Description>
<PicUrl><![CDATA[{$_item['picurl']}]]></PicUrl>
<Url><![CDATA[{$_item['url']}]]></Url>
</item>";
		}

		$article_body = "<ArticleCount>%s</ArticleCount>
<Articles>
%s
</Articles>";
		return sprintf($article_body,$article_count,$article_content);
	}


	private function help(){
		$resData = <<<EOT
没找到你想要的东西（：\n
回复“@ + 关键字”搜索歌曲\n
回复“上墙” 演示微信墙\n
回复“# + 关键字”发送上墙内容\n
回复“hadoop,https”搜索博文\n
也可点击菜单进入系统\n
咨询类信息由于工作原因当天晚上统一回复
EOT;
		return $resData;
	}

	/**
	 * 关注默认提示
	 */
	private function subscribeTips(){
		$resData = <<<EOT
感谢您关注编程浪子的公众号
QQ群：325264502\n
回复“上墙” 演示微信墙\n
回复“@关键字” 搜索歌曲
EOT;
		return $resData;
	}

	private function richMediaTips(){
		$author_nickname = DataHelper::getAuthorName();
		$resData = <<<EOT
{$author_nickname}收到您提供的多媒体信息
审核通过之后就会在博客展示！！
EOT;
		return $resData;
	}

	private function urlTips(){
		$author_nickname = DataHelper::getAuthorName();
		$resData = <<<EOT
{$author_nickname}收到您提供的链接
系统会自己抓取内容,审核之后就会展示！！
EOT;
		return $resData;
	}

	private function songTips(){
		$resData = <<<EOT
点歌，请回复
@歌曲名称 或 @歌手名
如@王菲，@匆匆那年
EOT;
		return $resData;
	}

	private function wallTip(){
		$resData = "欢迎使用". \Yii::$app->params['author']['nickname']."微信墙，操作指引如下\r\n回复 # + 你想说的话\r\n 微信墙列表:".GlobalUrlService::buildWapUrl("/wechat_wall/index");
		return $resData;
	}



}
