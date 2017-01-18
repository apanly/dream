<?php
namespace blog\controllers\common;

use blog\components\UrlService;
use common\components\UtilHelper;
use Yii;
use yii\web\HttpException;
use \yii\helpers\Url;
use blog\components\BaseBlogController;

class BaseController extends BaseBlogController{

    protected $allowAllAction = []; //在这里面的就不用检查合法性
    protected $ignoreRedirectAction = [
        "run/step",
        "error/error",
        "log/add",
        "public/iframe",
        "code/run",
        "demo/login",
        "default/change-log",
        "default/donation",
        "default/about",
        "test/index",
        'default/qrcode',
        'default/barcode',
		'oauth/login',
		'oauth/qq',
		'oauth/github',
		'oauth/weibo',
    ];


    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config = []);
        $view = Yii::$app->view;
        $view->params['id'] = $id;
        $view->params['menu'] = $this->getMenu();
        $view->params['copyright'] = Yii::$app->params['Copyright'];
    }

    public function beforeAction($action)
    {
        $this->setTitle();
        $this->setDescription();
        $this->setKeywords();

		Yii::$app->response->getHeaders()->set("Content-Security-Policy",UtilHelper::getCspHeader( YII_ENV) );

        if (!UtilHelper::isPC()
            && !in_array($action->getUniqueId(), $this->ignoreRedirectAction)
        ) {
            $url = UrlService::buildWapUrl("/" . $action->getUniqueId(), $_GET);
            $this->redirect($url);
            return false;
        }

        if (!in_array($action->getUniqueId(), $this->allowAllAction)) {

        }

		if( !$this->getUUID() ){
			$this->setUUID();
		}

        return true;
    }


    public function goHome()
    {
        return $this->redirect(Url::toRoute(['default/index']));
    }

    public function goLibraryHome()
    {
        return $this->redirect(Url::toRoute(['library/index']));
    }


    public function setTitle($title = ""){
        $title  = $title ? $title." -- ".Yii::$app->params['seo']['title'] : Yii::$app->params['seo']['title'];
        $this->getView()->title = $title;
    }

    public function setKeywords($keywords = ""){
        $keywords  = $keywords ? $keywords : Yii::$app->params['seo']['keywords'];
        $this->getView()->params['seo']['keywords'] = $keywords;
    }

    public function setDescription($description = "")
    {
        $description = $description ? $description : Yii::$app->params['seo']['description'];
        $this->getView()->params['seo']['description'] = $description;
    }


    public function setHeaderTitle($title)
    {
        $view = Yii::$app->view;
        $view->params['header_title'] = $title;

    }

    protected function renderJSON($data = [], $msg = "ok", $code = 200)
    {
        header('Content-type: application/json');
        echo json_encode([
            "code"   => $code,
            "msg"    => $msg,
            "data"   => $data,
            "req_id" => $this->geneReqId(),
        ]);


        return Yii::$app->end();
    }

    protected function renderJSONP($data = [], $msg = "ok", $code = 200)
    {

        $func = $this->get("jsonp", "jsonp_func");

        echo $func . "(" . json_encode([
                "code"   => $code,
                "msg"    => $msg,
                "data"   => $data,
                "req_id" => $this->geneReqId(),
            ]) . ")";

        return Yii::$app->end();
    }

    protected function renderNotFound()
    {
        $this->renderJSON([], $msg = "ObjectNotFound", -1);
    }


    protected function geneReqId()
    {
        return uniqid();
    }

    public function post($key, $default = "")
    {
        return Yii::$app->request->post($key, $default);
    }


    public function get($key, $default = "")
    {
        return Yii::$app->request->get($key, $default);
    }


    public function getMenu()
    {
        $url = \Yii::$app->request->url;

        if (strpos($url, '/about') !== false) return 'about';
        if (strpos($url, '/change-log') !== false) return 'changelog';
        if (strpos($url, '/donation') !== false) return 'donation';
        if (strpos($url, '/library') !== false) return 'library';
        if (strpos($url, '/richmedia') !== false) return 'richmedia';
        return "blog";
    }

}


