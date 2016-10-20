<?php
use \admin\components\StaticService;
StaticService::includeAppJsStatic("/js/douban/mz.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
		<?php if( $mz_list ):?>
		<?php foreach( $mz_list as $_mz_info ):?>
            <div class="columns-6">
                <div class="columns-24">
                    <div class="box-2">
                        <div class="avatar-3">
                            <div class="inner" style="height: 347px;width: 240px;overflow:hidden;">
                                <img src="<?=$_mz_info['src_url'];?>" alt="<?=$_mz_info['title'];?>" />
      s                      </div>
                        </div>

                    </div>

                </div>
                <div class="columns-24">
                    <p><?=$_mz_info['title'];?></p>
                </div>
            </div>
			<?php endforeach;?>
		<?php endif;?>
    </div>
</div>
<div class="row">
    <div class="row-in">
        <div class="columns-24 text-right">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/pagination_v1.php",[
				'pages' => $page_info,
				'url' => '/douban/mz',
				'search_conditions' => [],
				'current_page_count' => count($mz_list)
			]);?>
        </div>
    </div>
</div>