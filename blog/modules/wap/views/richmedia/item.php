<?php if ($media_list): ?>
    <?php foreach ($media_list as $_info): ?>
        <li>
            <div class="am-gallery-item">
                <a href="<?= $_info['big_src_url']; ?>">
                    <img src="<?= $_info['small_src_url']; ?>"/>
                    <h3 class="am-gallery-title">
                        <span class="am-icon-map-marker"></span>
                        <?= $_info["address"] ? $_info["address"] : "囧,无GPS信息"; ?>
                    </h3>
                </a>
            </div>
        </li>
    <?php endforeach; ?>
<?php endif; ?>