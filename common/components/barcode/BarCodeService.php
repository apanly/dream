<?php
namespace common\components\barcode;
require_once dirname(\Yii::$app->vendorPath).'/common/components/barcode/class/BCGFontFile.php';
require_once dirname(\Yii::$app->vendorPath).'/common/components/barcode/class/BCGColor.php';
require_once dirname(\Yii::$app->vendorPath).'/common/components/barcode/class/BCGDrawing.php';
require_once dirname(\Yii::$app->vendorPath).'/common/components/barcode/class/BCGcode39.barcode.php';
require_once dirname(\Yii::$app->vendorPath).'/common/components/barcode/class/BCGean13.barcode.php';
require_once dirname(\Yii::$app->vendorPath).'/common/components/barcode/class/BCGisbn.barcode.php';

use \BCGFontFile;
use \BCGColor;
use \BCGDrawing;
use \BCGcode39;
use \BCGean13;
use \BCGisbn;
use \Exception;


use common\service\BaseService;



class BarCodeService extends BaseService{
	public static function create( $str ,$class = 'BCGcode39' ){
		// 加载字体大小
		$font_path =  dirname(\Yii::$app->vendorPath).'/common/components/barcode/font/Arial.ttf';
		$font = new BCGFontFile($font_path, 18);
		//颜色条形码
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255);
		$drawException = null;
		$code = null;
		try {
			$code = new $class();
			$code->setScale(2);
			$code->setThickness(30); // 条形码的厚度
			$code->setForegroundColor($color_black); // 条形码颜色
			$code->setBackgroundColor($color_white); // 空白间隙颜色
			$code->setFont($font); //
			$code->parse( $str ); // 条形码需要的数据内容
		} catch(Exception $exception) {
			$drawException = $exception;
		}

		//根据以上条件绘制条形码
		$drawing = new BCGDrawing('', $color_white);
		if($drawException) {
			$drawing->drawException($drawException);
		} else {
			$drawing->setBarcode( $code );
			$drawing->draw();
		}

		// 生成PNG格式的图片
		header('Content-Type: image/png');
		$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	}
}

?>