<?php

namespace api\modules\weixin\controllers;

use api\modules\weixin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\library\Book;
use common\models\posts\Posts;
use common\models\search\IndexSearch;
use common\models\user\UserOpenidUnionid;
use common\service\bat\QQMusicService;
use common\service\GlobalUrlService;
use common\service\weixin\RecordService;

class DefaultController extends  BaseController {
    public function actionIndex(){
        if(array_key_exists('echostr',$_GET) && $_GET['echostr']){//用于微信第一次认证的
            echo $_GET['echostr'];exit();
        }
        if(!$this->checkSignature()){
            return "success";
        }
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if($postStr){
            $this->recode_log($postStr);
            RecordService::add( $postStr,$this->getSource() );
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msgType = trim($postObj->MsgType);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $res = ['type'=>'text','data'=>$this->help()];
            switch($msgType){
                case "text":
                    $res = $this->parseText($postObj);
                    break;
                case "image":
                case "voice":
                case "video":
                    $res = ['type'=>"text",'data'=>$this->richMediaTips()];
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
        if( filter_var($keyword, FILTER_VALIDATE_URL) !== FALSE ){
            return ['type'=> "text",'data'=> $this->urlTips() ];
        }

        $cmd_tip = substr($keyword,0,1);
        switch ( $cmd_tip ){
            case "@"://搜歌曲
                return $this->searchMusicByKw($keyword);
                break;
            case "#"://微信墙
                $bind_info = UserOpenidUnionid::findOne( [ 'other_openid' => trim($dataObj->FromUserName) ]  );
                if( $bind_info ){
                    return 'success';
                }
                $keyword = "上墙";
                break;
        }

        switch( $keyword ){
            case "上墙" :
                $data = [
                    [
                        'title' => '点击授权签到',
                        'description' => \Yii::$app->params['author']['nickname']."微信墙,授权后方可上墙留言",
                        'picurl' => GlobalUrlService::buildPic1Static("/20160531/7ba8f923c344a5af480cd76dd358e196.jpg",[ 'w' => 800]),
                        'url' =>  GlobalUrlService::buildWapUrl("/wechat_wall/sign",['woid' => trim($dataObj->FromUserName)])
                    ]
                ];
                return ['type' => "rich" ,"data" => $this->getRichXml($data)];
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
                    case "blog_original":
                        return $this->getOriginalBlog();
                        break;
                    case "ktv":
                        $resData =  $this->songTips();
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

    private function getOriginalBlog(){
        $post_list = Posts::find()
            ->where([ 'original' => 1,'status' => 1 ])
            ->orderBy("updated_time desc")
            ->limit(5)
            ->all();

        $list = [];
        if( $post_list ){
            $domain_static = \Yii::$app->params['domains']['static'];
            foreach($post_list as $_item){
                $tmp_image = "{$domain_static}/wx/".mt_rand(1,7).".jpg";
                if( $_item['image_url'] ){
                    $tmp_image = $_item['image_url'];
                }
                $list[] = [
                    "title" => $_item['title'],
                    "description" => $_item['title'],
                    "picurl" => $tmp_image,
                    "url" => GlobalUrlService::buildWapUrl("/default/info",['id' => $_item['id'] ])
                ];
            }
        }
        $data = $list?$this->getRichXml($list):$this->help();
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
回复“上墙” 演示微信墙\n
回复“@关键字”搜索歌曲\n
回复“#xxx”发送上墙内容\n
回复“hadoop,https”搜索博文\n
可访问:m.54php.cn\n
咨询类信息由于工作原因当天晚上统一回复
EOT;
        return $resData;
    }

    /**
     * 关注默认提示
     */
    private function subscribeTips(){
        $from = $this->getSource();
        $author_nickname = DataHelper::getAuthorName();
        if($from == "imguowei_888" ){
            $resData = <<<EOT
感谢您的关注，除了菜单还可以输入关键字\n
回复“上墙” 演示微信墙\n
回复“@关键字” 搜索歌曲
EOT;
        }else{
            $resData = <<<EOT
感谢您关注{$author_nickname}的公众号
输入关键字,{$author_nickname}会回复你的！！
EOT;
        }

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
} 