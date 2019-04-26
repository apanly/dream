<?php
namespace common\service\bat;


use common\models\games\Music;
use common\service\BaseService;

class MusicService extends  BaseService{


    public static function saveMusic( $info ){
        if( !isset( $info['song_id']) ){
            return false;
        }
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


} 