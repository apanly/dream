<?php
use \yii\helpers\Url;
use \admin\components\StaticService;
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
            <?php echo \Yii::$app->view->renderFile("@admin/views/common/file_tab.php", ['current' => 'index']); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
            <table class="table-1">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>图片</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if( $data ):?>
                    <?php foreach ($data as $_item): ?>
                        <tr>
                            <td class="text-center"><?=$_item['idx'];?></td>
                            <td>
                                <img src="<?= $_item['small_pic_url']; ?>"/>
                            </td>
                            <td>
                                <a href="<?= $_item['big_pic_url']; ?>" target="_blank">查看大图</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else:?>
                    <tr><td colspan="3">暂无</td></tr>
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
                'url' => '/file/index',
                'search_conditions' => [],
                'current_page_count' => count($data)
            ]);?>
        </div>
    </div>
</div>