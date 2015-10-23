<?php if($media_list):?>
    <?php foreach( $media_list as $_info ):?>
        <li>
            <div class="am-gallery-item">
                <a href="<?= $_info['src_url']; ?>?format=/2/600" class="">
                    <img src="<?= $_info['src_url']; ?>?format=/h/200"  alt="远方 有一个地方 那里种有我们的梦想"/>
                    <h3 class="am-gallery-title">
                        <span class="am-icon-map-marker"></span>
                        <?=$_info["address"]?$_info["address"]:"囧,无GPS信息";?>
                    </h3>
                </a>
            </div>
        </li>
    <?php endforeach;?>
<?php endif;?>