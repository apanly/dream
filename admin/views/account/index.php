<?php
use \admin\components\AdminUrlService;
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/account_tab.php", ['current' => 'index']); ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="row-in">
		<div class="columns-24">
			<table class="table-1">
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
						<tr class="centered">
							<td><?=$_item['idx'];?></td>
							<td><?=$_item['title'];?></td>
							<td><?=$_item['account'];?></td>
							<td><?=$_item['pwd'];?></td>
							<td><?=$_item['description'];?></td>
							<td>
								<a href="<?=AdminUrlService::buildUrl("/account/set",[ 'account_id' => $_item['id']  ]);?>" class="edit">
									<i class="icon_club">&#xe610;</i>
								</a>
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