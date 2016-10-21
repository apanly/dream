<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/library_tab.php", ['current' => 'index']); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="row-in">
        <div class="columns-24 centered">
            <h1><?=$info["title"];?></h1>
            <h3>出版时间：<?=$info["publish_date"];?></h3>
            <h3>作者：<?=$info['author'];?></h3>
        </div>
        <div class="columns-24 centered">
            <img src="<?=$info["image_url"];?>" class="qr-1">
        </div>
        <div class="columns-24">
			<?=$info["summary"];?>
        </div>
        <div class="columns-24 mg-t15">
            <h3>Tags：</h3>
			<?php foreach($info['tags'] as $_tag):?>
				<?=$_tag;?>
			<?php endforeach;?>
        </div>
    </div>
</div>
