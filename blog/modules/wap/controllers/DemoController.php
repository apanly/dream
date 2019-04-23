<?php

namespace blog\modules\wap\controllers;

use blog\modules\wap\controllers\common\BaseController;
use common\components\HttpClient;
use common\models\demo\MobileRange;
use common\service\weixin\RequestService;
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

	public function actionMobile(){
		if( Yii::$app->request->isGet ) {
			return $this->render("mobile");
		}

		$mobile = trim( $this->post( "mobile","" ) );

		if( strlen( $mobile ) < 1 || strlen( $mobile ) > 13 ){
			return $this->renderJSON( [],"请输入正确手机号码~",-1 );
		}

		$info = MobileRange::find()->where([ 'prefix' => mb_substr( $mobile,0,7 ,"utf-8") ])->one();
		$data = [];
		if( $info ){
			$data = [
				"provice" => $info['provice'],
				"city" => $info['city'],
				"operator" => $info['operator'],
				"zone" => $info['zone'],
				"code" => $info['code']
			];
		}

		return $this->renderJSON( $data );
	}

	public function actionLvb(){
    	return $this->render("lvb");
	}
}