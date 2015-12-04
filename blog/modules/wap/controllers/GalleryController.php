<?php
namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;
use common\service\GlobalUrlService;

class GalleryController extends BaseController {

    private $ignore = [".","..",".DS_Store","index.php"];
    public function actionIndex(){
        $this->setTitle("相册列表");
        return $this->render("index",[
            'gallery_list' => $this->getAlbum()
        ]);
    }

    public function actionList(){
        $album = trim( $this->get("album","") );
        $all_album = array_keys( $this->getAlbum() );

        if( !in_array( $album,$all_album) ){
            return $this->redirect( UrlService::buildWapUrl("/gallery") );
        }

        $images = [];
        $album_path = \Yii::$app->params['upload']['pic3']."/{$album}";
        if ( $handle = opendir($album_path) ) {
            while (false !== ($entry = readdir($handle))) {
                if ( in_array($entry,$this->ignore) ) {
                    continue;
                }
                $images[] = GlobalUrlService::buildPicStaticUrl("pic3","/{$album}/{$entry}",['h' => 250]);
            }
            closedir($handle);
        }

        $this->setTitle("相册 {$album}");

        return $this->render("list",[
            "images" => $images
        ]);
    }

    private function getAlbum(){
        $dir_path = \Yii::$app->params['upload']['pic3'];
        $album_list = [];
        if ( $handle = opendir($dir_path) ) {
            while (false !== ($entry = readdir($handle))) {
                if ( in_array($entry,$this->ignore) ) {
                    continue;
                }
                $album_list[ $entry ] = [
                    "name" => $entry,
                    "cover_url" => GlobalUrlService::buildPicStaticUrl("pic3","/{$entry}/1.jpg",['h' => 1000]),
                    "info_url" => UrlService::buildWapUrl("/gallery/list",['album' => $entry])
                ];
            }
            closedir($handle);
        }
        return $album_list;
    }
} 