<?php
use \blog\components\UrlService;
?>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-12">
        <form action="<?=UrlService::buildWapUrl("/search/do");?>">
            <div class="am-input-group am-input-group-default">
                <span class="am-input-group-btn">
                    <button class="am-btn am-btn-default" type="button">
                        <span class="am-icon-search"></span>
                    </button>
                </span>
                <input type="text"  name="kw" class="am-form-field" placeholder="请输入搜索关键词" value="<?=$kw;?>">
            </div>
        </form>
    </div>
</div>
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
    <div class="am-list-news-bd">
        <ul class="am-list">
            <?php if ($post_list): ?>
                <?php foreach ($post_list as $_post_info): ?>
                    <?php if ($_post_info['image_url']): ?>
                        <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
                            <div class="am-u-sm-4 am-list-thumb">
                                <a href="<?= $_post_info['view_url']; ?>" class="">
                                    <img src="<?= $_post_info['image_url']; ?>" alt="<?= $_post_info['title']; ?>"/>
                                </a>
                            </div>
                            <div class=" am-u-sm-8 am-list-main">
                                <h3 class="am-list-item-hd">
                                    <a href="<?= $_post_info['view_url']; ?>"><?= $_post_info['title']; ?></a>
                                </h3>

                                <div class="am-list-item-text">
                                    <?= $_post_info['content']; ?>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="am-g am-list-item-desced">
                            <div class=" am-list-main">
                                <h3 class="am-list-item-hd">
                                    <a href="<?= $_post_info['view_url']; ?>"><?= $_post_info['title']; ?></a>
                                </h3>

                                <div class="am-list-item-text">
                                    <?= $_post_info['content']; ?>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>