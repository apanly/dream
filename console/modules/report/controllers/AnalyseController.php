<?php
namespace console\modules\report\controllers;


use common\models\report\ReportAnalyseFiles;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
use PHPExcel_RichText;

class AnalyseController extends Stat_utilController{
	/*
	 * php yii report/analyse/run
	 * */
	public function actionRun(){
		$info = ReportAnalyseFiles::find()
			->where([ 'status' => -1 ])
			->orderBy([ 'id' => SORT_ASC ])
			->one();

		if( !$info ){
			return $this->echoLog("no data need to handle");
		}

		$ret = false;

		switch ( $info['action']  ){
			case 1:
				$ret = $this->handleKeyword( $info );
				break;
		}

		$info->status = $ret?1:0;
		$info->updated_time = date("Y-m-d H:i:s");
		$info->update(0);
		return $this->echoLog("it's over");
	}


	private $header_mapping = [
		1 => [
			'关键词' => 'word',
			'点击量' => 'click_number',
			'展现量' => 'display_number',
			'点击率' => 'click_ratio',
			'排名' => 'rank'
		],
		2 => [
			'搜索词' => 'word',
			'来访次数' => 'click_number',
			'百度' => 'click_bd',
			'360搜索' => 'click_360',
			'搜狗' => 'click_sogou',
			'谷歌' => 'click_google',
			'其它' => 'other',
		]
	];

	private function handleKeyword( $info ){
		$path = $this->buildFilePath( $info['file_path'] );
		$this->echoLog("ID:{$info['id']},path:{$path}");

		//百度的CVS使用UCS-2 little endian编码
		//umeng是utf-8
		switch ( $info['type'] ){
			case 1:
				$content = file_get_contents($path);
				$charset = mb_detect_encoding($content, 'UTF-8' );
				if( $charset === false ){
					$content = mb_convert_encoding($content, 'UTF-8', 'UCS-2LE');
					file_put_contents( $path , $content );
				}
				break;
		}


		$header_mapping = $this->header_mapping[ $info['type'] ];

		$delimiter = '	';
		if( $info['type'] == 2 ){
			$delimiter = ",";
		}
		$objReader = PHPExcel_IOFactory::createReader('CSV')
			->setDelimiter($delimiter)
			->setEnclosure('"')
			->setLineEnding("\r\n")
			->setSheetIndex(0);
		$objPHPExcel = $objReader->load($path);
		//选择标签页

		$sheet = $objPHPExcel->getSheet(0);

		//获取行数与列数,注意列数需要转换
		$highestRowNum = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnNum = PHPExcel_Cell::columnIndexFromString($highestColumn);
		$usefullColumnNum = $highestColumnNum;

		//取得字段，这里测试表格中的第一行为数据的字段，因此先取出用来作后面数组的键名
		$header_line_number = 1;
		if( $info['type'] == 2 ){
			$header_line_number = 5;
			$highestRowNum -= 2;
		}

		$filed = array();
		for($i = 0; $i < $highestColumnNum;$i++){
			$cellName = PHPExcel_Cell::stringFromColumnIndex($i).$header_line_number;
			$cellVal = $sheet->getCell($cellName)->getValue();//取得列内容
			if( !$cellVal ){
				break;
			}
			$usefullColumnNum = $i;
			$cellVal = trim($cellVal);
			$filed []= $cellVal;
		}


		if( $highestRowNum < ($header_line_number+1) ){
			return $this->echoLog("path:{$path} no data");
		}

		//开始取出数据并存入数组
		$data = [];
		for( $i = ($header_line_number+1); $i <= $highestRowNum ;$i++ ){//ignore header row(before)
			$row = array();
			for( $j = 0; $j <= $usefullColumnNum;$j++ ){
				if( !isset($header_mapping[ $filed[$j] ]) ){
					continue;
				}
				$cellName = PHPExcel_Cell::stringFromColumnIndex($j).$i;
				$cellVal = $sheet->getCell($cellName)->getValue();
				if($cellVal instanceof PHPExcel_RichText){ //富文本转换字符串
					$cellVal = $cellVal->__toString();
				}

				$fd = $header_mapping[ $filed[$j] ];
				$row[ $fd ] = $cellVal;
			}
			$data []= $row;
		}


		foreach( $data as $_item ){
			$_item['params'] = json_encode( $_item );
			$_item['date'] = $info['date'];
			$_item['type'] = $info['type'];

			if( $info['type'] == 1 ){
				unset( $_item['click_ratio'] );
				unset( $_item['rank'] );
			}else if( $info['type'] == 2 ) {
				if( $_item['word'] == '总计' ){
					continue;
				}
				unset( $_item['click_bd'] );
				unset( $_item['click_360'] );
				unset( $_item['click_sogou'] );
				unset( $_item['click_google'] );
				unset( $_item['other'] );
			}
			$this->saveDailyKeyword( $_item );
		}

		return true;
	}
}