<?php
use common\service\CacheHelperService;
use blog\components\StaticService;

//StaticService::includeStaticJs("/jquery/jquery.mousewheel.min.js", \blog\assets\AppAsset::className());
//StaticService::includeStaticJs("/jquery/jquery.tagsphere.min.js", \blog\assets\AppAsset::className());
//StaticService::includeAppJsStatic("/js/web/public/side.js",\blog\assets\AppAsset::className());
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
        <h4 class="title">电子书籍</h4>
        <div class="content e-book">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="http://www.walu.cc/phpbook/" target="_blank">PHP扩展开发及内核应用</a>
                </li>
		<li class="list-group-item">
                    <a href="http://man.chinaunix.net/develop/rfc/default.htm" target="_blank">中文RFC文档目录</a>
                </li>
            </ul>
        </div>
    </div>
</aside>
