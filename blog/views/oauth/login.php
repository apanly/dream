<?php
use \blog\components\UrlService;
use \common\components\DataHelper;
?>
<main class="col-md-12 main-content">
	<article class="post page">
		<header class="post-head">
			<h1 class="post-title">第三方登录</h1>
		</header>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-4 col-md-offset-2">
				<?php if( $error_msg ):?>
                    <h3 class="text-danger"><?=$error_msg;?></h3>
				<?php endif;?>
				<?php if( $user_info ):?>
                    <h3>登录成功</h3>
                    <?php if( $type ):?>
                    <p>来源：<?=$type;?></p>
                    <?php endif;?>
                    <p>名字：<?=DataHelper::encode( $user_info['nickname'] );?></p>
                    <p>头像：<img width="100" height="100" class="img-circle" src="<?=$user_info['avatar'];?>"/> </p>
                <?php else:?>
                    <h3>请选择快捷登录方式 ==></h3>
				<?php endif;?>
            </div>
            <div class="col-md-4">
                <div class="row">
					<?php foreach( $auth_urls as $_auth ):?>
                    <div class="col-md-4">
                        <a href="<?=$_auth['url'];?>" class="center-block">
                            <i class="fa fa-<?=$_auth['type'];?> fa-5x" ></i>
                            <p ><?=$_auth['title'];?> </p>
                        </a>
                    </div>
					<?php endforeach;?>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-4" style="margin-top: 40px;">
                具体功能实现请参考博文：<a target="_blank" href="<?= UrlService::buildUrl("/default/info",[ 'id' => 191 ]); ?>">【Demo】QQ，github，微博第三方社交登录</a>
            </div>
        </div>

	</article>
</main>