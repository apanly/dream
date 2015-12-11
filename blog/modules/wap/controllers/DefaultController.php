<?php

namespace blog\modules\wap\controllers;

use blog\components\UrlService;
use blog\modules\wap\controllers\common\BaseController;
use common\components\DataHelper;
use common\components\UtilHelper;
use common\models\posts\Posts;
use Yii;

class DefaultController extends BaseController
{
    private $page_size = 10;

    public function actionIndex()
    {
        $type = intval($this->get("type", 1));
        $type = in_array($type, [1, 2, 3]) ? $type : 1;

        $data = $this->search(['p' => 1, 'type' => $type]);
        return $this->render("index", [
            "post_list_html" => $this->buildItem($data),
            "has_next"       => (count($data) < $this->page_size) ? false : true,
            "type"           => $type
        ]);
    }

    public function actionInfo($id)
    {
        $id = intval($id);
        if (!$id) {
            return $this->goHome();
        }
        $post_info = Posts::findOne(['id' => $id, 'status' => 1]);

        if (!$post_info) {
            return $this->goHome();
        }

        $tags        = explode(",", $post_info['tags']);
        $domain_m = Yii::$app->params['domains']['m'];
        $author      = Yii::$app->params['author'];

        $data = [
            "id"      => $post_info['id'],
            "title"   => $post_info['title'],
            "content" => $post_info['content'],
            "tags"    => $tags,
            "author"  => $author,
            'updated_date'    => date("Y.m.d", strtotime($post_info['updated_time'])),
            'created_date'    => date("Y.m.d", strtotime($post_info['created_time'])),
            'url'     => $domain_m . UrlService::buildWapUrl("/default/info", ["id" => $post_info['id']])
        ];

        $this->setTitle($post_info['title'] . " - 郭大帅哥的博客");
        $this->setDescription($post_info['title'] . " - 郭大帅哥的博客");
        $this->setKeywords($post_info['tags'] . " - 郭大帅哥的博客");

        return $this->render("info", [
            "info" => $data
        ]);
    }

    public function actionSearch()
    {
        $p    = intval($this->get("p", 2));
        $type = intval($this->get("type", 1));
        $type = in_array($type, [1, 2, 3]) ? $type : 1;


        $data = $this->search(['p' => $p, 'type' => $type]);
        return $this->renderJSON([
            'html'     => $this->buildItem($data),
            "has_next" => (count($data) < $this->page_size) ? false : true,
            "has_data" => $data ? true : false
        ]);
    }

    private function search($params = [])
    {
        $p    = isset($params['p']) ? $params['p'] : 1;
        $type = isset($params['type']) ? $params['type'] : 1;

        $offset = ($p - 1) * $this->page_size;

        $query = Posts::find()->where(['status' => 1]);

        if ($type == 2) {
            $query->andWhere(['>', 'hot', 0]);
        }
        if ($type == 3) {
            $query->andWhere(['original' => 1]);
        }

        $posts_info = $query->orderBy("id desc")
            ->offset($offset)
            ->limit($this->page_size)
            ->all();
        $data       = [];
        if ($posts_info) {
            foreach ($posts_info as $_post) {
                $data[] = [
                    'title'     => DataHelper::encode($_post['title']),
                    'content'   => nl2br(UtilHelper::blog_short($_post['content'], 200)),
                    'image_url' => $_post['image_url'],
                    'view_url'  => UrlService::buildWapUrl("/default/info", ["id" => $_post['id']]),
                ];
            }
        }

        return $data;
    }

    private function buildItem($data)
    {
        return $this->renderPartial("item", [
            "post_list" => $data
        ]);
    }
}