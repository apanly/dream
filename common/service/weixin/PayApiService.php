<?php


namespace common\service\weixin;

use common\components\HttpClient;
use common\service\AppLogService;
use Yii;
use yii\log\FileTarget;

class PayApiService {
	private $params = [];
	private $wxpay_params = [];
	private $prepay_id = null;
	public  $prepay_info = null;

	public function __construct( $wxpay_params ){
		$this->wxpay_params = $wxpay_params;
	}

	public function setWxpay_params ( $wxpay_params ){
		$this->wxpay_params = $wxpay_params;
	}

	function setParameter($parameter, $parameterValue){
		$this->params[$parameter] = $parameterValue;
	}

	public function getPrepayInfo(){
		$url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
		$this->params["nonce_str"] = $this->createNoncestr();//随机字符串
		$this->params["sign"] = $this->getSign($this->params);//签名
		$xml_data = $this->arrayToXml($this->params);
		$ret = HttpClient::post($url,$xml_data);
		if( $ret ){
			$wx_order = $this->xmlToArray($ret);
			$this->prepay_info = $wx_order;
			$this->record_xml( var_export($wx_order,true) );
			if(isset($wx_order['result_code']) && $wx_order['result_code'] == 'SUCCESS'){
				return $wx_order;
			}else{
				$backtrace = json_encode( debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ) );
				$error_msg = "[wechat unifiedorder] debug:{$backtrace},xml_data:{$xml_data},return:".json_encode($wx_order);
				ApplogService::addErrorLog( Yii::$app->id,$url, $error_msg );
				return false;
			}
		}
		return false;
	}


	function setPrepayId($prepay_id){
		$this->prepay_id = $prepay_id;
	}

	/*查询订单信息*/
	public function order_query(){
		$ret = [
			'status' => false,
			'data' => ''
		];

		$url = "https://api.mch.weixin.qq.com/pay/orderquery";
		$this->params["nonce_str"] = $this->createNoncestr();//随机字符串
		$this->params["sign"] = $this->getSign($this->params);//签名
		$xml_data = $this->arrayToXml($this->params);
		$res = HttpClient::post($url,$xml_data);
		if( $res ){
			$wx_order = $this->xmlToArray( $res );
			if($wx_order['return_code'] == 'SUCCESS'){
				$ret['status']  = true;
			}
			$ret['data'] = $res;
		}
		return $ret;
	}

	public function refund( ){
		$ret = [
			'status' => false,
			'data' => ''
		];
		$root_path = dirname(Yii::$app->vendorPath).'/saas/components/wxpay/cert/';
		$url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
		$this->params["nonce_str"] = $this->createNoncestr();//随机字符串
		$this->params["sign"] = $this->getSign($this->params);//签名
		$xml_data = $this->arrayToXml($this->params);
		$extra = [];
		$extra['SSLCERTTYPE'] = $root_path.'apiclient_cert.pem';
		$extra['CURLOPT_SSLKEYTYPE'] = $root_path.'apiclient_key.pem';
		$res = HttpClient::post($url,$xml_data,$extra);
		if( $res ){
			$wx_order = $this->xmlToArray( $res );
			if($wx_order['return_code'] == 'SUCCESS'){
				$ret['status']  = true;
			}
			$ret['data'] = $res;
		}
		return $ret;
	}

	/*查询退款信息*/
	public function refund_query(){
		$ret = [
			'status' => false,
			'data' => ''
		];

		$url = "https://api.mch.weixin.qq.com/pay/orderquery";
		$this->params["nonce_str"] = $this->createNoncestr();//随机字符串
		$this->params["sign"] = $this->getSign($this->params);//签名
		$xml_data = $this->arrayToXml($this->params);
		$res = HttpClient::post($url,$xml_data);
		if( $res ){
			$wx_order = $this->xmlToArray( $res );
			if($wx_order['return_code'] == 'SUCCESS'){
				$ret['status']  = true;
			}
			$ret['data'] = $res;
		}
		return $ret;
	}

	public function getSignParams(){
		$this->params["nonce_str"] = $this->createNoncestr();//随机字符串
		$this->params["sign"] = $this->getSign($this->params);//签名
		return $this->params;
	}
	private function createNoncestr( $length = 32 ){
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		}
		return $str;
	}

	/**
	 *  作用：生成签名
	 */
	private function getSign($Obj){
		foreach ($Obj as $k => $v){
			$Parameters[$k] = $v;
		}
		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String."&key=".$this->wxpay_params['pay']['key'];
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	function checkSign($sign)
	{
		$tmpData = $this->params;
		$wxpay_sign = $this->getSign($tmpData);//本地签名

		if ($wxpay_sign == $sign) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 *  作用：格式化参数，签名过程需要使用
	 */
	private function formatBizQueryParaMap($paraMap, $urlencode){
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v){
			if($urlencode){
				$v = urlencode($v);
			}
			//$buff .= strtolower($k) . "=" . $v . "&";
			$buff .= $k . "=" . $v . "&";
		}
		$reqPar = '';
		if (strlen($buff) > 0){
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}
	/**
	 *  作用：设置jsapi的参数
	 */
	public function getParameters(){
		$jsApiObj["appId"] = $this->wxpay_params['appid'];
		$timeStamp = time();
		$jsApiObj["timeStamp"] = $timeStamp;
		$jsApiObj["nonceStr"] = $this->createNoncestr();
		$jsApiObj["package"] = "prepay_id=".$this->prepay_id;
		$jsApiObj["signType"] = "MD5";
		$jsApiObj["paySign"] = $this->getSign($jsApiObj);
		return $jsApiObj;
	}
	/**
	 *  作用：array转xml
	 */
	public function arrayToXml($arr){
		$xml = "<xml>";
		foreach ($arr as $key=>$val){
			if (is_numeric($val)){
				$xml.="<".$key.">".$val."</".$key.">";

			}else{
				$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
			}
		}
		$xml.="</xml>";
		return $xml;
	}

	/**
	 *  作用：将xml转为array
	 */
	public function xmlToArray($xml){
		//将XML转为array
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	private function record_xml($xml){
		$log = new FileTarget();
		$log->logFile = Yii::$app->getRuntimePath() . "/logs/wxpay_sign_".date("Ymd").".log";
		$log->messages[] = [
			"[url:{$_SERVER['REQUEST_URI']}],[xml data:{$xml}]",
			1,
			'application',
			time()
		];
		$log->export();
	}
}