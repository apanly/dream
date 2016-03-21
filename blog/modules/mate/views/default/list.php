<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
    <table class="am-table">
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机</th>
            <th>人数</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach( $data as $_item ):?>
            <tr>
                <td><?=$_item["nickname"];?></td>
                <td><?=$_item["mobile"];?></td>
                <td><?=$_item["person_num"];?>人</td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>