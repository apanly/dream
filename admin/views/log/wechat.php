<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
?>
<div class="row">
	<div class="row-in">
		<div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/stat_tab.php", ['current' => 'wechat']); ?>
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
					<th width="200">Openid</th>
					<th width="50">类型</th>
					<th>内容</th>
					<th width="300">原生信息</th>
				</tr>
				</thead>
				<tbody>
				<?php if($data):?>
					<?php foreach($data as $_item):?>
						<tr class="centered">
							<td><?=$_item['id'];?></td>
							<td><?=$_item['openid'];?> </td>
							<td><?=$_item['type'];?> </td>
							<td><?=$_item['content'];?></td>
							<td>
								<div class="input-wrap">
									<textarea class="textarea-1"><?=$_item['text'];?></textarea>
								</div>

							</td>
						</tr>
					<?php endforeach;?>
				<?php else:?>
					<tr><td colspan="5">暂无数据</td></tr>
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
				'url' => '/log/wechat',
				'search_conditions' => $search_conditions,
				'current_page_count' => count($data)
			]);?>
		</div>
	</div>
</div>