<?php
namespace common\service\bat;


use blog\components\UrlService;
use common\components\HttpClient;
use common\models\games\Music;
use common\service\BaseService;

class QQMusicService extends  BaseService{
    public static function search($kw = ''){
        $ret = [];
        if( $kw ){
            $url = "http://s.music.qq.com/fcgi-bin/music_search_new_platform?t=0&n=100&aggr=1&cr=1&loginUin=0&format=json&inCharset=GB2312&outCharset=utf-8&notice=0&platform=jqminiframe.json&needNewCode=0&p=1&catZhida=0&remoteplace=sizer.newclient.next_song&w=%s";
            $url = sprintf( $url,urlencode($kw) );
            $data = trim( HttpClient::get( $url ) ) ;
            $data = @json_decode( $data,true );
            $ret = self::buildData( $data );
        }
        return $ret;
    }


    public static function saveMusic( $info ){

        $date_now = date("Y-m-d H:i:s");
        $has_in = Music::findOne([ 'song_id' => $info['song_id'],'type' => $info['type'] ]);
        if( $has_in ){
            $has_in->status = 1;
            $has_in->updated_time = $date_now;
            $has_in->update(0);
            return true;
        }


        $model_music = new Music();
        $model_music->song_id = $info['song_id'];
        $model_music->type = isset( $info['type'] )?$info['type']:2;
        $model_music->cover_image = isset( $info['cover_image'] )?$info['cover_image']:"";
        $model_music->lrc = isset( $info['lrc'] )?$info['lrc']:"";
        $model_music->song_url = isset( $info['song_url'] )?$info['song_url']:"";
        $model_music->song_title =  isset( $info['song_title'] )?$info['song_title']:"";
        $model_music->song_author = isset($info['song_author'])?$info['song_author']:"";
        $model_music->text = isset($info['text'])?json_encode( $info['text'] ):"";
        $model_music->format_data = isset($info['format_data'])?json_encode( $info['format_data'] ):"";
        $model_music->status = isset( $info['status'] )?$info['status']:1;
        $model_music->updated_time = $date_now;
        $model_music->created_time = $date_now;
        $model_music->save(0);
        return true;
    }

    private static function buildData( $data ){
        $ret = [];
        if( $data['code'] == 0 ){
            $song_list = $data['data']['song']['list'];
            $rand_songs = $song_list;
            if( count( $song_list ) >= 7  ){
                $song_list_keys = array_rand($song_list ,7);
                $rand_songs = array_slice($song_list,0,1);
                foreach( $song_list_keys as $_idx ){
                    $rand_songs[] = $song_list[$_idx];
                }
            }


            foreach( $rand_songs as $_item ){
                $tmp_attr_f = explode("|",$_item['f']);
                if( !isset($tmp_attr_f[4]) ){
                    continue;
                }
                $tmp_song_id = $tmp_attr_f[0];
                $tmp_img_id = $tmp_attr_f[4];
                $tmp_mid = $tmp_attr_f[20];
                $tmp_info = [
                    'song_id' => $tmp_song_id,
                    'type' => 2,
                    'cover_image' => self::getCoverImageUrl($tmp_img_id),
                    "lrc" => "",
                    "song_url" => self::getSongUrl($tmp_song_id,".mp3"),
                    "song_title" => $_item['fsong'],
                    "song_author" => $_item['fsinger'],
                    "text" => $_item,
                    "format_data" => [ 'image_id' => $tmp_img_id,'mid' => $tmp_mid ],
                    "status" => 1,
                    "view_url" => UrlService::buildGameUrl("/music/info",['song_id' => $tmp_song_id])
                ];
                $ret[] = $tmp_info;
            }
        }
        return $ret;
    }

    public static function getCoverImageUrl( $image_id,$width = 500 ){
        return "http://imgcache.qq.com/music/photo/album_{$width}/".($image_id%100)."/{$width}_albumpic_{$image_id}_0.jpg";
    }

    /**
     * $tone_quality => 24,48,128,320
     */
    public static function getSongUrl($song_id,$format = ".m4a",$tone_quality = 24,$hidden = true){
        $url = "http://tsmusic{$tone_quality}.tc.qq.com/{$song_id}{$format}";
        if( $hidden ){
            $pwd1 = md5(time());
            $pwd2 = base64_encode(time());
            $url = "http://tsmusic24.tc.qq.com/{$pwd1}/{$pwd2}/{$song_id}{$format}?uid=101&dir=B2&f=1";
        }
        return $url;
    }

    public static function getSongLrcUrl($song_id){
        return "http://music.qq.com/miniportal/static/lyric/".($song_id%100)."/{$song_id}.xml";
    }

    public static function getSongInfo($song_id){
        $ret = [];
        $url = "http://s.plcloud.music.qq.com/fcgi-bin/fcg_list_songinfo.fcg?idlist=%s&callback=jsonCallback&url=1";
        $url = sprintf($url,$song_id);
        $data_jsonp = trim( HttpClient::get( $url ) ) ;
        $data_json = mb_substr($data_jsonp,13,-1);
        $find = [
            'code:',
            'data:',
            'url:',
            'url1:'
        ];
        $replace = [
            '"code":',
            '"data":',
            '"url":',
            '"url1":'
        ];
        $data_json = str_replace($find,$replace,$data_json);
        $data = @json_decode( $data_json, true);
        if( $data && isset($data['code']) && $data['code'] == 0 ){
            $song_attr_f = explode("|",$data['data'][$song_id]);
            if( isset($song_attr_f[4]) ){
                $tmp_song_id = $song_attr_f[0];
                $tmp_img_id = $song_attr_f[4];
                $tmp_mid = $song_attr_f[20];
                $ret = [
                    'song_id' => $tmp_song_id,
                    'type' => 2,
                    'cover_image' => self::getCoverImageUrl($tmp_img_id),
                    "lrc" => "",
                    "song_url" => self::getSongUrl($tmp_song_id,".mp3"),
                    "song_title" => $song_attr_f[1],
                    "song_author" => $song_attr_f[3],
                    "text" => $data,
                    "format_data" => [ 'image_id' => $tmp_img_id,'mid' => $tmp_mid ],
                    "status" => 1,
                    "view_url" => UrlService::buildGameUrl("/music/info",['song_id' => $tmp_song_id])
                ];
            }

        }
        return $ret;
    }

} 