<?php

namespace api\modules\weixin\controllers;

use api\modules\weixin\controllers\common\BaseController;
use common\models\posts\Posts;
use common\service\weixin\RecordService;

class DefaultController extends  BaseController {
    public function actionIndex(){
        if(array_key_exists('echostr',$_GET) && $_GET['echostr']){//用于微信第一次认证的
            echo $_GET['echostr'];exit();
        }
        if(!$this->checkSignature()){
            die("error");
            return false;
        }
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if($postStr){
            $this->recode_log($postStr);
            RecordService::add($postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msgType = trim($postObj->MsgType);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $res = ['type'=>'text','data'=>$this->help()];
            switch($msgType){
                case "text":
                    $res = $this->parseText($postObj);
                    break;
                case "event":
                    $res = $this->parseEvent($postObj);
                    break;
            }
            switch($res['type']){
                case "rich":
                    return $this->richTpl($fromUsername,$toUsername,$res['data']);
                    break;
                default:
                    return $this->textTpl($fromUsername,$toUsername,$res['data']);
            }
        }
        return "消息接口";
    }

    private function parseText($dataObj){
        $keyword = trim($dataObj->Content);
        return $this->getDataByKeyword($keyword);
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
                    case "hot":
                        $resData = "MD不能升级就没有自定义菜单";
                        break;
                    case "new":
                        $resData = "MD不能升级就没有自定义菜单";
                        break;
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

    private function getDataByKeyword($keyword){
        switch($keyword){
            case "hot":
                $type = "rich";
                $ret = Posts::find()->where(['status' => 1])->orderBy("comment_count desc")
                    ->limit(3)->all();
                break;
            case "new":
                $type = "rich";
                $ret = Posts::find() ->where(['status' => 1])->orderBy("id desc")
                    ->limit(3)->all();
                break;
            case "book":
                $type = "rich";
                $ret = [];
                break;
            default:
                $type = "text";
                $ret = [];
        }

        $data = $ret?$this->formatRichData($ret,$keyword):$this->help();

        return ['type' => $type,"data" => $data];
    }

    private function formatRichData($data,$type){
        $list = [];
        $domain_static = \Yii::$app->params['domains']['static'];
        foreach($data as $_item){
            $list[] = [
                "title" => $_item['title'],
                "description" => $_item['title'],
                "picurl" => "{$domain_static}/wx/".mt_rand(1,7).".jpg",
                "url" => "http://www.vincentguo.cn/default/".$_item['id']
            ];
        }
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
        return '您好，抱歉暂时没有搜索到相关内容';
    }

    /**
     * 关注默认提示
     */
    private function subscribeTips(){
        $resData = "感谢您关注郭大帅哥的公众号
请输入以下命令：
hot -> 查看热门博文
new -> 查看最新博文
book -> 查看图书馆
";
        return $resData;
    }


} 