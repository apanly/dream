<?php

namespace api\modules\mina\controllers;

use api\modules\mina\controllers\common\BaseMinaController;
use common\models\posts\Posts;
use common\service\GlobalUrlService;
use common\components\UtilHelper;
use common\components\DataHelper;
use common\service\RecommendService;

class ToolsController extends BaseMinaController {
    public function actionIndex(){

    	$list = [
    		[ "title" => "图书扫码", "icon_class" => "fa fa-5x fa-barcode","type" => "page","route" => "/pages/tools/book/scan" ],
    		[ "title" => "图书馆", "icon_class" => "fa fa-5x fa-book","type" => "page","route" => "/pages/tools/book/list" ]
		];

		return $this->renderJSON([
			'tools' => $list
		]);
	}
}
