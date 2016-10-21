<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
use common\components\DataHelper;
StaticService::includeAppJsStatic("/js/account/set.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/account_tab.php", ['current' => 'set']); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="row-in">
        <div class="columns-14 offset-5" id="set_account_wrap">
            <div class="columns-5 text-right">
                <label class="label-name inline"><i class="mark">*</i>标题：</label>
            </div>
            <div class="columns-19">
                <div class="input-wrap">
                    <input type="text" class="input-1" name="title" value="<?=$info?DataHelper::encode($info['title']):'';?>"/>
                </div>
            </div>
            <div class="columns-5 text-right">
                <label class="label-name inline"><i class="mark">*</i>账号：</label>
            </div>
            <div class="columns-19">
                <div class="input-wrap">
                    <input type="text" class="input-1" name="account" value="<?=$info?DataHelper::encode($info['account']):'';?>"/>
                </div>
            </div>
            <div class="columns-5 text-right">
                <label class="label-name inline"><i class="mark">*</i>密码：</label>
            </div>
            <div class="columns-15">
                <div class="input-wrap">
                    <input type="text" class="input-1" name="pwd" value="<?=$info?DataHelper::encode($info['pwd']):'';?>"/>
                </div>
            </div>
            <div class="columns-4">
                <button class="btn-small gene_pwd" type="button">生成密码!</button>
            </div>
            <div class="columns-5 text-right">
                <label class="label-name inline"><i class="mark">*</i>备注：</label>
            </div>
            <div class="columns-19">
                <div class="input-wrap">
                    <textarea name="description" class="textarea-1" rows="5"><?=$info?DataHelper::encode($info['description']):'';?></textarea>
                </div>
            </div>
            <div class="columns-4 offset-5">
                <input type="hidden" name="account_id" value="<?=$info?$info['id']:0;?>">
                <button class="btn-small save" type="button">保存</button>
            </div>
        </div>
    </div>
</div>