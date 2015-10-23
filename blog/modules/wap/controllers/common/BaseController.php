<?php
namespace blog\modules\wap\controllers\common;

use blog\components\UrlService;
use common\components\BaseWebController;

class BaseController extends  BaseWebController{

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config = []);
        $view = \Yii::$app->view;
        $view->params['id'] = $id;
        $this->layout = "main";
        $this->setTitle();
    }

    public function goHome(){
        return $this->redirect( UrlService::buildWapUrl("/defaul/index") );
    }

    public function goLibraryHome(){
        return $this->redirect( UrlService::buildWapUrl("/library/index") );
    }
} 