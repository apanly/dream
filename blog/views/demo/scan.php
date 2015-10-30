<?php
use \blog\components\StaticService;

StaticService::includeAppJsStatic("/js/demo/scan.js", \blog\assets\AppAsset::className());
?>
<main class="col-md-12 main-content">
    <article class="post page">
        <header class="post-head">
            <h1 class="post-title">扫描登录</h1>
        </header>
        <section class="post-content text-center">
            <div class="row qrcode">
                <img src="/demo/qrcode">
            </div>
            <div class="row result" style="display: none;">
                <h3>扫描成功！</h3>

                <p class="nickname"> -- </p>

                <p class="email"> -- </p>
            </div>
        </section>
    </article>
</main>