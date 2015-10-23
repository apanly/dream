<?php
namespace blog\modules\wap\controllers\common;

use blog\components\UrlService;
use common\components\BaseWebController;
use common\components\UtilHelper;

class BaseController extends  BaseWebController{

    protected  $allowAllAction = [];

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config = []);
        $view = \Yii::$app->view;
        $view->params['id'] = $id;
        $this->layout = "main";
    }

    public function beforeAction($action) {
        $this->setTitle();
//        if( UtilHelper::isPC() ){
//            $url_web = str_replace("/wap","",$action->getUniqueId());
//            $params = [];
//            if( isset( $_GET['id'] ) ){
//                $params['id'] = $_GET['id'];
//            }
//            return $this->redirect( UrlService::buildUrl($url_web,$params) );
//        }

        if (!in_array($action->getUniqueId(), $this->allowAllAction )) {

        }
        return true;
    }



    public function goHome(){
        return $this->redirect( UrlService::buildWapUrl("/defaul/index") );
    }

    public function goLibraryHome(){
        return $this->redirect( UrlService::buildWapUrl("/library/index") );
    }
} 