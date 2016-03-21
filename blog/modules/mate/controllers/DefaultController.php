<?php

namespace blog\modules\mate\controllers;

use blog\modules\mate\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\mate\MateList;

class DefaultController extends BaseController
{
    public function actionIndex(){
        $this->setTitle("T773 纯真年华 -- 青春");
        $request = \Yii::$app->request;

        $person_number_mapping = [];
        for( $i = 1 ;$i<= 4 ;$i++){
            $person_number_mapping[ $i ] = $i."人";
        }

        if( $request->isGet ){
            return $this->render("index",[
                "person_number_mapping" => $person_number_mapping
            ]);
        }

        $nickname = trim( $this->post("nickname","") );
        $mobile = trim( $this->post("mobile","") );
        $person_number = intval( $this->post("person_number",1) );

        if( !$nickname ){
            return $this->renderJSON([],"请填写你的真实姓名!!",-1);
        }

        if( !isset( $person_number_mapping[ $person_number ] ) ){
            return $this->renderJSON([],"请选择回校人数!!",-1);
        }

        $model_mate = new MateList();
        $model_mate->nickname = $nickname;
        $model_mate->mobile = $mobile;
        $model_mate->person_num = $person_number;
        $model_mate->created_time = date("Y-m-d H:i:s");
        $model_mate->save(0);
        return $this->renderJSON([],"报名成功!!");
    }

    public function actionList(){
        $data = [];
        $list = MateList::find()->orderBy("id desc")->all();
        foreach( $list as $_item ){

            $data[] = [
                "nickname" => DataHelper::encode( $_item['nickname'] ),
                "mobile" =>  $_item['mobile']?substr_replace( $_item['mobile'],'****',3,4):"",
                "person_num" => $_item['person_num']
            ];

        }
        return $this->render("list",[
            "data" => $data
        ]);
    }
} 