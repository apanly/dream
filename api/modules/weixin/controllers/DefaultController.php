<?php

namespace api\modules\weixin\controllers;

use api\modules\weixin\controllers\common\BaseController;
use common\models\library\Book;
use common\models\posts\Posts;
use common\models\search\IndexSearch;
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
                    case "blog_new":
                        return  $this->getLastestBlog();
                        break;
                    case "book_hot":
                        return $this->getHotBook();
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

        $search_key =  ['LIKE' ,'search_key','%'.strtr($keyword,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false];
        $mixed_list = IndexSearch::find()->where($search_key)->orderBy("id desc")->limit(5)->all();
        $list = [];
        if( $mixed_list ){
            $domain_static = \Yii::$app->params['domains']['static'];
            $domain_blog = \Yii::$app->params['domains']['blog'];
            foreach($mixed_list as $_item){
                $tmp_image = "{$domain_static}/wx/".mt_rand(1,7).".jpg";
                if( $_item['image'] ){
                    $tmp_image = $_item['image'];
                }

                if( $_item['post_id'] ){
                    $tmp_url = "{$domain_blog}/default/".$_item['post_id'];
                }else{
                    $tmp_url = "{$domain_blog}/library/detail/".$_item['book_id'];
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

    private function getLastestBlog(){
        $post_list = Posts::find()
            ->where([ 'status' => 1 ])
            ->orderBy("updated_time desc")
            ->limit(5)
            ->all();

        $list = [];
        if( $post_list ){
            $domain_static = \Yii::$app->params['domains']['static'];
            $domain_blog = \Yii::$app->params['domains']['blog'];
            foreach($post_list as $_item){
                $tmp_image = "{$domain_static}/wx/".mt_rand(1,7).".jpg";
                $list[] = [
                    "title" => $_item['title'],
                    "description" => $_item['title'],
                    "picurl" => $tmp_image,
                    "url" => "{$domain_blog}/default/".$_item['id']
                ];
            }
        }
        $data = $list?$this->getRichXml($list):$this->help();
        $type = $list?"rich":"text";
        return ['type' => $type ,"data" => $data];
    }

    private function getHotBook(){
        $book_list = Book::find()
            ->where([ 'status' => 1 ])
            ->orderBy("id desc")
            ->limit(5)
            ->all();

        $list = [];
        if( $book_list ){
            $domain_blog = \Yii::$app->params['domains']['blog'];
            foreach($book_list as $_item){
                $list[] = [
                    "title" => $_item['subtitle'],
                    "description" => $_item['subtitle'],
                    "picurl" => $_item['origin_image_url'],
                    "url" => "{$domain_blog}/library/detail/".$_item['id']
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
郭大帅哥没有找到你想要的东西（：
试试hadoop,mysql等等，
 也可以直接去我的网站 www.vincentguo.cn
EOT;
        return $resData;
    }

    /**
     * 关注默认提示
     */
    private function subscribeTips(){

        $resData = <<<EOT
感谢您关注郭大帅哥的公众号
输入关键字,郭大帅哥会回复你的！！
EOT;
        return $resData;
    }

    private function richMediaTips(){
        $resData = <<<EOT
郭大帅哥收到您提供的多媒体信息
审核通过之后就会在博客展示！！
EOT;
        return $resData;
    }

    private function urlTips(){
        $resData = <<<EOT
郭大帅哥收到您提供的链接
系统会自己抓取内容,审核之后就会展示！！
EOT;
        return $resData;
    }

} 