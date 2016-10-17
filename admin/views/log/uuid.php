<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
?>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading ui-draggable-handle">
					<h3 class="panel-title">UUID统计</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<?php if($data):?>
							<table class="table table-bordered table-striped table-actions">
								<thead>
								<tr>
									<th>序号</th>
									<th>日期</th>
									<th>UUID</th>
									<th>总次数</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach($data as $_item):?>
									<tr>
										<td class="text-center"><?=$_item['idx'];?></td>
										<td><?=$_item['date'];?> </td>
										<td><?=$_item['uuid'];?> </td>
										<td><?=$_item['total_number'];?> </td>
									</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						<?php endif;?>
						<?php echo \Yii::$app->view->renderFile("@admin/views/common/pagination.php",[
							'page_info' => $page_info,
							'url' => '/log/uuid',
							'search_conditions' => $search_conditions,
							'current_page_count' => count( $data )
						]);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>