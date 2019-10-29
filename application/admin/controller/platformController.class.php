<?php
/**
 * admin平台控制器
 */
class platformController{
	/**
	 * 构造方法
	 */
	public function __construct(){
		$this->checkLogin();
	}
	/**
	 * 验证当前用户是否登录
	 */
	private function checkLogin(){
		//login方法不需要验证
		if(CONTROLLER=='admin' && (ACTION=='login' || ACTION=='captcha')){
			return ;
		}
		//通过SESSION判断是否登录
		session_start();
		if(!isset($_SESSION['admin'])){
			//未登录跳转到login方法
			$this->jump('index.php?p=admin&c=admin&a=login');
		}
	}
	/**
	 * 跳转方法
	 */
	protected function jump($url){
		header("Location: $url");
		die;
	}
}
