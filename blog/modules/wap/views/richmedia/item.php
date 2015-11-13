<?php if ($media_list): ?>
    <?php foreach ($media_list as $_info): ?>
        <li>
            <div class="am-gallery-item">
                <a href="javascript:void(0);">
                    <img data-src="<?= $_info['src_url']; ?>" data = "<?= $_info['switch']?1:0; ?>" />
                    <h3 class="am-gallery-title">
                        <span class="am-icon-map-marker"></span>
                        <?= $_info["address"] ? $_info["address"] : "囧,无GPS信息"; ?>
                    </h3>
                </a>
            </div>
        </li>
    <?php endforeach; ?>
<?php endif; ?>