<?php
namespace console\modules\report\controllers;


use common\models\report\ReportAnalyseFiles;

class AnalyseController extends Stat_utilController{
	public function actionRun(){
		$info = ReportAnalyseFiles::find()
			->where([ 'status' => -1 ])
			->orderBy([ 'id' => SORT_ASC ])
			->one();
		if( !$info ){
			return $this->echoLog("no data need to handle");
		}
		switch ( $info['type']  ){
			case 1:
				$this->handleKeyword( $info );
				break;
		}
		return $this->echoLog("it's over");
	}

	private function handleKeyword( $info ){

	}
}