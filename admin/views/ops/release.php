<?php
use \admin\components\StaticService;
?>
<div class="box-2 release_wrap">
	<div class="row">
		<div class="row-in">
			<div class="columns-24">
				<div class="columns-5 right">
					<label class="label-name">仓库：</label>
				</div>
				<div class="columns-6">
					<select class="select-1" name="repo">
						<option value="0">请选择仓库</option>
						<?php if( $repo_mapping ):?>
							<?php foreach ( $repo_mapping as $_key => $_info ):?>
								<option value="<?=$_key;?>" <?php if( count($repo_mapping) == 1 ):?> selected <?php endif;?> ><?=$_info['title'];?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
				</div>
			</div>
			<div class="columns-24">
				<div class="columns-5 right">
					<label class="label-name">备注：</label>
				</div>
				<div class="columns-19">
					<div class="input-wrap">
						<textarea class="textarea-1" name="note" placeholder="请填写备注" rows="4"></textarea>
					</div>
				</div>
			</div>
			<div class="columns-19 offset-5 mg-t15">
				<button type="button" class="btn-small save">确定</button>
			</div>
		</div>
	</div>
</div>
<script src="<?=StaticService::buildStaticUrl("/js/ops/release.js");?>"></script>