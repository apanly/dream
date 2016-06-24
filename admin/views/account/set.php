<?php
use common\components\DataHelper;
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="defModalHead">添加账号</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="col-md-3  control-label">标题：</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="title" value="<?=$info?DataHelper::encode($info['title']):'';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3  control-label">账号：</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="account" value="<?=$info?DataHelper::encode($info['account']):'';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3  control-label">密码：</label>
							<div class="col-md-9">
								<div class="input-group">
									<input type="text" class="form-control" name="pwd" value="">
									<span class="input-group-btn">
										<button class="btn btn-default gene_pwd" type="button">生成密码!</button>
                                	</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3  control-label">备注：</label>
							<div class="col-md-9">
								<textarea name="description" class="form-control" rows="5"><?=$info?DataHelper::encode($info['description']):'';?></textarea>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
		<div class="modal-footer">
			<input type="hidden" value="<?=$info?$info['id']:0;?>" name="account_id">
			<button type="button" class="btn btn-primary save">保存</button>
		</div>
	</div>
</div>