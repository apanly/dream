<?php
namespace blog\modules\game\controllers\common;

use blog\components\BaseBlogController;
use blog\components\UrlService;


class BaseController extends BaseBlogController
{

    protected $allowAllAction = [];

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config = []);
        $view  = \Yii::$app->view;
        $view->params['id'] = $id;
        $this->layout = false;
    }

    public function beforeAction($action)
    {
        $this->setTitle();
        $this->setDescription();
        $this->setKeywords();
        if (!in_array($action->getUniqueId(), $this->allowAllAction)) {

        }
        return true;
    }

    public function setKeywords($keywords = "")
    {
        $keywords  = $keywords ? $keywords : \Yii::$app->params['seo']['keywords'];
        $this->getView()->params['seo']['keywords'] = $keywords;
    }

    public function setDescription($description = "")
    {
        $description  = $description ? $description : \Yii::$app->params['seo']['description'];
        $this->getView()->params['seo']['description'] = $description;
    }


    public function goHome()
    {
        return $this->redirect(UrlService::buildWapUrl("/defaul/index"));
    }

    public function goLibraryHome()
    {
        return $this->redirect(UrlService::buildWapUrl("/library/index"));
    }
} 