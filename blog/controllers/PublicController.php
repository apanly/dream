<?php

namespace blog\controllers;

use blog\controllers\common\BaseController;
use common\components\HttpClient;
use common\models\posts\Posts;
use common\models\posts\PostsTags;
use Yii;


class PublicController extends BaseController{
    public function actionIframe(){
        $url = $this->get("url","");
        $data = HttpClient::get($url);
        echo <<<EOT
<pre class='iframe_bug' style='word-wrap: break-word; white-space: pre-wrap;width:300px;'>{$data}</pre>
EOT;
        exit();
    }
}