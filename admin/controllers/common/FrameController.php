<?php
namespace admin\controllers\common;



class FrameController extends BaseController{
    public function actionIndex(){
        return $this->render("index");
    }

}
