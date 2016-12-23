<?php
use common\service\CacheHelperService;
use blog\components\StaticService;
use \common\service\GlobalUrlService;
$wx_urls = [
	"my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
	"imguowei" => GlobalUrlService::buildStaticUrl("/images/weixin/imguowei_888.jpg"),
	"starzone" => GlobalUrlService::buildStaticUrl("/images/weixin/mystarzone.jpg"),
];


$tags = CacheHelperService::getFrontCache("tag");
$menu_list = \blog\components\BlogUtilService::blogMenu();
$project_list = $menu_list['project'];
?>
<aside class="col-md-4 sidebar">
    <div class="widget">
        <h4 class="title">社交</h4>
        <div class="content">
            <p>QQ群：325264502 <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=d7ed56eea3e6e0047db0420404dd0874c5c3d37e30ee40ab7bb6a5a2fb77dc72"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="编程浪子小天地" title="编程浪子小天地"></a> </p>
            <p>微信公众号：<a  href="<?=\common\service\GlobalUrlService::buildNullUrl();?>" data-toggle="modal" data-target="#wechat_service_qrcode">imguowei_888</a></p>
        </div>
    </div>

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

<div class="modal fade" id="wechat_service_qrcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h5 class="modal-title" id="myModalLabel">公众号二维码</h5>
            </div>
            <div class="modal-body">
                <img title="编程浪子的故事:imguowei_888" src="<?=$wx_urls['imguowei'];?>">
            </div>
        </div>
    </div>
</div>
