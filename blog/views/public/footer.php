<?php
use common\service\CacheHelperService;
use common\service\GlobalUrlService;
$data = CacheHelperService::getFrontCache();
$tags = $data['tag'];
$post_hot = array_slice($data['post_hot'],0,5);
$post_latest = array_slice($data['post_latest'],0,5);
?>
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">热门文章</h4>
                    <div class="content recent-post hots-post">
                        <?php if( $post_hot ):?>
                            <?php foreach( $post_hot as $_post_info  ):?>
                                <div class="recent-single-post">
                                    <a href="<?=$_post_info['detail_url'];?>" class="post-title">
                                        <?=$_post_info['title'];?>
                                    </a>
                                </div>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">最新文章</h4>
                    <div class="content recent-post">
                        <?php if( $post_latest ):?>
                            <?php foreach( $post_latest as $_post_info  ):?>
                                <div class="recent-single-post">
                                    <a href="<?=$_post_info['detail_url'];?>" class="post-title">
                                        <?=$_post_info['title'];?>
                                    </a>
                                </div>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
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
            </div>
        </div>
    </div>
</footer>

<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <span><?= $copyright; ?></span>
            </div>
        </div>
    </div>
</div>

<a href="javascript:void(0);" id="back-to-top"><i class="fa fa-angle-up"></i></a>
<input type="hidden" id="access_domain" value="<?=\Yii::$app->params['domains']['blog'];?>">
<input type="hidden" id="domain_static" value="<?=GlobalUrlService::buildStaticUrl("/");?>">