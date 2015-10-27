<?php
namespace api\modules\weixin\controllers;


use api\modules\weixin\controllers\common\BaseController;
use api\modules\weixin\controllers\WxrequestController;


use Yii;

class MenuController extends BaseController{

    public  function actionCreate( )
    {
        if (!$this->checkSignature()) {
            return false;
        }

        $from  = $this->getSource();
        $domains = Yii::$app->params['domains'];
        $domain_blog = $domains['blog'];

        $menu  = [
            "button" => [
                [
                    "name"       => "博客",
                    "sub_button" => [
                        [
                            "type" => "click",
                            "name" => "原创文章",
                            "key"  => "blog_original"
                        ],
                        [
                            "type" => "click",
                            "name" => "最新文章",
                            "key"  => "blog_new"
                        ],
                        [
                            "name" => "文章列表",
                            "type" => "view",
                            "url"  => "{$domain_blog}/wap/?from={$from}"
                        ]
                    ]
                ],
                [
                    "name"       => "生活",
                    "sub_button" => [
                        [
                            "type" => "click",
                            "name" => "精选图书",
                            "key"  => "book_hot"
                        ],
                        [
                            "type" => "view",
                            "name" => "图书列表",
                            "url"  => "{$domain_blog}/wap/library/index?from={$from}"
                        ],
                        [
                            "name" => "富媒体",
                            "type" => "view",
                            "url"  => "{$domain_blog}/wap/richmedia/index?from={$from}"
                        ]
                    ]
                ],
                [
                    "name"       => "关于",
                    "sub_button" => [
                        [
                            "type" => "view",
                            "name" => "关于",
                            "url"  => "{$domain_blog}/wap/my/about?from={$from}"
                        ],
                        [
                            "type" => "view",
                            "name" => "赞助",
                            "url"  => "{$domain_blog}/wap/my/wechat?from={$from}"
                        ]
                    ]
                ]
            ]
        ];

        $access_token = WxrequestController::getAccessToken();
        if( !$access_token ){
            $access_token = WxrequestController::getAccessToken( true );
        }
        return WxrequestController::send("menu/create?access_token=" . $access_token, json_encode($menu,JSON_UNESCAPED_UNICODE), 'POST');
    }

    public static function delete()
    {

    }

}
