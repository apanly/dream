<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/wechat_tab.php", ['current' => 'member']); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="row-in">
        <div class="columns-24">
            <table class="table-1">
                <thead>
                <tr>
                    <th width="50">序号</th>
                    <th width="100">头像</th>
                    <th width="200">名称</th>
                    <th width="50">性别</th>
                    <th>地址</th>
                    <th width="300">时间</th>
                </tr>
                </thead>
                <tbody>
				<?php if($data):?>
					<?php foreach($data as $_item):?>
                        <tr>
                            <td><?=$_item['id'];?></td>
                            <td>
                                <img class="avatar-small circle" src="<?=$_item['avatar'];?>" />
                            </td>
                            <td><?=$_item['nickname'];?> </td>
                            <td><?=$_item['sex'];?> </td>
                            <td><?=$_item['country'];?> <?=$_item['province'];?> <?=$_item['city'];?></td>
                            <td><?=$_item['created_time'];?></td>
                        </tr>
					<?php endforeach;?>
				<?php else:?>
                    <tr><td colspan="6">暂无数据</td></tr>
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
				'url' => '/wechat/member',
				'search_conditions' => $search_conditions,
				'current_page_count' => count($data)
			]);?>
        </div>
    </div>
</div>