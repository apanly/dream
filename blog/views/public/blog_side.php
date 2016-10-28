<?php
use common\service\CacheHelperService;
use \common\service\GlobalUrlService;
use \blog\components\UrlService;
$wx_urls = [
    "my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
    "imguowei" => GlobalUrlService::buildStaticUrl("/images/weixin/imguowei_888.jpg"),
    "starzone" => GlobalUrlService::buildStaticUrl("/images/weixin/mystarzone.jpg"),
];
$tags = CacheHelperService::getFrontCache("tag");
?>
<aside class="col-md-4 sidebar">
    <div class="widget hide">
        <h4 class="title">搜索</h4>
        <div class="content search">
            <div class="input-group">
                <input type="text" class="form-control" id="kw"/>
                <span class="input-group-btn">
                    <button class="btn btn-default do-search" type="button" style="padding: 6px 12px;">搜索</button>
                </span>
            </div>
        </div>
    </div>
    <div class="widget hidden content_index_wrap">
        <h4 class="title">目录</h4>
        <div class="content">

        </div>
    </div>
    <div class="widget">
        <h4 class="title">智能推荐</h4>
        <div class="content recommend_posts">
                <?php foreach( $recommend_blogs as $_recommend_blog_info ):?>
                <p>
                    <a href="<?=UrlService::buildUrl("/default/info",[ "id" => $_recommend_blog_info["id"],"flag" => "recommend" ]);?>"><?=$_recommend_blog_info["title"];?></a>
                </p>
                <?php endforeach;?>
        </div>
    </div>
    <div class="widget hide">
        <h4 class="title">阅读目录</h4>
        <div class="content" id="content">

        </div>
    </div>
    <div class="widget">
        <h4 class="title">扫一扫手机阅读</h4>
        <div class="content m_qrcode">
            <img title="扫一扫手机阅读" src="<?=GlobalUrlService::buildBlogUrl("/default/qrcode",[ "qr_text" => $qr_text ]);?>">
        </div>
    </div>
    <div class="widget">
        <h4 class="title">微信服务号</h4>
        <div class="content wechat">
            <img title="编程浪子的故事:imguowei_888" src="<?=$wx_urls['imguowei'];?>">
        </div>
    </div>
</aside>
