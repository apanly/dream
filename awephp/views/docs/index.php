<?php
use awephp\components\StaticService;
/*fancy*/
StaticService::includeStaticCss("/jquery/fancy/jquery.fancybox.css",\awephp\assets\AppAsset::className());
StaticService::includeStaticJs("/jquery/fancy/jquery.fancybox.pack.js",\awephp\assets\AppAsset::className());


StaticService::includeAppCssStatic( "/css/github-markdown.css",\awephp\assets\AppAsset::className() );
StaticService::includeAppCssStatic( "/css/docs.css",\awephp\assets\AppAsset::className() );


/*prettify*/
StaticService::includeStaticCss("/prettify/prettify.sons.css",\awephp\assets\AppAsset::className());
StaticService::includeStaticJs("/prettify/prettify.js",\awephp\assets\AppAsset::className());

StaticService::includeAppJsStatic( "/js/docs.js",\awephp\assets\AppAsset::className() );
?>
<div class="container-fluid docs">
    <div class="row-fluid">
		<?= Yii::$app->controller->renderPartial("/public/docs_nav"); ?>
        <div class="col-md-9 page">
            <div class="hero-unit markdown-body">
                <?php if( $info['status']  == 1 ):?>
                <?=$content;?>
                <?php else:?>
                    <h1 class="text-center">
                        编辑中，敬请期待~~
                    </h1>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<div class="hide hidden_wrap">
    <input type="hidden" name="doc_id" value="<?=$info?$info['id']:0;?>">
</div>