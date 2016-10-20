<?php
namespace admin\controllers\common;



class FrameController extends BaseController{
    public function actionIndex(){
		$this->layout = 'v1';
        return $this->render("index");
    }

}
