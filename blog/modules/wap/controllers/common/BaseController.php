<?php
namespace blog\modules\wap\controllers\common;

use blog\components\UrlService;
use blog\components\BaseBlogController;
use common\components\UtilHelper;

class BaseController extends BaseBlogController
{

    protected $allowAllAction = [];

    protected $sns_allow_action = [
        "wap/wechat_wall/index"
    ];

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config = []);
        $view  = \Yii::$app->view;
        $view->params['id'] = $id;
        $this->layout  = "main";
    }

    public function beforeAction($action){
        $this->setTitle();
        $this->setDescription();
        $this->setKeywords();
        $login_status = $this->checkLoginStatus();

        if (!$login_status && !in_array($action->getUniqueId(), $this->allowAllAction)) {
            if( UtilHelper::isWechat() ){
                if(\Yii::$app->request->isAjax){
                    $this->renderJSON([],"未登录,请返回用户中心",-302);
                }else{
                    $type = in_array($action->getUniqueId(),$this->sns_allow_action)?"snsapi_userinfo":"snsapi_base";
                    $redirect_url = UrlService::buildUrl("/weixin/oauth/login",['referer' =>  $this->getLoginUrl(),'type' => $type ]);
                    $this->redirect( $redirect_url );
                }
                return false;
            }


        }
        return true;
    }

    /*
     * @|@ => ?
     * @@ => &
     * */
    protected function getLoginUrl(){
        $refer = \Yii::$app->request->getPathInfo();
        $refer = str_replace("wap/","",$refer);
        if( isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ){
            $refer .= "@|@".str_replace("&","@@",$_SERVER['QUERY_STRING']);
        }
        return UrlService::buildWapUrl("/".urlencode($refer));
    }

    public function setKeywords($keywords = ""){
        $keywords  = $keywords ? $keywords : \Yii::$app->params['seo']['keywords'];
        $this->getView()->params['seo']['keywords'] = $keywords;
    }

    public function setDescription($description = ""){
        $description  = $description ? $description : \Yii::$app->params['seo']['description'];
        $this->getView()->params['seo']['description'] = $description;
    }


    public function goHome(){
        return $this->redirect(UrlService::buildWapUrl("/defaul/index"));
    }

    public function goLibraryHome(){
        return $this->redirect(UrlService::buildWapUrl("/library/index"));
    }
} 