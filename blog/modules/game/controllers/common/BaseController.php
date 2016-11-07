<?php
namespace blog\modules\game\controllers\common;

use blog\components\BaseBlogController;
use blog\components\UrlService;
use common\components\UtilHelper;


class BaseController extends BaseBlogController
{

    protected $allowAllAction = [];

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config = []);
        $view  = \Yii::$app->view;
        $view->params['id'] = $id;
        $this->layout = "main";
    }

    public function beforeAction($action)
    {
        $this->setTitle();
        $this->setSubTitle();
        $this->setDescription();
        $this->setKeywords();

		\Yii::$app->response->getHeaders()->set("Content-Security-Policy",UtilHelper::getCspHeader( YII_ENV) );
        //微信被封了
//        $login_status = $this->checkLoginStatus();
//
//        if (!$login_status && !in_array($action->getUniqueId(), $this->allowAllAction)) {
//            if( UtilHelper::isWechat() ){
//                if(\Yii::$app->request->isAjax){
//                    $this->renderJSON([],"未登录,请返回用户中心",-302);
//                }else{
//                    $redirect_url = UrlService::buildUrl("/weixin/oauth/login",['referer' =>  $this->getLoginUrl() ]);
//                    $this->redirect( $redirect_url );
//                }
//                return false;
//            }
//
//
//        }
		if( !$this->getUUID() ){
			$this->setUUID();
		}
        return true;
    }

    /*
     * @|@ => ?
     * @@ => &
     * */
    protected function getLoginUrl(){
        $refer = \Yii::$app->request->getPathInfo();
        if( isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ){
            $refer .= "@|@".str_replace("&","@@",$_SERVER['QUERY_STRING']);
        }
        return UrlService::buildUrl("/".urlencode($refer));
    }

    public function setTitle($title = "编程浪子的游戏中心"){
        $this->getView()->title = $title;
    }

    public function setSubTitle($title = "编程浪子的游戏中心"){
        $this->getView()->params['subtitle'] = $title;
    }

    public function setKeywords($keywords = "")
    {
        $keywords  = $keywords ? $keywords : \Yii::$app->params['seo']['keywords'];
        $this->getView()->params['seo']['keywords'] = $keywords;
    }

    public function setDescription($description = "")
    {
        $description  = $description ? $description : \Yii::$app->params['seo']['description'];
        $this->getView()->params['seo']['description'] = $description;
    }


    public function goHome()
    {
        return $this->redirect(UrlService::buildWapUrl("/defaul/index"));
    }

    public function goLibraryHome()
    {
        return $this->redirect(UrlService::buildWapUrl("/library/index"));
    }
} 