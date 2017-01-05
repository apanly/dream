<?php
use \admin\components\StaticService;
use \admin\components\AdminUrlService;

StaticService::includeAppJsStatic("/js/md/menu.js", \admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/posts_tab.php", ['current' => 'md_menu']); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="row-in">
        <div class="title-3a">
            <div class="columns-24 right ops_btn_wrap">
                <i class="icon_club pointer hastip add" data-tip="添加菜单">&#xe613;</i>
                <i class="icon_club pointer hastip refresh" data-tip="刷新菜单">&#xe636;</i>
            </div>
        </div>
    </div>
</div>

<div class="row menu_list_wrap">
    <div class="row-in">
        <div class="columns-24">
            <table class="table-1">
                <thead>
                <tr>
                    <th style="width:30%">一级菜单</th>
                    <th style="width:70%">二级菜单</th>
                </tr>
                </thead>
                <tbody>
				<?php if( $list ):?>
                    <tr>
                        <td class="pd-0 rbac_l">
                            <table class="table-1 edit-mode" data-elem="tbody tr" data-class="selected-1">
                                <tbody>
                                    <?php foreach( $list as $_item ):?>
                                    <tr>
                                        <td>
                                            <i data="<?=$_item['id'];?>" class="icon_club pointer hastip add_sub" data-tip="添加子菜单">&#xe60f;</i>
                                            <i data="<?=$_item['id'];?>" class="icon_club pointer hastip edit" data-tip="编辑菜单">&#xe610;</i>
                                            <a class="lv_1" href="javascript:void(0);" data="<?=$_item['id'];?>">
                                                <?=$_item['title'];?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </td>
                        <td class="rbac_r">
							<?php foreach( $list as $_item ):?>
                                <table class="table-1 bd-0 hide" id="menu_<?=$_item['id'];?>">
                                    <tbody>
                                    <?php if( $_item['sub_menu'] ):?>
                                    <?php foreach( $_item['sub_menu']  as $_sub_item ):?>
                                        <tr>
                                            <td  class="text-center bg">
                                                <i data="<?=$_sub_item['id'];?>"  data_parent_id="<?=$_sub_item['parent_id'];?>" class="icon_club pointer hastip edit_sub" data-tip="编辑子菜单">&#xe610;</i>
                                                <i data="<?=$_sub_item['id'];?>"  data_parent_id="<?=$_sub_item['parent_id'];?>" class="icon_club pointer hastip del_sub" data-tip="删除子菜单">&#xe611;</i>
                                                <?=$_sub_item['doc_title'];?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                    </tbody>
                                </table>
							<?php endforeach;?>
                        </td>
                    </tr>
                <?php else:?>
                    <tr>
                        <td>暂无菜单</td>
                    </tr>
				<?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="hide lay-small" id="pop_layer_wrap">

</div>