<p>Hi <?=$member_info["login_name"];?>：</p>
<p>感谢在浪子商城购买服务，服务下载信息如下</p>

<?php foreach ( $items as $_item ):?>
<p><?=$_item['title'];?> 下载地址：<?=$_item['down_url'];?></p>
<?php endforeach;?>

<p>
--------------------------------------<br/>
邮件是自动发送，请勿回复，有需要加入QQ群和更多朋友交流：325264502（群1）、730089859（群2）<br/>
更多的联系方式请前往 <a href="http://www.54php.cn/market/default/about">商城获取</a>
</p>
