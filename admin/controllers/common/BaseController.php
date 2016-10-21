<?php
namespace admin\controllers\common;

use admin\components\AccessLogService;
use admin\components\AdminUrlService;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\log\FileTarget;
use \yii\helpers\Url;
use common\models\user\Admin;

class BaseController extends Controller{
    public $enableCsrfValidation = false;
	protected  $page_size = 30;
    protected  $salt = "g0ptPkTxZ#mIjD7@";
    protected  $auth_cookie_name = "cool_boy";
    protected  $current_user  ;
    //在这里面的就不用检查合法性
    protected  $allowAllAction = [
        "auth/index",
        "auth/login"
    ];

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config = []);
        $view = Yii::$app->view;
        $view->params['id'] = $id;
        $view->params['copyright'] = Yii::$app->params['Copyright'];
		$this->layout = "v1";
        $this->setTitle();
    }

    public function beforeAction($action) {
    	$login_status = $this->checkLoginStatus();
        if ( !$login_status &&  !in_array($action->getUniqueId(), $this->allowAllAction ) ) {
			if(Yii::$app->request->isAjax){
				$this->renderJSON([],"未登录,请返回用户中心",-302);
			}else{
				$this->redirect( AdminUrlService::buildUrl("/auth/index") );
			}
			return false;
        }

		$view = Yii::$app->view;
		$view->params['current_user'] = $this->current_user;

        $params = [
            'target_type' => 1,
            'target_id' =>  $this->current_user?$this->current_user['uid']:0,
            'act_type' => 2,
            'status' => 1
        ];
        AccessLogService::recordAccess_log( $params );
        return true;
    }

    protected function checkLoginStatus(){
        $request = Yii::$app->request;
        $cookies = $request->cookies;
        $auth_cookie = $cookies->get($this->auth_cookie_name);
        if(!$auth_cookie){
            return false;
        }
        list($authToken,$uid) = explode("#",$auth_cookie);
        if(!$authToken || !$uid){
            return false;
        }
        if($uid && preg_match("/^\d+$/",$uid)){

            $userinfo = Admin::findOne(['uid' => $uid]);
            if(!$userinfo){
                $this->removeAuthToken();
                return false;
            }
            if($authToken != $this->createAuthToken($userinfo['uid'],$userinfo['mobile'],$userinfo['password'],$_SERVER['HTTP_USER_AGENT'])){
                $this->removeAuthToken();
                return false;
            }
            $this->current_user = $userinfo;
            $view = Yii::$app->view;
            $view->params['current_user'] = $userinfo;
            return true;
        }
        return false;
    }

    protected  function createLoginStatus($userinfo){
        $authToken = $this->createAuthToken($userinfo['uid'],$userinfo['mobile'],$userinfo['password'],$_SERVER['HTTP_USER_AGENT']);
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => $this->auth_cookie_name,
            'value' => $authToken."#".$userinfo['uid'],
        ]));
    }

    protected function createAuthToken($uid,$mobile,$password,$user_agent){
        return md5($uid.$mobile.$password.$user_agent);
    }

    protected  function removeAuthToken(){
        $cookies = Yii::$app->response->cookies;
        $cookies->remove($this->auth_cookie_name);
    }


    public function goHome(){
        return $this->redirect(Url::toRoute(['default/index']));
    }


    public function setTitle($title = ""){
        $title  = $title ? $title." -- ".Yii::$app->params['seo']['title'] : Yii::$app->params['seo']['title'];
        $this->getView()->title = $title;
    }


    public function setHeaderTitle($title){
        $view = Yii::$app->view;
        $view->params['header_title'] = $title;
    }

    protected function renderJSON($data=[], $msg ="ok", $code = 200)
    {
        header('Content-type: application/json');
        echo json_encode([
            "code" => $code,
            "msg"   =>  $msg,
            "data"  =>  $data,
            "req_id" =>  $this->geneReqId(),
        ]);


        return Yii::$app->end();
    }

    protected function renderJSONP($data=[], $msg ="ok", $code = 200) {

        $func = $this->get("jsonp","jsonp_func");


        echo $func."(".json_encode([
            "code" => $code,
            "msg"   =>  $msg,
            "data"  =>  $data,
            "req_id" =>  $this->geneReqId(),
        ]).")";

        return Yii::$app->end();
    }

    protected function renderNotFound() {
        $this->renderJSON([],$msg = "ObjectNotFound", -1);
    }

    protected  function renderJS($msg,$url = "/"){
        return $this->renderPartial("/common/js",['msg' => $msg,'location' => $url ]);
    }


    protected function geneReqId() {
        return uniqid();
    }

    public function post($key, $default = "") {
        return Yii::$app->request->post($key, $default);
    }


    public function get($key, $default = "") {
        return Yii::$app->request->get($key, $default);
    }


}

class AdminException extends HttpException {
    protected $code;

    const OK = 'OK';
    const UNKNOWN = 'Unknown';
    const OBJECT_NOT_FOUND = 'ObjectNotFound';
    const METHOD_NOT_ALLOWED = 'MethodNotAllowed';
    const AUTHENTICATION_FAILED = 'AuthenticationFailed';
    const INVALID_INPUT_FORMAT = 'InvalidInputFormat';
    const DATA_CONFLICT = 'DataConflict';
    const QUOTA_NOT_ENOUGH = 'QuotaNotEnough';
    const THIRD_PLATFORM_SERVICE_ERROR = 'ThirdPlatformServiceError';

    static $codeMap = array(
        self::OK => ['200 OK', ''],
        self::OBJECT_NOT_FOUND => ['404 Not Found', 'requested object does not exists'],
        self::METHOD_NOT_ALLOWED => ['405 Method Not Allowed', 'method not allowed'],
        self::UNKNOWN => ['500 Internal Server Error', 'unknown error occurred'],
        self::AUTHENTICATION_FAILED => ['403 Forbidden',' authentication failed'],
        self::INVALID_INPUT_FORMAT=> ['400 Bad Request', 'invalid input format'],
        self::DATA_CONFLICT=> ['409 Conflict', 'data conflict'],
        self::QUOTA_NOT_ENOUGH=> ['403 Forbidden', 'quota not enough'],
        self::THIRD_PLATFORM_SERVICE_ERROR=> ['503 Forbidden', 'third platform service error'],
    );

    function __construct($code, $msg = "") {
        $this->code = $code;
        $this->message = $msg;
    }

    function getOriginsMessage() {
        return $this->message;
    }

    static function objectNotFound($msg = '') {
        return new self(self::OBJECT_NOT_FOUND, $msg);
    }

    static function methodNotAllowed($msg = '') {
        return new self(self::METHOD_NOT_ALLOWED, $msg);
    }

    static function authenticationFailed($msg = '') {
        return new self(self::AUTHENTICATION_FAILED, $msg);
    }

    static function invalidInputFormat($msg = '') {
        return new self(self::INVALID_INPUT_FORMAT, $msg);
    }

    static function dataConflict($msg = '') {
        return new self(self::DATA_CONFLICT, $msg);
    }

    static function quotaNotEnough($msg = '') {
        return new self(self::QUOTA_NOT_ENOUGH, $msg);
    }

    static function thirdPlatformServiceError($msg = '') {
        return new self(self::THIRD_PLATFORM_SERVICE_ERROR, $msg);
    }

    static function getHttpCode($code) {
        return isset(self::$codeMap[$code]) ? self::$codeMap[$code][0] : '400 Bad Request';
    }
}


