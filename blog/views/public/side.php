<?php
use common\service\CacheHelperService;
use blog\components\StaticService;
use \common\service\GlobalUrlService;
$wx_urls = [
	"my" => GlobalUrlService::buildStaticUrl("/images/weixin/my.jpg"),
	"imguowei" => GlobalUrlService::buildStaticUrl("/images/weixin/imguowei_888.jpg"),
	"coderonin" => GlobalUrlService::buildStaticUrl("/images/weixin/coderonin.jpg"),
	"starzone" => GlobalUrlService::buildStaticUrl("/images/weixin/mystarzone.jpg"),
];


$tags = CacheHelperService::getFrontCache("tag");
$project_list =  \blog\components\BlogUtilService::getProjectList();
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
        <div class="content" style="margin-top: 10px;">
            <p>QQ群1：325264502 <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=d7ed56eea3e6e0047db0420404dd0874c5c3d37e30ee40ab7bb6a5a2fb77dc72"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="编程浪子小天地" title="编程浪子小天地"></a> </p>
            <p>QQ群2：730089859 <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=1f483d7a9e52d737599508fb3961435748982d2acf1f210ca8f42013fbef41f6"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="编程浪子小天地-群2" title="编程浪子小天地-群2"></a></p>
            <p>微信公众号：<a  href="<?=\common\service\GlobalUrlService::buildNullUrl();?>" data-toggle="modal" data-target="#wechat_service_qrcode">CodeRonin（点我扫码）</a></p>
        </div>
    </div>

    <div class="widget">
        <h4 class="title">项目Demo</h4>
        <div class="content e-book">
            <ul class="list-group">
				<?php foreach($project_list as  $_submenu_info ):?>
                    <li class="list-group-item">
                        <a href="<?=$_submenu_info['url'];?>"><?=$_submenu_info['title'];?></a>
                    </li>
				<?php endforeach;;?>
            </ul>
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
        <h4 class="title">电子书籍</h4>
        <div class="content e-book">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="https://github.com/walu/phpbook/blob/master/preface.md" target="_blank">PHP扩展开发及内核应用</a>
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

<?php echo \Yii::$app->view->renderFile("@blog/views/public/wechat.php");?>

