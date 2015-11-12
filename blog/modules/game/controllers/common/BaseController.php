<?php
namespace blog\modules\game\controllers\common;

use blog\components\BaseBlogController;
use blog\components\UrlService;


class BaseController extends BaseBlogController
{

    protected $allowAllAction = [
        "game/tools/index"
    ];

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
        if (!in_array($action->getUniqueId(), $this->allowAllAction)) {
            if( !$this->checkLoginStatus() ){
                if(\Yii::$app->request->isAjax){
                    $this->renderJSON([],"未登录,请返回用户中心",-302);
                }else{
                    $redirect_url = UrlService::buildUrl("/weixin/oauth/login",['source' => "game"]);
                    $this->redirect( $redirect_url );
                }
                return false;
            }
        }
        return true;
    }

    public function setTitle($title = "郭大帅哥的游戏中心"){
        $this->getView()->title = $title;
    }

    public function setSubTitle($title = "郭大帅哥的游戏中心"){
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