<?php
namespace api\controllers\common;

use yii\web\Controller;
use Yii;

class AuthController extends Controller
{
    public $enableCsrfValidation = false;
    protected  $salt = "3rAWQBDHxgy@JhXTd9OXcQ!4m0Lf70ZaqCspno^R!xhqv3^l";
    protected  $current_user;
    protected  $current_city_id ;
    protected  $open_id = 0;
    protected  $allowAllAction = [];//在这里面的就不用检查合法性


    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config = []);
    }
    public function beforeAction($action) {
        if (!in_array($action->getUniqueId(), $this->allowAllAction )) {

        }
        return true;
    }

    protected function renderJSON($data=[], $msg ="ok", $code = 200)
    {
        header('Content-type: application/json');
        echo json_encode([
            "code" => $code,
            "msg"   =>  $msg,
            "data"  =>  $data,
            "req_id" =>  $this->geneReqId(),
        ]);


        return Yii::$app->end();
    }

    protected function renderJSONP($data=[], $msg ="ok", $code = 200) {

        $func = $this->get("jsonp","jsonp_func");


        echo $func."(".json_encode([
            "code" => $code,
            "msg"   =>  $msg,
            "data"  =>  $data,
            "req_id" =>  $this->geneReqId(),
        ]).")";

        return Yii::$app->end();
    }

    protected function renderNotFound() {
        $this->renderJSON([],$msg = "ObjectNotFound", -1);
    }


    protected function geneReqId() {
        return uniqid();
    }

    public function post($key, $default = "") {
        return Yii::$app->request->post($key, $default);
    }


    public function get($key, $default = "") {
        return Yii::$app->request->get($key, $default);
    }

}