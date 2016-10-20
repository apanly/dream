<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
StaticService::includeAppJsStatic("/js/account/index.js",\admin\assets\AdminAsset::className());
?>
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
								<a href="javascript:void(0);" class="edit" data="<?=$_item['id'];?>">
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