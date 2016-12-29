<?php

namespace awephp\controllers;

use awephp\controllers\common\AuthController;
use common\components\CommonException;
use Yii;
use yii\log\FileTarget;

class ErrorController extends AuthController {
    public function actionError() {
        $code = 404;
        $msg = CommonException::OBJECT_NOT_FOUND;
        $error = Yii::$app->errorHandler->exception;
        if ($error) {
            $code = $error->getCode();
            $msg = $error->getMessage();
            $file = $error->getFile();
            $line = $error->getLine();

            $time = microtime(true);
            $log = new FileTarget();
            $log->logFile = Yii::$app->getRuntimePath() . '/logs/err.log';
            $log->messages[] = [
                $msg . " [file: {$file}][line: {$line}][err code:$code.][url:{$_SERVER['REQUEST_URI']}][post:".http_build_query($_POST)."]",
                1,
                'application',
                $time
            ];
            $log->export();
        }
        return $this->goHome();
    }
}

