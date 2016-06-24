<?php
use \admin\components\AdminUrlService;
?>
<div class="panel-footer">
	<ul class="pagination pagination-sm pull-right">
		<?php if($page_info['previous']):?>
			<li>
				<a class="paginate_button previous" href="<?=AdminUrlService::buildUrl($url,array_merge( $search_conditions,['p'=>1] ) );?>">«</a>
			</li>
		<?php endif;?>
		<?php for($pidx = $page_info['from'];$pidx <= $page_info['end'];$pidx ++ ):?>
			<li class="<?php if($pidx == $page_info['current']):?> active <?php endif;?>">
				<a href="<?=AdminUrlService::buildUrl($url,array_merge( $search_conditions,['p'=>$pidx] ) );?>"><?=$pidx;?></a>
			</li>
		<?php endfor;?>
		<?php if($page_info['next']):?>
			<li>
				<a class="paginate_button next" href="<?=AdminUrlService::buildUrl($url,array_merge( $search_conditions,['p'=>$page_info['total_page']] ) );?>">»</a>
			</li>
		<?php endif;?>
	</ul>
</div>