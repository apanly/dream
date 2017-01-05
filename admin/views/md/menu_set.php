<?php
use \admin\components\StaticService;
?>
<script type="text/javascript" src="<?=StaticService::buildStaticUrl("/js/md/menu_set.js");?>"> </script>
<div class="box-2 pop_menu_set">
	<div class="row">
		<div class="row-in  mg-t15">
			<div class="columns-24">
				<div class="columns-5 right">
					<label class="label-name">菜单名称：</label>
				</div>
				<div class="columns-15">
					<div class="input-wrap">
						<input type="text" class="input-1" placeholder="请输入菜单名称" name="title" value="<?=$info?$info['title']:'';?>">
					</div>
				</div>
			</div>
            <div class="columns-24">
                <div class="columns-5 right">
                    <label class="label-name">权重：</label>
                </div>
                <div class="columns-15">
                    <div class="input-wrap">
                        <input type="text" class="input-1" placeholder="请输入权重" name="weight" value="<?=$info?$info['weight']:1;?>">
                    </div>
                </div>
            </div>
			<div class="columns-19 offset-5">
                <input type="hidden" name="id" value="<?=$info?$info['id']:0;?>">
				<button type="button" class="btn-small save">确定</button>
			</div>
		</div>
	</div>
</div>