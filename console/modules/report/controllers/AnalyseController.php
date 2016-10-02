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

		switch ( $info['type']  ){
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
		]
	];

	private function handleKeyword( $info ){
		$path = $this->buildFilePath( $info['file_path'] );
		$this->echoLog("ID:{$info['id']},path:{$path}");
		if( $info['type'] == 1 ){//百度的CVS使用UCS-2 little endian编码
			$content = file_get_contents($path);
			$charset = mb_detect_encoding($content, 'UTF-8' );

			if( $charset === false ){
				$content = mb_convert_encoding($content, 'UTF-8', 'UCS-2LE');
				file_put_contents( $path , $content );
			}
		}

		$header_mapping = $this->header_mapping[ $info['type'] ];

		$delimiter = '	';
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
		$filed = array();
		for($i=0; $i<$highestColumnNum;$i++){
			$cellName = PHPExcel_Cell::stringFromColumnIndex($i).'1';
			$cellVal = $sheet->getCell($cellName)->getValue();//取得列内容
			if( !$cellVal ){
				break;
			}
			$usefullColumnNum = $i;
			$filed []= $cellVal;
		}

		if( $highestRowNum < 2 ){
			return false;
		}

		//开始取出数据并存入数组
		$data = [];
		for( $i=2; $i <= $highestRowNum ;$i++ ){//ignore row 1
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
			unset( $_item['click_ratio'] );
			unset( $_item['rank'] );
			$_item['date'] = $info['date'];
			$_item['type'] = $info['type'];
			$this->saveDailyKeyword( $_item );
		}

		return true;
	}
}