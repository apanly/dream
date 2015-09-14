<div class="page-title">
    <h2>
        <a href="/library/index"><span class="fa fa-arrow-circle-o-left"></span></a>
        <?=$info["title"];?></h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body posts">
                    <div class="post-item">
                        <div class="post-title">
                            <?=$info["title"];?>
                        </div>
                        <div class="post-date"><span class="fa fa-calendar"></span> <?=$info["publish_date"];?>/<?=$info['author'];?></div>
                        <div class="post-text">
                            <p style="text-align: center;">
                                <img src="<?=$info["image_url"];?>">
                            </p>
                            <p>
                                <?=$info["summary"];?>
                            </p>
                        </div>
                        <div class="post-row">
                            <div class="post-info">
                                <span class="fa fa-thumbs-up"></span> 0 - <span class="fa fa-eye"></span> 0 - <span class="fa fa-star"></span> 0
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Tags</h3>
                    <ul class="list-tags push-up-10">
                        <?php foreach($info['tags'] as $_tag):?>
                        <li><a href="javascript:void(0);"><span class="fa fa-tag"></span> <?=$_tag;?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
