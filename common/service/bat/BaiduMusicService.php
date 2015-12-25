<?php
namespace common\service\bat;


use common\components\HttpClient;
use common\models\games\Music;
use common\service\BaseService;

class BaiduMusicService extends  BaseService{
    public static function getMusic($kw = ''){
        $song_ids = [];
        if( $kw ){
            $url = "http://musicmini.baidu.com/app/search/searchList.php?qword=%s&ie=utf-8&page=1";
            $url = sprintf( $url,urlencode($kw) );
            $data = strtolower( HttpClient::get( $url ) ) ;
            $data = str_replace("&#039;","'",$data);
            $reg_rule = "/onclick=\"playsong\((.*?)\)\"/is";
            preg_match_all($reg_rule,$data,$matches);
            if( $matches && $matches[1] ){
                $rand_keys = array_rand($matches[1],5);
                foreach( $rand_keys as $_idx ){
                    $tmp_reg_rule = "/'(\d{2,})',/is";
                    preg_match_all($tmp_reg_rule,$matches[1][$_idx],$tmp_matches);
                    if( $tmp_matches && $tmp_matches[1] ){
                        $song_ids[] = $tmp_matches[1][0];
                    }
                }
            }
        }

        return self::getMusicInfoById( $song_ids );
    }

    public static function getMusicInfoById( $song_ids = []){
        $ret = [];
        $url = "http://music.baidu.com/data/music/links?songIds=%s";
        $url = sprintf($url,implode(",",$song_ids));
        $res = HttpClient::get( $url );
        $res = @json_decode( $res,true);
        if( $res && isset($res['data']) && $res['data'] ){
            $songs = $res['data']['songList'];
            if( $songs ){
                foreach( $songs as $_song ){
                    $tmp_lrc_link = str_replace("http://qukufile2.qianqian.com/data2/pic/","",$_song['lrcLink']);
                    $tmp_lrc_link = str_replace("http://c.hiphotos.baidu.com/ting/pic/item/ ","",$tmp_lrc_link );
                    if( stripos($tmp_lrc_link,"http")===false ){
                        $_song['lrcLink'] = "http://qukufile2.qianqian.com".$tmp_lrc_link;
                    }

                    if( self::saveMusic($_song) ){
                        $ret[] = $_song;
                    }
                }
            }
        }
        return $ret;
    }


    public static function saveMusic( $info ){
        $song_id = $info['songId'];

        $has_in = Music::findOne([ 'song_id' => $song_id,'type' => 1, 'status' => 1 ]);
        if( $has_in ){
            return true;
        }

        if( !$info['songPicRadio'] ){
            return false;
        }

        $model_music = new Music();
        $model_music->song_id = $song_id;
        $model_music->type = 1;
        $model_music->cover_image = $info['songPicRadio'];
        $model_music->lrc = @file_get_contents( $info['lrcLink'] );
        $model_music->song_url = $info['songLink'];
        $model_music->song_title = $info['songName'];
        $model_music->song_author = $info['artistName'];
        $model_music->text = json_encode( $info );
        $model_music->status = 1;
        $model_music->updated_time = date("Y-m-d H:i:s");
        $model_music->created_time = $model_music->updated_time;
        $model_music->save(0);
        return true;
    }

} 