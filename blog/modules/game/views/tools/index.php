<?php
use blog\components\StaticService;
use \blog\components\UrlService;
StaticService::includeAppJsStatic("/js/game/tools/index.js", \blog\assets\GameAsset::className());
?>
<?= Yii::$app->controller->renderPartial("/tools/tab.php",[ 'current' => 'gene_pwd' ]); ?>

<div class="am-container" id="gene_password" style="margin-top: 10px;">
    <table class="am-table am-table-bordered am-table-radius am-table-striped">
        <tr>
            <td>所用字符</td>
            <td>
                <input name="option[]" value="1" type="checkbox" checked="checked"/>A-Za-z0-9　
                <br/>
                <input name="option[]" value="2" type="checkbox" /> !@#$%^&*
            </td>
        </tr>
        <tr>
            <td>密码长度</td>
            <td>
                <select id="pass_length">
                    <option value="16">16位</option>
                    <option value="32">32位</option>
                    <option value="48">48位</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>生成结果</td>
            <td>
                <input type="text" id="result">
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <a href="javascript:void(0);" class="am-btn am-btn-sm am-btn-success am-radius do_gene">生成</a>
                <a  style="display: none;" href="javascript:void(0);" class="am-text-xs am-text-success am-text-bottom">复制到剪贴板</a>
            </td>
        </tr>
    </table>
</div>