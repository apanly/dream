<?php
use blog\components\StaticService;
use \common\service\GlobalUrlService;
use \common\components\DataHelper;
/*fancy*/
StaticService::includeStaticCss("/jquery/fancy/jquery.fancybox.css",\blog\assets\AppAsset::className());
StaticService::includeStaticJs("/jquery/fancy/jquery.fancybox.pack.js",\blog\assets\AppAsset::className());

StaticService::includeAppCssStatic("/css/market/articles_info.css", \blog\assets\SuperMarketAsset::className());
StaticService::includeAppJsStatic("/js/market/default/info.js", \blog\assets\AppAsset::className());
?>
<div class="container">
    <div class="row" style="margin-top: 5px;">
        <ol class="breadcrumb">
            <li><span>您的位置：</span></li>
            <li class="home"><a href="<?= GlobalUrlService::buildSuperMarketUrl("/"); ?>">首页</a></li>
			<?php if ($info['type'] == 1): ?>
                <li><a href="<?= GlobalUrlService::buildSuperMarketUrl("/default/mina"); ?>">微信小程序</a></li>
            <?php elseif ( $info['type'] == 3): ?>
                <li><a href="<?= GlobalUrlService::buildSuperMarketUrl("/default/site"); ?>">建站源码</a></li>
			<?php endif; ?>
            <li><span><?= DataHelper::encode($info['title']); ?></span></li>
        </ol>
    </div>

    <section class="www-article-main">
        <div class="page-header article-main-title" style="margin-top: 0px;">
            <h3><?= DataHelper::encode($info['title']); ?></h3>
            <p>
                <span>2017-08-20 14:15:35</span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span>作者：<?=\Yii::$app->params['author']['nickname'];?> </span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span>来源：浪子的杂货店</span>
            </p>
        </div>
        <div class="article-main-tags">
            标签：
            <a href="<?=GlobalUrlService::buildNullUrl();?>">
                <?=common\service\Constant::$soft_type[ $info['type'] ];?>
            </a>
        </div>
        <div class="article-main-content">
            <blockquote style="border:1px dashed #FF9A9A;">
                <p>本站保证所有源码都经过详细测试后才分享</p>
                <p>
                    版权声明：本文为博主原创文章，原文永久地址：<?=GlobalUrlService::buildSuperMarketUrl("/default/info",[ 'id' => $info['id'] ]);?>
                </p>
            </blockquote>
			<?= $info['content']; ?>
            <h2>源码下载地址</h2>
			<?php if( isset( $this->params['current_member'] ) ):?>
                <div class="alert alert-info">
					<?=$info['down_url'];?>
                </div>
            <?php else:?>
                <div class="alert alert-info text-center">
                    <strong>下载内容需要&nbsp;&nbsp;<a href="<?=GlobalUrlService::buildOauthUrl("/user/login");?>">登录</a>&nbsp;&nbsp;之后才可以浏览</strong>
                </div>
            <?php endif;?>

        </div>
    </section>
    <div class="row hide">
        <div class="col-sm-12">
            <section class="app-view-section app-view-comment" data-shafa-comment="container">
                <h2>评论 </h2>
                <div class="comment-post">
                    <img src="http://avatar.sfcdn.org/000/00/00/00_avatar_middle.jpg" alt=""
                         class="img-circle comment-post-avatar">
                    <div class="comment-post-area">
                        <form method="POST" action="http://www.shafa.com/articles/A3UQnxlwVbIsAwTo.html"
                              accept-charset="UTF-8" data-shafa-comment="post" data-url="http://www.shafa.com/comment">
                            <input name="_token" type="hidden" value="uXB7RZiApAfm8nGOUP3aWu0478fJ1OD8hcyhUe95">

                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="我来说两句..." name="content" cols="50"></textarea>
                                <div class="arrow white"></div>
                                <div class="arrow gray"></div>
                                <div class="waiting" data-shafa-comment="waiting"><i class="fa fa-spinner fa-spin fa-2x"></i>
                                </div>
                            </div>
                            <button class="btn btn-primary pull-right" type="submit">发表评论</button>
                        </form>
                    </div>
                    <div class="comment-unchecked">
                        <p>亲，你需要登录后才能进行评论喔！</p>
                        <div class="login-buttons">
                            <a href="<?= GlobalUrlService::buildBlogUrl("/user/login"); ?>"
                               class="btn btn-primary">登录</a>
                            <a href="<?= GlobalUrlService::buildBlogUrl("/user/reg"); ?>" class="btn btn-link">注册</a>
                        </div>
                    </div>
                </div>
                <div data-shafa-comment="main" data-select="1">
                    <p class="comment-none" data-shafa-comment="none">还没有评论，快来抢沙发吧！</p>
                </div>
            </section>
        </div>
    </div>
</div>


