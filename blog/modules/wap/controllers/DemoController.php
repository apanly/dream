<?php

namespace blog\modules\wap\controllers;

use blog\modules\wap\controllers\common\BaseController;
use Yii;

class DemoController extends BaseController{

    public function actionIndex(){
        $this->setTitle("Demo列表");
        return $this->render('index');
    }
    public function actionH5_upload(){
        if( Yii::$app->request->isGet ){
            return $this->render("h5_upload");
        }
        /*ios uc @ weixin 测试ok的*/
//        $image_data = $this->post("image_data");
//        $image_data = str_replace("data:image/jpeg;base64,","",$image_data);
//        file_put_contents("/home/www/yii_tools/dream/test.jpg",base64_decode($image_data));
        return $this->renderJSON();
    }

    public function actionScan_code(){
        return $this->render("scan_code");
    }
}