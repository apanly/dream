<div class="am-g">
    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
        <div class="am-cf">
            <button type="button" class="am-btn am-btn-primary am-fl">上一组</button>
            <button type="button" class="am-btn am-btn-danger am-fr">下一组</button>
        </div>
    </div>
    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
        <?php if($list):?>
        <ul data-am-widget="gallery" class="am-u-lg-12 am-u-md-12 am-u-sm-12 am-gallery-bordered" >
            <?php foreach($list as $_item):?>
            <li>
                <div class="am-gallery-item">
                    <a href="javascript:void(0);">
                        <img src="<?=$_item['src_url'];?>"  alt="<?=$_item['title'];?>"/>
                        <h3 class="am-gallery-title"><?=$_item['title'];?></h3>
                    </a>
                </div>
            </li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
    </div>
</div>
