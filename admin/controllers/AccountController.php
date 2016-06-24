<?php

namespace admin\controllers;

use admin\controllers\common\BaseController;
use common\components\DataHelper;
use common\models\admin\Account;
use \Yii;


class AccountController extends BaseController{
    public function actionIndex(){
        $query = Account::find();
        $list = $query->orderBy( [ 'id' => SORT_DESC ] )->all();
        $data = [];
        if( $list ){
            $idx = 1;
            foreach($list as $_item){
                $tmp_decrypt_pwd = $this->decrypt( $_item['pwd'] );
                $data[] = [
                    'idx' =>  $idx,
                    'id' => $_item['id'],
                    'title' => DataHelper::encode($_item['title']),
                    'account' => DataHelper::encode($_item['account']),
                    'pwd' => $tmp_decrypt_pwd,
                    'description' => DataHelper::encode($_item['description']),
                ];
                $idx++;
            }
        }

        return $this->render("index",[
            'list' => $data
        ]);
    }

    public function actionSet(){
        if( Yii::$app->request->isGet ){
            $account_id = intval( $this->get("account_id",0) );
            $info = [];
            if( $account_id ){
                $info = Account::findOne( ['id' => $account_id] );
            }

            $form_html = $this->renderPartial("set",[
                'info' => $info
            ]);
            return $this->renderJSON([ 'form_wrap' => $form_html ]);
        }

        $account_id = intval( $this->post("account_id",0) );
        $title= trim( $this->post("title","") );
        $account= trim( $this->post("account","") );
        $pwd= trim( $this->post("pwd","") );
        $description= trim( $this->post("description","") );
        $date_now = date("Y-m-d H:i:s");

        if( mb_strlen($title,"utf-8") < 1 ){
            return $this->renderJSON([],"请输入标题，方便记忆！！",-1);
        }

        if( mb_strlen($account,"utf-8") < 1 ){
            return $this->renderJSON([],"请输入账号！！",-1);
        }

        if( mb_strlen($pwd,"utf-8") < 1 ){
            return $this->renderJSON([],"请输入密码！！",-1);
        }

        $encrypt_pwd = $this->encrypt($pwd);
        if( !$encrypt_pwd ){
            return $this->renderJSON([],"密码加密失败，重新提交！！",-1);
        }

        if( $account_id ){
            $info = Account::findOne( ['id' => $account_id] );
            if( !$info ){
                return $this->renderJSON([],"指定账号不存在！！",-1);
            }

            $model_account = $info;
        }else{
            $model_account = new Account();
            $model_account->created_time = $date_now;
        }

        $model_account->title = $title;
        $model_account->account = $account;
        $model_account->pwd = $encrypt_pwd;
        $model_account->description = $description;
        $model_account->updated_time = $date_now;
        $model_account->save( 0 );

        return $this->renderJSON([],"操作成功！！");
    }


    private function decrypt( $txt ){
        $txt = base64_decode($txt);
        $fp=fopen ( Yii::$app->params['account']['private_key_path'],"r");
        $priv_key2=fread ($fp,8192);
        fclose($fp);
        $PK2=openssl_get_privatekey($priv_key2);
        $ret = openssl_private_decrypt($txt,$output,$PK2);
        if ( !$ret ) {
            return false;
        }
        return $output;
    }

    private function encrypt( $txt ){
        $fp=fopen (Yii::$app->params['account']['public_key_path'],"r");
        $pub_key=fread ($fp,8192);
        fclose($fp);
        $PK = openssl_get_publickey($pub_key);
        if (!$PK) {
           return false;
        }
        $output="";
        openssl_public_encrypt($txt,$output,$PK);
        if (!empty($output)) {
            openssl_free_key($PK);
            return base64_encode($output);
        }
        return false;
    }
}