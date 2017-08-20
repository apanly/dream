<?php
namespace blog\modules\market\controllers\common;

use blog\components\BaseBlogController;


class BaseController extends BaseBlogController{

    protected $allowAllAction = [];

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config = []);
        $view  = \Yii::$app->view;
        $view->params['id'] = $id;
        $this->layout = "main";
        $this->setTitle();
        $this->setDescription();
    }


	public function setTitle($title = "浪子的杂货店"){
		$this->getView()->title = $title;
	}


	public function setDescription($description = ""){
		$description  = $description ? $description : \Yii::$app->params['seo']['description'];
		$this->getView()->params['seo']['description'] = $description;
	}
} 