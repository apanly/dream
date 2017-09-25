<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \common\service\GlobalUrlService;

StaticService::includeAppCssStatic("components/jquery_tags_input/jquery.tagsinput.min.css",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/components/jquery_tags_input/jquery.tagsinput.min.js",\admin\assets\AdminAsset::className());

StaticService::includeAppJsStatic("/ueditor/ueditor.config.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/ueditor/ueditor.all.min.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/ueditor/lang/zh-cn/zh-cn.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/soft/set.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/soft_tab.php", ['current' => 'set']); ?>
        </div>
    </div>
</div>
<div class="row" id="soft_set_wrap">
    <div class="row-in">
        <div class="columns-18">
            <div class="row">
                <div class="row-in">
                    <div class="columns-3 text-right">
                        <label class="label-name inline"><i class="mark">*</i>标题</label>
                    </div>
                    <div class="columns-21">
                        <div class="input-wrap">
                            <input type="text" class="input-1" name="title" value="<?=$info?$info['title']:'';?>"/>
                        </div>
                    </div>
                    <div class="columns-3 text-right">
                        <label class="label-name inline"><i class="mark">*</i>内容</label>
                    </div>
                    <div class="columns-21">
                        <div class="box-c1 bg-gray">
                            <textarea  id="editor" name="content" style="height: 300px;"><?=$info?$info['content']:'';?></textarea>
                        </div>
                    </div>
                    <div class="columns-3 text-right">
                        <label class="label-name inline"><i class="mark">*</i>下载地址</label>
                    </div>
                    <div class="columns-21">
                        <div class="input-wrap">
                            <input type="text" class="input-1" name="down_url" value="<?=$info?$info['down_url']:'';?>"/>
                        </div>
                    </div>
                    <div class="columns-3 text-right">
                        <label class="label-name inline">促销</label>
                    </div>
                    <div class="columns-21">
                        <div class="row">
                            <div class="row-in">
                                <div class="columns-4">
                                    <select name="need_buy" class="select-1">
                                        <option value="0">不付费</option>
                                        <option <?php if( $info['need_buy'] ):?> selected <?php endif;?>  value="1">付费</option>
                                    </select>
                                </div>
                                <div class="columns-10">
                                    <div class="input-wrap">
                                        <input type="text" class="input-1"  name="price" placeholder="请输入购买价格~~" value="<?=( $info['price'] > 0 )? intval( $info['price'] ):'';?>">
                                    </div>
                                </div>
                                <div class="columns-10">
                                    <div class="input-wrap">
                                        <input type="text" class="input-1" name="free_number" placeholder="请输入免费额度~~" value="<?=( $info['free_number'] > 0 ) ?$info['free_number']:'';?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns-3 hide">
                        <button type="button" class="btn-tiny mg-b0 get_tags">获取tags</button>
                    </div>
                    <div class="columns-3 text-right hide">
                        <label class="label-name inline"><i class="mark">*</i>标签</label>
                    </div>
                    <div class="columns-18 hide">
                        <div class="input-wrap">
                            <input type="text" class="input-1" name="tags" value="<?=$info?$info['tags']:'';?>"/>
                        </div>
                    </div>
                    <div class="columns-3 hide">
                        <button type="button" class="btn-tiny mg-b0 get_tags">获取tags</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns-6">
            <div class="row">
                <div class="row-in">
                    <div class="columns-8 text-right">
                        <label class="label-name inline"><i class="mark">*</i>类型</label>
                    </div>
                    <div class="columns-16">
                        <div class="select-wrap">
                            <select name="type" id="type" class="select-1">
								<?php foreach($posts_type as $_key => $_type):?>
                                    <option value="<?=$_key;?>" <?php if($info && $_key == $info['type']):?> selected <?php endif;?> ><?=$_type;?></option>
								<?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="columns-8 text-right">
                        <label class="label-name inline"><i class="mark">*</i>状态</label>
                    </div>
                    <div class="columns-16">
                        <div class="select-wrap">
                            <select name="status" id="status" class="select-1">
								<?php foreach( $status_desc as $_key => $_item):?>
                                    <option value="<?=$_key;?>"  <?php if($info && $_key == $info['status']):?> selected <?php endif;?> ><?=$_item["desc"];?></option>
								<?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="columns-16 offset-8">
                        <input type="hidden" name="soft_id" value="<?=$info?$info['id']:0;?>">
                        <input type="button" value="保存" class="btn-small save">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
