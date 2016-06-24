<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
StaticService::includeAppJsStatic("/js/account/index.js",\admin\assets\AppAsset::className());
?>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading ui-draggable-handle">
					<h3 class="panel-title">账号列表</h3>
					<ul class="panel-controls">
						<li><a href="javascript:void(0);" class="add"><span class="fa fa-edit"></span></a></li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover no-footer" role="grid">
							<thead>
								<tr>
									<th>序号</th>
									<th>标题</th>
									<th>账号</th>
									<th>通行证</th>
									<th>备注</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php if( $list ):?>
								<?php foreach( $list as $_item):?>
								<tr>
									<td><?=$_item['idx'];?></td>
									<td><?=$_item['title'];?></td>
									<td><?=$_item['account'];?></td>
									<td><?=$_item['pwd'];?></td>
									<td><?=$_item['description'];?></td>
									<td>
										<a href="javascript:void(0);" class="edit" data="<?=$_item['id'];?>"><span class="fa fa-edit"></span></a>
									</td>
								</tr>
								<?php endforeach;?>
							<?php else:?>
								<tr><td colspan="6">暂无</td></tr>
							<?php endif;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="set_account_wrap" role="dialog"  aria-hidden="true" style="display: none;">
</div>