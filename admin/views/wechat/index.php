<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
?>
<div class="row">
	<div class="row-in">
		<div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/wechat_tab.php", ['current' => 'index']); ?>
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
					<th width="100">名称</th>
					<th width="50">类型</th>
					<th>内容</th>
					<th width="300">原生信息</th>
					<th width="80">操作</th>
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
							<td><?=$_item['type'];?> </td>
							<td><?=$_item['content'];?></td>
							<td>
								<div class="input-wrap">
									<textarea class="textarea-1"><?=$_item['text'];?></textarea>
								</div>

							</td>
                            <td>
                                回复功能
                            </td>
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
				'url' => '/wechat/index',
				'search_conditions' => $search_conditions
			]);?>
		</div>
	</div>
</div>