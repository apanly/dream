<div class="am-g">
    <div class="am-u-sm-12 am-u-md-12">
        微信上墙
    </div>
    <div class="am-u-sm-12 am-u-md-12">
        <?php if( $list ):?>
        <ul class="am-comments-list am-comments-list-flip">
            <?php foreach( $list as $_item ):?>
            <li class="am-comment">
                <a href="javascript:void(0);">
                    <img src="<?=$_item["avatar"];?>" alt="" class="am-comment-avatar" width="48" height="48"/>
                </a>
                <div class="am-comment-main">
                    <header class="am-comment-hd">
                        <div class="am-comment-meta">
                            <a href="javascript:void(0);" class="am-comment-author"><?=$_item["nickname"];?></a>
                            上墙于 <time><?=$_item["created_time"];?></time>
                        </div>
                    </header>
                    <div class="am-comment-bd">
                        <?=$_item["content"];?>
                    </div>
                </div>
            </li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
    </div>
</div>
