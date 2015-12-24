<?php

namespace blog\modules\game\controllers;

use blog\components\UrlService;
use blog\modules\game\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\HttpClient;
use common\models\games\Music;
use common\service\bat\QQService;

class MusicController extends BaseController
{
    public function actionInfo(){
        $song_id = $this->get("song_id",1237792);
        $reback_url = UrlService::buildWapUrl("/default/index");
        $type = intval( $this->get("type",2) );
        if( !$song_id ){
            return $this->redirect( $reback_url );
        }

        $info = Music::findOne(['song_id' => $song_id,'type' => $type,'status' => 1]);
        if( !$info ){
            return $this->redirect( $reback_url );
        }

        $data = [
            "song_title" => DataHelper::encode( $info['song_title'] ),
            "song_author" => DataHelper::encode( $info['song_author'] ),
            "cover_image" => $info['cover_image'],
            "song_url" => $info['song_url'],
            "id" => $info['id']
        ];

        $this->setTitle("点歌台");
        $this->setSubTitle("点歌台");
        return $this->render("info",[
            "info" => $data
        ]);
    }


    public function actionLrc(){
        $mid = intval( $this->post("mid",0) );
        if( !$mid ){
            return $this->renderJSON([],"歌曲不存在",-1);
        }
        $info = Music::findOne(['id' => $mid,'status' => 1]);
        if( !$info ){
            return $this->renderJSON([],"歌曲不存在",-1);
        }

        $lrc_url = QQService::getSongLrcUrl($info['song_id']);
        $lrc_data = HttpClient::get($lrc_url);

        $lrc = '';
        if(substr($lrc_data,0,4) == "<?xml" ){
            $parser = xml_parser_create();
            xml_parse_into_struct($parser, $lrc_data, $values, $index);    //解析到数组
            xml_parser_free($parser);
            $lrc = isset($values[0]['value'])?$values[0]['value']:'';
        }

        $data = [
            'lrc' => $lrc,
            'song_url' => QQService::getSongUrl($info['song_id'],".mp3")
        ];

        return $this->renderJSON( $data );
    }
} 