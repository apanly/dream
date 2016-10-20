<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/stat_tab.php", ['current' => 'error']); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="row-in">
        <form id="search_from">
            <div class="columns-4">
                <div class="select-wrap">
                    <select class="select-1" name="type" onchange="$('#search_from').submit();">
                        <option value="0">请选择应用</option>
                        <?php foreach( $log_type_mapping as $_log_id => $_log_title ):?>
                            <option value="<?=$_log_id;?>" <?php if( $search_conditions['type'] == $_log_id ):?> selected <?php endif;?> ><?=$_log_title;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </form>

    </div>
</div>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
            <table class="table-1">
                <thead>
                <tr>
                    <th width="20">序号</th>
                    <th width="60">app<br/>名称</th>
                    <th width="100">请求URI</th>
                    <th width="150">错误内容</th>
                    <th width="150">UA</th>
                    <th width="80">IP</th>
                    <!--                                    <th>Cookies</th>-->
                    <th width="110">时间</th>
                </tr>
                </thead>
                <tbody>
				<?php if($data):?>
					<?php foreach($data as $_item):?>
                        <tr>
                            <td class="text-center"><?=$_item['idx'];?></td>
                            <td><?=$_item['app_name'];?> </td>
                            <td><?=$_item['request_uri'];?> </td>
                            <td style="width: 200px;"><?=$_item['content'];?> </td>
                            <td><?=$_item['ua'];?> </td>
                            <td><?=$_item['ip'];?> </td>
                            <!--                                        <td>--><?//=$_item['cookies'];?><!-- </td>-->
                            <td><?=$_item['created_time'];?> </td>
                        </tr>
					<?php endforeach;?>
				<?php else:?>
                    <tr><td colspan="7">暂无数据</td></tr>
				<?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="row-in">
        <div class="columns-24 text-right">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/pagination_v1.php",[
				'pages' => $page_info,
				'url' => '/log/error',
				'search_conditions' => $search_conditions,
				'current_page_count' => count($data)
			]);?>
        </div>
    </div>
</div>