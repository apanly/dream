<?php

namespace awephp\controllers;

use common\models\awephp\AweDocs;
use common\service\GlobalUrlService;
use \Michelf\Markdown;
use \Michelf\MarkdownExtra;
use Yii;
use awephp\controllers\common\AuthController;

class DocsController extends AuthController{
    public function actionInfo(  ){
		$id = intval( $this->get("id",1 ) );
		$info = AweDocs::find()->where([ 'id' => $id,'status' => [ 1,-1]  ])->one();
		if( !$info ){
			return $this->redirect( GlobalUrlService::buildPhpUrl("/") );
		}
		$my_html = MarkdownExtra::defaultTransform( $info['content'] );
		//代码进行渲染显示
		$my_html = str_replace( "<pre>","<pre class='prettyprint linenums '>",$my_html );
        return $this->render("index",[
        	'content' => $my_html,
			'info' => $info
		]);
    }
}