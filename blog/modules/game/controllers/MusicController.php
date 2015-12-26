<?php

namespace blog\modules\game\controllers;

use blog\components\UrlService;
use blog\modules\game\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\HttpClient;
use common\models\games\Music;
use common\service\bat\QQMusicService;

class MusicController extends BaseController
{
    public function actionIndex(){
        $kw = trim( $this->get("kw","") );
        $music_list = [];
        if( $kw ){
            $songs = QQMusicService::search($kw,false,[ 'page_size' => 20 ]);
            if( $songs ){
                foreach($songs as $_song ){
                    $music_list[] = $_song;
                }
            }
        }

        $this->setTitle("QQ音乐资源获取");
        $this->setSubTitle("QQ音乐资源获取");
        return $this->render("index",[
            "music_list" => $music_list,
            "kw" => $kw
        ]);
    }

    public function actionInfo(){
        $song_id = $this->get("song_id",1237792);
        $reback_url = UrlService::buildWapUrl("/default/index");
        $type = intval( $this->get("type",2) );
        if( !$song_id ){
            return $this->redirect( $reback_url );
        }

        $info = Music::findOne(['song_id' => $song_id,'type' => $type,'status' => 1]);
        if( !$info ){
            $info = QQMusicService::getSongInfo($song_id);
            QQMusicService::saveMusic($info);
        }

        $data = [
            "song_title" => DataHelper::encode( $info['song_title'] ),
            "song_author" => DataHelper::encode( $info['song_author'] ),
            "cover_image" => $info['cover_image'],
            "song_url" => $info['song_url'],
            "song_id" => $info['song_id']
        ];

        $this->setTitle("点歌台");
        $this->setSubTitle("点歌台");
        return $this->render("info",[
            "info" => $data
        ]);
    }


    public function actionLrc(){
        $song_id = intval( $this->post("song_id",0) );
        if( !$song_id ){
            return $this->renderJSON([],"歌曲不存在",-1);
        }

        $info = Music::findOne(['song_id' => $song_id,'status' => 1]);
        if( !$info ){
            return $this->renderJSON([],"歌曲不存在",-1);
        }

        /*获取歌词*/
        $lrc_url = QQMusicService::getSongLrcUrl( $song_id );
        $lrc_data = HttpClient::get($lrc_url);
        $lrc = '';
        if(substr($lrc_data,0,5) == "<?xml" ){
            $parser = xml_parser_create();
            xml_parse_into_struct($parser, $lrc_data, $values, $index);    //解析到数组
            xml_parser_free($parser);
            $lrc = isset($values[0]['value'])?$values[0]['value']:'';
        }

        $data = [
            'lrc' => $lrc,
            'song_url' => QQMusicService::getSongUrl($song_id,".mp3")
        ];

        return $this->renderJSON( $data );
    }
} 