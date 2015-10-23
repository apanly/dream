<div class="am-g">
    <?php if($book_list):?>
        <?php foreach($book_list as $_book_info ):?>
    <div class="am-u-sm-12">
        <div class="am-thumbnail">
            <img src="<?=$_book_info['imager_url'];?>" alt="<?=$_book_info['title'];?>" style="width: 100%;"/>
            <div class="am-thumbnail-caption">
                <h3><?=$_book_info['title'];?></h3>
                <p>
                    <?=$_book_info['author'];?>
                </p>
                <p>
                    <a class="am-btn am-btn-warning" href="<?=$_book_info['view_url'];?>">查看详情</a>
                </p>
            </div>
        </div>
    </div>
        <?php endforeach;?>
    <?php endif;?>
</div>