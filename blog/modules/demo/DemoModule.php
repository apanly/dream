<?php

namespace blog\modules\demo;

/**
 * demo module definition class
 */
class DemoModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'blog\modules\demo\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
