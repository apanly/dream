<?php

namespace blog\modules\wap\controllers;

use blog\modules\wap\controllers\common\BaseController;
use common\components\HttpClient;
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


    public function actionWapPay(){
		return $this->render("h5pay");
	}


	private $appid = "wx6855908ad9d88be2";
	private $appkey = "71175213dc4be9a962211e0d932be9a6";
	private $token = "hWgjy7lmElJOY9F";

	public function actionMogoPay(){
    	if( Yii::$app->request->isGet ){
    		return $this->render( "mogo_pay" );
		}

		$openid = $this->post("openid","");
    	if( !$openid ){
    		return $this->renderJSON( [],"请输入openid~~",-1 );
		}

		$order_url = "https://vsp.allinpay.com/apiweb/unitorder/pay";
		$randomstr = md5( time() );
		$params = [
			"cusid" => "389290070130113",
			"appid" => "00013306",
			"key" => "Aw1M7sPITAv1ecOP",
			"version" => "11",
			"trxamt" => "1",
			"reqsn" => $randomstr,
			"paytype" => "W02",
			"randomstr" => $randomstr,
			"body" => "测试支付",
			"validtime" => 30,
			"acct" =>  $openid ,
			"notify_url" => "http://m.54php.cn/demo/callback",
			"limit_pay" => "no_credit"
		];

		$sign = $this->getSign( $params );

		$params['sign'] = $sign;

		$data = HttpClient::post( $order_url,$params );
		return $this->renderJSON( $data );
	}

	function getSign( $params ){
		ksort($params);
		$buff = "";
		foreach ($params as $k => $v) {
			$buff .= $k . "=" . $v . "&";
		}

		$rep_str = substr($buff, 0, strlen($buff)-1);
		$result_ = strtoupper( md5( $rep_str ) );
		return $result_;
	}

	public function actionJssdk(){
		RequestService::setConfig( $this->appid,$this->token,$this->appkey );
		$access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid.'&secret='.$this->appkey;
		$res = RequestService::send($access_token_url,[]);
		var_dump( $res );
	}

	public function actionCallback(){

		$xml_data = file_get_contents("php://input");
		file_put_contents( "/tmp/mogo_pay.log",$xml_data,FILE_APPEND );
		$xml = <<<EOF
<xml>
   <return_code><![CDATA[SUCCESS]]></return_code>
   <return_msg><![CDATA[OK]]></return_msg>
</xml>
EOF;
		return "success";
	}
}