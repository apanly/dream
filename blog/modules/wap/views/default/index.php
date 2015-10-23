<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
    <div class="am-list-news-bd">
        <ul class="am-list">
            <?php if($post_list):?>
                <?php foreach( $post_list as $_post_info ):?>
                    <?php if($_post_info['image_url']):?>
                    <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
                        <div class="am-u-sm-4 am-list-thumb">
                            <a href="<?=$_post_info['view_url'];?>" class="">
                                <img src="<?=$_post_info['image_url'];?>" alt="<?=$_post_info['title'];?>"/>
                            </a>
                        </div>
                        <div class=" am-u-sm-8 am-list-main">
                            <h3 class="am-list-item-hd"><a href="<?=$_post_info['view_url'];?>" class=""><?=$_post_info['title'];?>"</a></h3>

                            <div class="am-list-item-text">
                                <?=$_post_info['content'];?>
                            </div>
                        </div>
                    </li>
                    <?php else:?>
                    <li class="am-g am-list-item-desced">
                        <div class=" am-list-main">
                            <h3 class="am-list-item-hd"><a href="<?=$_post_info['view_url'];?>" class=""><?=$_post_info['title'];?></a></h3>

                            <div class="am-list-item-text">
                                <?=$_post_info['content'];?>
                            </div>
                        </div>
                    </li>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>
        </ul>
    </div>

</div>
