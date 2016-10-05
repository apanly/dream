<?php
namespace console\modules\emoticon\controllers;

/*
 * 目前只要gif
 * */
use common\components\HttpClient;
use common\models\emoticon\EmoticonQueue;
use common\service\emoticon\EmoticonService;

class ScrapyController extends   BaseController{
	private $page_size = 50;
	/*
	 * 抓取姐夫网站的图片
	 * */
	public function actionJieFu(  $page = 0 ){
		/*推荐*/
		$url = 'http://api.jiefu.tv/app2/api/dt/item/recommendList.html?pageNum=%s&pageSize=%s';
		$url = sprintf( $url,$page,$this->page_size );
		/*最新*/
		$url = 'http://api.jiefu.tv/app2/api/dt/shareItem/newList.html?pageNum=%s&pageSize=%s';
		$url = sprintf( $url,$page,$this->page_size );
		/*最热*/
		$url = 'http://api.jiefu.tv/app2/api/bq/article/item/hotList.html?pageNum=%s&pageSize=%s';
		$url = sprintf( $url,$page,$this->page_size );

		/*
		 * 集合包
	     * 返回数组中有个 articleId（http://api.jiefu.tv/app2/api/bq/article/detail.html?id=4662）
		*/
		$url = 'http://api.jiefu.tv/app2/api/bq/article/list.html';

	}



	/**
	 * http://www.neihan8.com/gif/
	 * http://www.qqtn.com/bq/dtbq_1.html
	 * http://www.meiniba.com/a/biaoqing/
	 * http://www.18weixin.com/weixinbiaoqing.shtml
	 */

	/**
	 * 每天运行一次就ok了
	 * php yii emoticon/scrapy/weixin18
	 */
	public function actionWeixin18( $page = 1 ){
		$host = 'http://www.18weixin.com';
		$url = $host.'/weixinbiaoqing_%s.shtml';
		$url = sprintf( $url,$page);
		$content = HttpClient::get( $url );
		$content = mb_convert_encoding($content, 'gb2312', 'utf-8');
		$html_dom = new \HtmlParser\ParserDom($content);
		$img_wrap_array = $html_dom->find('div.imgborder_bqimg_width');
		if( !$img_wrap_array ){
			return $this->echoLog("error:no img tag ~~");
		}
		foreach( $img_wrap_array  as $_item ){
			$tmp_target_url = $_item->find("a",0);
			$tmp_target_url = $host.$tmp_target_url->getAttr("href");
			EmoticonService::addQueue([ 'url' => $tmp_target_url,'type' => 2 ]);
		}
		return $this->echoLog("it's over ~~");
	}


	/**
	 * 定时处理队列数据
	 * php yii emoticon/scrapy/pic-url
	 */
	public function actionPicUrl(){

		$list = EmoticonQueue::find()
			->where([ 'status' => -1 ])
			->orderBy([ 'id' => SORT_ASC ])
			->limit( 50 )->all();

		if( !$list ){
			return $this->echoLog('no data need to handle');
		}

		$date_now = date("Y-m-d H:i:s");

		foreach( $list as $_item ){

			$this->echoLog( "queue_id:{$_item['id']}" );
			switch ($_item['type'] ){
				case 1:
					$tmp_ret = EmoticonService::scrapy( $_item );
					break;
				case 2:
					$tmp_ret = EmoticonService::parseImages( $_item );
					break;
				default:
					$tmp_ret = false;
					break;
			}

			if( !$tmp_ret ){
				$this->echoLog( EmoticonService::getLastErrorMsg() );
			}
			$_item->status = $tmp_ret?1:0;
			$_item->updated_time = $date_now;
			$_item->update(0);
		}

		return $this->echoLog("it's over ~~");
	}

}