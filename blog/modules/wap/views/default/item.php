<?php
use \blog\components\UrlService;
?>
<?php if ($post_list): ?>
    <?php foreach ($post_list as $_post_info): ?>
        <?php if ($_post_info['image_url']): ?>
            <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-right">
                <div class="am-u-sm-8 am-list-main">
                    <h3 class="am-list-item-hd">
                        <a href="<?= $_post_info['view_url']; ?>"><?= $_post_info['title']; ?></a>
                    </h3>

                    <div class="am-list-item-text">
                        <?= $_post_info['content']; ?>
                    </div>
                </div>
                <div class="am-u-sm-4 am-list-thumb">
                    <a href="<?= $_post_info['view_url']; ?>" class="">
                        <img src="<?= $_post_info['image_url']; ?>" alt="<?= $_post_info['title']; ?>"/>
                    </a>
                </div>
                <?php if( $_post_info['tags'] ):?>
                <div class="am-g" style="display: none;">
                    <div class="am-u-sm-12" style="padding: 0;margin-top: 5px">
                        <i class="am-icon-tags"></i>
                        <?php foreach( $_post_info['tags'] as $_tag ):?>
                            <a href="<?=UrlService::buildWapUrl("/search/do",['kw' => $_tag]);?>"><?=$_tag;?></a>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endif;?>
            </li>
        <?php else: ?>
            <li class="am-g am-list-item-desced">
                <div class="am-list-main">
                    <h3 class="am-list-item-hd">
                        <a href="<?= $_post_info['view_url']; ?>"><?= $_post_info['title']; ?></a>
                    </h3>
                    <div class="am-list-item-text">
                        <?= $_post_info['content']; ?>
                    </div>
                </div>
                <?php if( $_post_info['tags'] ):?>
                    <div class="am-g" style="display: none;">
                        <div class="am-u-sm-12" style="padding: 0;margin-top: 5px;">
                            <i class="am-icon-tags"></i>
                            <?php foreach( $_post_info['tags'] as $_tag ):?>
                                <a href="<?=UrlService::buildWapUrl("/search/do",['kw' => $_tag]);?>"><?=$_tag;?></a>
                            <?php endforeach;?>
                        </div>
                    </div>
                <?php endif;?>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>