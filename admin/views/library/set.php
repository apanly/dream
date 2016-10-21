<?php
use \admin\components\StaticService;
?>
<script src="<?=StaticService::buildStaticUrl("/js/library/set.js");?>"></script>
<div class="row mg-t15">
	<div class="row-in">
		<div class="columns-6 text-right">
			<label class="label-name inline"><i class="mark">*</i>读书状态：</label>
		</div>
		<div class="columns-18">
			<div class="select-wrap">
				<select class="select-1" id="read_status">
					<?php foreach($read_status as $_idx => $_item):?>
						<option value="<?=$_idx;?>"><?=$_item["desc"];?></option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="columns-6 read_start text-right">
			<label class="label-name inline"><i class="mark">*</i>计划开始时间：</label>
		</div>
		<div class="columns-18 read_start">
			<div class="input-wrap">
				<input type="text" class="input-1 datepicker"  name="read_start_time" value="<?=date("Y-m-d");?>">
			</div>
		</div>
		<div class="columns-6 read_end text-right">
			<label class="label-name inline"><i class="mark">*</i>计划结束时间：</label>
		</div>
		<div class="columns-18 read_end">
			<div class="input-wrap">
				<input type="text" class="input-1 datepicker"  name="read_end_time" value="<?=date("Y-m-d");?>">
			</div>
		</div>
        <div class="columns-18 offset-6">
            <input type="hidden" name="book_id" value="<?=$info['id'];?>">
            <button type="button" class="btn-small save">保存</button>
        </div>
	</div>

</div>