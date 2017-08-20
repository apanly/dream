<?php
namespace blog\modules\market\controllers\common;

use blog\components\BaseBlogController;


class BaseController extends BaseBlogController{

    protected $allowAllAction = [
		"market/default/index",
		"market/default/info",
		"market/default/mina",
	];


    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config = []);
        $view  = \Yii::$app->view;
        $view->params['id'] = $id;
        $this->layout = "main";
        $this->setTitle();
        $this->setDescription();
    }

	public function beforeAction($action){
		$login_status = $this->checkMemberLoginStatus();
		if ( in_array($action->getUniqueId(), $this->allowAllAction ) ) {
			return true;
		}

		if( !$login_status ){
			if( \Yii::$app->request->isAjax ){
				$this->renderJSON([],"未登录,系统将引导您重新登录~~",-302);
			}
			return false;
		}
		return true;

	}


	public function setTitle($title = "浪子的杂货店"){
		$this->getView()->title = $title;
	}


	public function setDescription($description = ""){
		$description  = $description ? $description : \Yii::$app->params['seo']['description'];
		$this->getView()->params['seo']['description'] = $description;
	}
} 