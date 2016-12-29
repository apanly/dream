<?php
namespace awephp\controllers\common;

class AuthController  extends \common\components\BaseWebController{
    protected  $allowAllAction = [];//在这里面的就不用检查合法性

    public function beforeAction($action) {
    	$this->setTitle("Awe PHP - 只想用心写教程");

        if (!in_array($action->getUniqueId(), $this->allowAllAction )) {

        }
        return true;
    }


	public function setTitle($title = ""){
		$this->getView()->title = $title;
	}
}