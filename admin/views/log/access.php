<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
StaticService::includeStaticCss("/jquery/datetimepicker/jquery.datetimepicker.min.css",\admin\assets\AdminAsset::className() );
StaticService::includeStaticJs( "/jquery/datetimepicker/jquery.datetimepicker.full.min.js", \admin\assets\AdminAsset::className() );
StaticService::includeAppJsStatic("/js/log/access.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
            <?php echo \Yii::$app->view->renderFile("@admin/views/common/stat_tab.php", ['current' => 'access']); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="row-in">
        <form id="search_conditions">
            <div class="columns-5">
                <div class="row">
                    <div class="row-in">
                        <div class="columns-6">
                            <label class="label-name inline">日期</label>
                        </div>
                        <div class="columns-18">
                            <div class="input-wrap">
                                <div class="input-wrap">
                                    <input type="text" class="input-1" placeholder="开始日期" name="date_from" value="<?=$search_conditions['date_from'];?>" data-date-format="yyyy-mm-dd">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="columns-4">
                <div class="row">
                    <div class="row-in">
                        <div class="columns-4 text-left">
                            <label class="label-name inline">至</label>
                        </div>
                        <div class="columns-20">
                            <div class="input-wrap">
                                <input type="text" name="date_to" class="input-1" placeholder="结束日期" value="<?=$search_conditions['date_to'];?>" data-date-format="yyyy-mm-dd">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="columns-5">
                <input type="hidden" name="source" value="<?=$search_conditions['source'];?>">
                <input type="hidden" name="uuid" value="<?=$search_conditions['uuid'];?>">
                <input type="submit" value="搜索" class="do btn-tiny">
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
                    <th>序号</th>
                    <th>目标URL</th>
                    <th>来源</th>
                    <th>UUID</th>
                    <th>操作系统</th>
                    <th>浏览器</th>
                    <th>设备</th>
                    <th>IP</th>
                    <th>地址</th>
                    <th>时间</th>
                </tr>
                </thead>
                <tbody>
                <?php if($data):?>
                    <?php foreach($data as $_item):?>
                        <tr class="centered">
                            <td><?=$_item['idx'];?></td>
                            <td><?=$_item['target_url'];?> </td>
                            <td><?=$_item['source'];?> </td>
                            <td><?=$_item['uuid'];?></td>
                            <td><?=$_item['os'];?></td>
                            <td><?=$_item['browser'];?></td>
                            <td><?=$_item['client_device'];?></td>
                            <td><?=$_item['ip'];?></td>
                            <td><?=$_item['ip_desc'];?></td>
                            <td><?=$_item['created_time'];?></td>
                        </tr>
                    <?php endforeach;?>
                <?php else:?>
                    <tr><td colspan="6">暂无数据</td></tr>
                <?php endif;?>
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
                'url' => '/log/access',
                'search_conditions' => $search_conditions,
                'current_page_count' => count($data)
            ]);?>
        </div>
    </div>
</div>