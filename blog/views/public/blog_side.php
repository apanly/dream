<?php
use common\service\CacheHelperService;
use \common\service\GlobalUrlService;
$wx_urls = [
    "my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
    "imguowei" => GlobalUrlService::buildStaticUrl("/images/weixin/imguowei_888.jpg"),
    "starzone" => GlobalUrlService::buildStaticUrl("/images/weixin/mystarzone.jpg"),
];
$tags = CacheHelperService::getFrontCache("tag");
?>
<aside class="col-md-4 sidebar">
    <div class="widget">
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
    <div class="widget">
        <h4 class="title">智能推荐</h4>
        <div class="content recommend_posts">
                <?php foreach( $recommend_blogs as $_recommend_blog_info ):?>
                <p>
                    <a href="<?=$_recommend_blog_info["view_url"];?>"><?=$_recommend_blog_info["title"];?></a>
                </p>
                <?php endforeach;?>
        </div>
    </div>

    <div class="widget">
        <h4 class="title">微信服务号</h4>
        <div class="content wechat">
            <img title="郭大帅哥的故事:imguowei_888" src="<?=$wx_urls['imguowei'];?>">
        </div>
    </div>
</aside>
