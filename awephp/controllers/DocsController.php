<?php

namespace awephp\controllers;

use \Michelf\Markdown;
use \Michelf\MarkdownExtra;
use Yii;
use awephp\controllers\common\AuthController;

class DocsController extends AuthController{
    public function actionIndex(){
		$data = file_get_contents( Yii::$app->getBasePath()."/web/markdown/index.md" );
		$my_html = MarkdownExtra::defaultTransform( $data );
        return $this->render("index",[
        	'content' => $my_html
		]);
    }
}