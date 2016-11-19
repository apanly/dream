<?php


namespace console\controllers;


use common\models\ops\ReleaseQueue;

class ReleaseController extends  BaseController {

	/**
	 * php yii release/index
	 */
    public function actionIndex() {
        $mapping = \Yii::$app->params['ops_repo'];
        $queue = ReleaseQueue::find()->where([ 'status' => -2 ])->orderBy([ 'id' => SORT_ASC ])->one();
        if(!$queue){
            return $this->echoLog(' no queue need to handle ~~');
        }
		$queue->status = -1;
		$queue->updated_time = date('Y-m-d H:i:s');
		$queue->update(0);

		$this->releaseRepo($queue,$mapping[ $queue['repo'] ]);

		return $this->echoLog(" it's over  ~~");
    }

	/*发布代码*/
	private function releaseRepo($queue,$repo_config){
		$log = [];
		$log['fail_reason'] = '';
		$log['feature'] = '';
		$log['remote'] = '';
		$log['version'] = '';

		//也可以更新本地
		if( isset( $repo_config['feature'] ) ){
			$msg = $this->execLocalCmd( $repo_config['feature']['path'] );
			$log['feature'] = $msg;
			if (stripos($msg, "conflict") !== false) {
				$log['fail_reason'] = "无法合并有冲突,请手动解决";
				$queue->status = 0;
			}else if(stripos($msg, "unstaged changes") !== false){
				$log['fail_reason'] = "无法合并有文件变动,请手动解决";
				$queue->status = 0;
			}else{
				$queue->status = 1;
			}
		}


		/*发布到远程服务器*/
		if( $queue->status == 1 && isset( $repo_config['remote'] ) && isset( $repo_config['remote']['hosts'] ) ){
			$msg = $this->execRemoteCmd($repo_config,$repo_config['remote']['hosts']);
			$log['remote'] = $msg;

			if (stripos($msg, "CONFLICT") !== false) {
				$log['fail_reason'] = "无法合并有冲突,请手动解决";
				$queue->status = 0;
			}else if(stripos($msg, "unstaged changes") !== false){
				$log['fail_reason'] = "无法合并有文件变动,请手动解决";
				$queue->status = 0;
			}
		}

		//发布成功之后写入版本文件
		if( $queue->status == 1 && isset($repo_config['version']) ){
			$msg = $this->writeReleaseVersion( $repo_config );
			if( $msg ){
				$log['version'] = "\r\n".$msg;
			}
		}

		$queue->content = json_encode($log);
		$queue->updated_time = date('Y-m-d H:i:s');
		$queue->update(0);

		return true;
	}

	/*在本地机器执行命令*/
    private function execLocalCmd($path){
        $res = [];
        $cmd = "cd %s ; git fetch --all; git rebase origin/master 2>&1";
        $cmd = sprintf($cmd, $path);
        $res[] = "------------- start(".date("Y-m-d H:i:s").") --------------------\r\n";;
        $res[] = $cmd;
        exec($cmd, $output);
        $output = implode("\r\n", $output);
        $res[] = $output;
        if (stripos($output, "CONFLICT") !== false) {
            $cmd = "cd %s &&  git rebase --abort";
            $cmd = sprintf($cmd, $path);
            $res[] = $cmd;
            exec($cmd, $output);
            $output = implode("\r\n", $output);
            $res[] = $output;
        }
        $res[] = "------------- end(".date("Y-m-d H:i:s").") --------------------\r\n";;
        return implode("\r\n", $res);
    }

    /*到远程机器执行命令*/
    private function execRemoteCmd($repo_config,$hosts){
    	$path = $repo_config['remote']['path'];
    	$ssh_param = $repo_config['remote']['ssh_param'];
		$res = [];
		foreach($hosts as $host){
			$cmd = "ssh {$ssh_param}@{$host} -t -t 'cd %s ;git fetch --all ; git rebase origin/master 2>&1 '";
			$cmd = sprintf($cmd, $path);
			$res[] = "------------- $host  start(".date("Y-m-d H:i:s").") --------------------\r\n";
			$res[] = $cmd;
			exec($cmd, $output);
			$output = implode("\r\n", $output);
			$res[] = $output;
			if (stripos($output, "CONFLICT") !== false) {
				$cmd = "ssh {$ssh_param}@{$host} -t -t 'cd %s ;  git rebase --abort'";
				$cmd = sprintf($cmd, $path);
				$res[] = $cmd;
				exec($cmd, $output);
				$output = implode("\r\n", $output);
				$res[] = $output;
			}
			$res[] = "------------- $host  end(".date("Y-m-d H:i:s").") --------------------\r\n\r\n";
		}

        return implode("\r\n", $res);
    }

    /*写入版本信息*/
    private function writeReleaseVersion( $repo_config ){

        if( !$repo_config || !isset( $repo_config['version'] ) ){
            return false;
        }

		$res = [];
        $version = date("YmdHis");
        $hosts = [];
        $ssh_param = '';
        //本地机器写入版本信息
        if( isset( $repo_config['feature'] ) ){
			$hosts[] = 'local';
		}

		//远程机器写入版本信息
        if( isset( $repo_config['remote'] ) && isset( $repo_config['remote']['hosts'] )  ){
			$hosts = array_merge( $hosts, $repo_config['remote']['hosts'] );
			$ssh_param = isset( $repo_config['remote']['ssh_param'] )?$repo_config['remote']['ssh_param']:'';
		}


		if( !$hosts ){
        	return false;
		}

		foreach( $hosts  as $_host){
			$res[] = "------------- $_host  start(".date("Y-m-d H:i:s").") --------------------\r\n";
			foreach( $repo_config['version'] as $_path ){
				if( $_host == "local" ){
					$cmd = "echo {$version} > %s ";
				}else{
					$cmd = "ssh {$ssh_param}@{$_host} -t -t 'echo {$version} > %s'";
				}
				$cmd = sprintf($cmd, $_path);
				$res[] = $cmd;
				exec($cmd, $output);
				$output = implode("\r\n", $output);
				$res[] = $output;
			}
			$res[] = "------------- $_host  end(".date("Y-m-d H:i:s").") --------------------\r\n";
		}


        return implode("\r\n", $res);
    }

}
