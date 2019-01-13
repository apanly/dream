<?php
use \common\service\GlobalUrlService;
?>
<section class="paginator-element pull-right">
    <span class="pagination_count hide" style="line-height: 40px;">共<?=$pages['total_count'];?>条记录 | 每页<?=$pages["page_size"];?>条</span>
    <ul class="pagination">
		<?php if ($pages['previous']): ?>
            <li><a href="<?= GlobalUrlService::buildSuperMarketUrl($url, ["p" => 1]); ?>"
                   rel="prev">上一页</a></li>
		<?php endif; ?>
		<?php for ($page_idx = $pages['from']; $page_idx <= $pages['end']; $page_idx++): ?>
			<?php if ($pages['current'] == $page_idx): ?>
                <li class="active"><span><?= $page_idx; ?></span></li>
			<?php else: ?>
                <li>
                    <a href="<?= GlobalUrlService::buildSuperMarketUrl($url, ["p" => $page_idx]); ?>"><?= $page_idx; ?></a>
                </li>
			<?php endif; ?>
		<?php endfor; ?>
		<?php if ($pages['next']): ?>
            <li>
                <a href="<?= GlobalUrlService::buildSuperMarketUrl($url, ["p" => $pages['current'] + 1]); ?>"
                   rel="next">下一页</a>
            </li>
		<?php endif; ?>
    </ul>
</section>