<?php

use \common\service\GlobalUrlService;
use  \common\components\DataHelper;

?>
<div class="col-sm-3 col-md-3 col-lg-3 sidebar">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12" style="padding: 0">
            <table class="table">
                <tr>
                    <td width="30%" style="border-top:none;">
                        <img class="img-circle" style="width: 100px; height: 100px;"
                             src="<?= GlobalUrlService::buildPicStaticUrl("avatar", "/{$this->params['current_member']['avatar']}", ['w' => 100, 'h' => 100]); ?>">
                    </td>
                    <td style="border-top:none;">
                        <p><?= DataHelper::encode($this->params['current_member']['login_name']); ?></p>
                        <p><?= DataHelper::encode($this->params['current_member']['email']); ?></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <ul class="nav nav-sidebar">
        <li class="<?php if ($current == "index"): ?> active <?php endif; ?>">
            <a href="<?= GlobalUrlService::buildBlogUrl("/user/profile/index"); ?>"><i class="fa fa-user fa-lg"></i>个人资料</a>
        </li>
        <li class="<?php if ($current == "set_pwd"): ?> active <?php endif; ?>">
            <a href="<?= GlobalUrlService::buildBlogUrl("/user/profile/set-pwd"); ?>"><i class="fa fa-edit fa-lg"></i>修改密码</a>
        </li>
        <li class="<?php if ($current == "notice"): ?> active <?php endif; ?>">
            <a href="<?= GlobalUrlService::buildBlogUrl("/user/profile/notice"); ?>"><i class="fa fa-bell fa-lg"></i>订阅设置</a>
        </li>
        <li class="<?php if ($current == "bind"): ?> active <?php endif; ?>">
            <a href="<?= GlobalUrlService::buildBlogUrl("/user/profile/bind"); ?>"><i class="fa fa-cog fa-lg"></i>绑定第三方账号</a></a>
        </li>
    </ul>
</div>