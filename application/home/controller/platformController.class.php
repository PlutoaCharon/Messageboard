<?php
/**
 * home平台控制器
 */
class platformController{
	/**
	 * 跳转
	 * @param $url     目标URL
	 * @param $msg=''  提示信息
	 * @param $time=2  提示停留秒数
	 */
	protected function jump($url,$msg='',$time=2){
		if($msg==''){
			//没有提示信息
			header('Location: $url');
		}else{
			//有提示信息
			require('./application/home/view/jump.html');
		}
		//终止脚本执行
		die;
	}
}
