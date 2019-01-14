<?php

namespace blog\modules\market\controllers;

use blog\modules\market\controllers\common\BaseController;
use common\models\soft\SoftNgrok;
use common\service\Constant;


class NgrokController extends BaseController {

	public function actionIndex(){
		$list = SoftNgrok::find()
			->where([ 'member_id' => $this->current_member['id'] ])->asArray()->all( );

    	return $this->render("index",[ 'list' => $list ]);
	}

	public function actionOps(){
		if( !\Yii::$app->request->isPost ){
			return $this->renderJSON( [],Constant::$default_syserror,-1 );
		}

		$id = intval( $this->post( "id",0 ) );
		$prefix_domain = trim( $this->post( "prefix_domain","" ) );
		$prefix_domain = preg_replace('# #','',$prefix_domain );
		if( !$id ){
			return $this->renderJSON( [],Constant::$default_syserror,-1 );
		}

		if( strlen( $prefix_domain ) < 4 ){
			return $this->renderJSON( [],"请输入符合规范的域名前缀,至少4位~~",-1 );
		}

		$ngrok_info = SoftNgrok::findOne([ 'member_id' => $this->current_member['id'],"id" => $id ]);
		if( !$ngrok_info ){
			return $this->renderJSON( [],Constant::$default_syserror,-1 );
		}

		if( $ngrok_info['auth_token'] ){
			return $this->renderJSON( [],"无法设置，因为只能设置一次~~",-1 );
		}

		$has_in = SoftNgrok::find()->where([ 'prefix_domain' => $prefix_domain  ])->andWhere([ '!=','id',$id ])->count();
		if( $has_in ){
			return $this->renderJSON( [] , "该域名前缀已存在，请换一个试试~~" ,-1);
		}
		$config_market = \Yii::$app->params['market'];
		$auth_token = md5( "{$prefix_domain}-{$config_market['salt']}" );
		SoftNgrok::updateAll( [ "prefix_domain" => $prefix_domain,"auth_token" => $auth_token ],[ "id" => $ngrok_info['id']  ] );

		return $this->renderJSON( [] ,"设置成功,请使用域名前缀配置文件~~");
	}
}
