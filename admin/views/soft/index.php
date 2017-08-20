<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
use \admin\components\AdminUrlService;
use \common\service\GlobalUrlService;
StaticService::includeAppJsStatic("/js/soft/index.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/soft_tab.php", ['current' => 'index']); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="row-in">
        <form id="search_conditions">
            <div class="columns-3">
                <select class="select-1" name="status">
                    <option value="-99">请选择状态</option>
                    <?php foreach( $status_mapping as $_status_id => $_status_info ):?>
                        <option value="<?=$_status_id;?>"  <?php if( $search_conditions['status']  == $_status_id ):?> selected <?php endif;?>><?=$_status_info['desc'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="columns-8">
                <div class="input-wrap">
                    <input type="text" class="input-1"  name="kw" placeholder="请输入关键字" value="<?=$search_conditions["kw"];?>">
                </div>
            </div>
            <div class="columns-8">
                <input type="button" value="搜索" class="do btn-tiny">
                <a href="javascript:void(0);" class="color-theme  clear_search mg-l10">清空条件</a>
            </div>

        </form>

    </div>
</div>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
            <table class="table-1">
                <thead>
                <tr>
                    <th>编号</th>
                    <th>标题</th>
                    <th>类型</th>
                    <th>
                        <a class="color-theme" href="<?=AdminUrlService::buildUrl("/soft/index",[ 'order_by' => 'view_count','view_count' => ($search_conditions['order_by'] && $search_conditions['view_count'])?0:1 ]);?>">阅读量</a>
						<?php if($search_conditions['order_by'] && isset($search_conditions['view_count'])):?>
                        <i class="fa <?php if($search_conditions['order_by'] && $search_conditions['view_count']):?>fa-sort-desc<?php else:?>fa-sort-up<?php endif;?>">
                        <?php endif;?>
                    </th>
                    <th>发布时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $_item):?>
                    <tr>
                        <td class="centered"><?=$_item['id'];?></td>
                        <td>
                            <a class="color-theme" href="" target="_blank">
								<?=$_item['title'];?>
                            </a>
                        </td>
                        <td class="centered"><?=$_item['type_desc'];?></td>
                        <td class="centered"><?=$_item['view_count'];?></td>
                        <td class="centered"><?=$_item['created'];?></td>
                        <td class="centered">
                            <span class="label label-<?=$_item['status_info']['class'];?>"><?=$_item['status_info']['desc'];?></span>

                        </td>
                        <td class="centered">
                            <a href="<?=$_item['edit_url'];?>" class="">
                                <i class="icon_club">&#xe610;</i>
                            </a>
                            <?php if($_item['status']):?>
                                <a  href="javascript:void(0);" class="delete" data="<?=$_item['id'];?>">
                                    <i class="icon_club hastip" data-tip="隐藏">&#xe611;</i>
                                </a>
                            <?php else:?>
                                <a  href="javascript:void(0);" class="online" data="<?=$_item['id'];?>">
                                    <i class="icon_club hastip" data-tip="展示">&#xe626;</i>
                                </a>
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="row-in">
        <div class="columns-24 text-right">
            <?php echo \Yii::$app->view->renderFile("@admin/views/common/pagination_v1.php",[
                'pages' => $page_info,
                'url' => '/posts/index',
                'search_conditions' => $search_conditions,
                'current_page_count' => count($data)
            ]);?>
        </div>
    </div>
</div>