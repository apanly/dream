<?php
use \common\service\GlobalUrlService;
use  \common\components\DataHelper;
?>
<nav class="navbar navbar-inverse nav-bar-element">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= GlobalUrlService::buildSuperMarketUrl("/"); ?>" style="padding: 0px;">
                <img src="<?= GlobalUrlService::buildStaticUrl("/images/supermarket/logo.png"); ?>">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="nav navbar-nav">
                <li class="home"><a href="<?= GlobalUrlService::buildSuperMarketUrl("/"); ?>">首页</a></li>

                <li class="site">
                    <a href="<?= GlobalUrlService::buildSuperMarketUrl("/default/site"); ?>">建站源码</a>
                </li>

                <li class="soft">
                    <a href="<?= GlobalUrlService::buildSuperMarketUrl("/default/soft"); ?>">软件下载</a>
                </li>

                <li class="mina">
                    <a href="<?= GlobalUrlService::buildSuperMarketUrl("/default/mina"); ?>">微信小程序</a>
                </li>

                <li class="hide">
                    <a href="<?= GlobalUrlService::buildSuperMarketUrl("/default/macapp"); ?>">Mac软件</a>
                </li>
                <li>
                    <a href="<?= GlobalUrlService::buildBlogUrl("/"); ?>">博客</a>
                </li>
                <li>
                    <a href="<?= GlobalUrlService::buildBlogUrl("/demo"); ?>">演示系统</a>
                </li>
                <li>
                    <a href="<?= GlobalUrlService::buildSuperMarketUrl("/default/about"); ?>">联系浪子</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

				<?php if (isset($this->params['current_member'])): ?>

                    <li class="dropdown">
                        <a href="<?= GlobalUrlService::buildOauthUrl("/user/profile/index"); ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><?= DataHelper::encode($this->params['current_member']['email']); ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= GlobalUrlService::buildOauthUrl("/user/profile/index"); ?>">用户中心</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?= GlobalUrlService::buildOauthUrl("/user/logout"); ?>">退出</a></li>
                        </ul>
                    </li>
				<?php else: ?>
                    <li><a href="<?= GlobalUrlService::buildOauthUrl("/user/login"); ?>">登录</a></li>
                    <li><a href="<?= GlobalUrlService::buildOauthUrl("/user/reg"); ?>">注册</a></li>
				<?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
