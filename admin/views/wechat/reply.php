<?php
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
StaticService::includeStaticJs( "/wangeditor/wangEditor.min.js",\admin\assets\AdminAsset::className() );
StaticService::includeAppJsStatic( "/js/wechat/reply.js",\admin\assets\AdminAsset::className());
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
            <div class="box-1">
                <div class="row">
                    <div class="row-in">
                        <h2 class="columns-24 title-1">与 <?=$member_info['nickname'];?> 的聊天</h2>
                        <div class="columns-24">
                            <div class="reply-content">
                                <div class="input-wrap">
                                    <textarea rows="5" class="textarea-1" style="height: auto;"></textarea>
                                </div>
                            </div>
                            <div class="mg-t10">
                                <a href="javascript:void(0);" class="btn-medium">发送</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="columns-24 mg-t20">
			<table class="table-1">
				<thead>
                <tr>
                    <th colspan="4">最新10条新</th>
                </tr>
				<tr>
					<th width="100">头像</th>
					<th width="100">名称</th>
					<th width="50">类型</th>
					<th>内容</th>
				</tr>
				</thead>
				<tbody>
				<?php if($data):?>
					<?php foreach($data as $_item):?>
						<tr>
							<td>
                                <img class="avatar-1" src="<?=$_item['avatar'];?>" />
                            </td>
							<td><?=$_item['nickname'];?> </td>
							<td><?=$_item['type'];?> </td>
							<td><?=$_item['content'];?></td>
						</tr>
					<?php endforeach;?>
				<?php else:?>
					<tr><td colspan="4">此人暂无消息</td></tr>
				<?php endif;?>
				</tbody>
			</table>
		</div>
	</div>
</div>