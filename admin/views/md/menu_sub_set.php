<?php
use \admin\components\StaticService;
use \common\components\DataHelper;
?>
<script type="text/javascript" src="<?=StaticService::buildStaticUrl("/js/md/menu_sub_set.js");?>"> </script>
<div class="box-2 pop_menu_sub_set">
	<div class="row">
		<div class="row-in  mg-t15">
			<div class="columns-24">
				<div class="columns-5 right">
					<label class="label-name">一级菜单：</label>
				</div>
				<div class="columns-15">
                    <label class="label-name"><?=DataHelper::encode($parent_info['title']);?></label>
				</div>
			</div>
            <div class="columns-24">
                <div class="columns-5 right">
                    <label class="label-name">选择教程：</label>
                </div>
                <div class="columns-15">
                    <select class="select-1" name="doc_id">
                        <option value="0">请选择</option>
                        <?php if( $docs_list ):?>
                            <?php foreach( $docs_list as $_doc_info ):?>
                                <option value="<?=$_doc_info['id'];?>" <?php if( $info && $info['doc_id'] == $_doc_info['id']):?> selected <?php endif;?> ><?=DataHelper::encode( $_doc_info['title'] );?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
            </div>
            <div class="columns-24">
                <div class="columns-5 right">
                    <label class="label-name">权重：</label>
                </div>
                <div class="columns-15">
                    <div class="input-wrap">
                        <input type="text" class="input-1" placeholder="请输入权重" name="weight" value="1">
                    </div>
                </div>
            </div>
			<div class="columns-19 offset-5">
                <input type="hidden" name="id" value="<?=$info?$info['id']:0;?>">
                <input type="hidden" name="parent_id" value="<?=$parent_info?$parent_info['id']:0;?>">
				<button type="button" class="btn-small save">确定</button>
			</div>
		</div>
	</div>
</div>