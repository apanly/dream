<?php
namespace common\service\oauth;

class ClientBase {
	protected  $_error_msg = null;
	protected  $_error_code = null;
	public  function _err($msg='',$code = -1){
		if($msg){
			$this->_error_msg = $msg;
		}else{
			$this->_error_msg = '操作失败';
		}
		$this->_error_code = $code;
		return false;
	}

	public  function getLastErrorMsg(){
		return $this->_error_msg?$this->_error_msg:"";
	}


	public  function getLastErrorCode(){
		return $this->_error_code?$this->_error_code:0;
	}
}