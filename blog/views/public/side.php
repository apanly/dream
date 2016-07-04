<?php
use common\service\CacheHelperService;
use blog\components\StaticService;
$tags = CacheHelperService::getFrontCache("tag");
$menu_list = \blog\components\BlogUtilService::blogMenu();
$project_list = $menu_list['project'];
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
        <h4 class="title">标签云</h4>
        <div class="content tag-cloud">
            <?php if( $tags ):?>
                <?php foreach($tags as $_tag):?>
                    <a href="/search/do?kw=<?=$_tag;?>"><?=$_tag;?></a>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>

    <div class="widget">
        <h4 class="title"><?=$project_list['title'];?>Demo</h4>
        <div class="content e-book">
            <ul class="list-group">
                <?php foreach($project_list['sub_menu'] as $_submenu_key => $_submenu_info ):?>
                    <li class="list-group-item">
                        <a href="<?=$_submenu_info['url'];?>"><?=$_submenu_info['title'];?></a>
                    </li>
                <?php endforeach;;?>
            </ul>
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
                <li class="list-group-item">
                    <a href="http://bonsaiden.github.io/JavaScript-Garden/zh/" target="_blank">JavaScript 秘密花园</a>
                </li>
            </ul>
        </div>
    </div>
</aside>
