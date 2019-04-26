<?php

namespace blog\modules\game\controllers;

use blog\modules\game\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\games\Music;
use common\service\bat\NeteaseMusicService;
use common\service\bat\MusicService;
use common\service\GlobalUrlService;

class MusicController extends BaseController{

    public function actionIndex(){
        $kw = trim( $this->get("kw","") );
        $music_list = [];
        if( $kw ){
			$api = new NeteaseMusicService();
			$songs = $api->search( $kw,10 );
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
        $song_id = $this->get("song_id",0 );
        $reback_url = GlobalUrlService::buildWapUrl("/default/index");
        $type = intval( $this->get("type",3) );
        if( !$song_id ){
            return $this->redirect( $reback_url );
        }

        $info = Music::findOne(['song_id' => $song_id,'type' => $type,'status' => 1]);
        if( !$info ){
			$api = new NeteaseMusicService();
			$info = $api->getSongInfo( $song_id );
			MusicService::saveMusic($info);
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
		$api = new NeteaseMusicService();
		$lrc = $api->getSongLrcUrl( $song_id );
        $data = [
            'lrc' => $lrc,
            'song_url' => $info['song_url']
        ];

        return $this->renderJSON( $data );
    }
} 