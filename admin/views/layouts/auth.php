<?php
use yii\helpers\Html;
use admin\assets\AdminAsset;
use admin\components\AdminUrlService;
use \common\service\GlobalUrlService;

AdminAsset::register($this);
$seo_title = Yii::$app->params['seo']['title'];
$domain_blog = Yii::$app->params['domains']['blog'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<link rel="icon" href="<?= GlobalUrlService::buildStaticUrl("/images/icon.png"); ?>" type="image/x-icon"/>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<?php $this->beginBody() ?>
</head>
<body>
<div class="page_wrap">
	<div class="box_wrap">
        <div class="content_wrap">
			<?php echo $content ?>
        </div>
	</div>
	<div class="footer_wrap">
		<div class="inner">
			Copyright&nbsp;&copy;&nbsp;<?=date("Y");?>&nbsp;&nbsp;
			<a href="<?=$domain_blog;?>" target="_blank"><?= $seo_title;?></a>
		</div>
	</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
