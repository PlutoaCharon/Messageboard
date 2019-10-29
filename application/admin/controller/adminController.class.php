<?php
/**
 * author：许浩翰
 */



/**
 * 管理员模块控制器类
 */
class adminController extends platformController{
	/**
	 * 登录方法
	 */

	public function loginAction(){
		//判断是否有表单提交
		if(!empty($_POST)){
			$captcha=new captcha();
			//判断验证码是否正确
			if(!$captcha->checkCode(strtolower($_POST['captcha']))){
                   //验证失败
                   die('输入的验证码不正确。');
			}
			//验证成功，继续执行
			$adminModel = new adminModel();
			//调用验证方法
			if($adminModel->checkByLogin()){
				//登录成功
				session_start();
				$_SESSION['admin'] = 'yes';
				//跳转
				$this->jump('index.php?p=admin');
			}else{
				//登录失败
				die('登录失败，用户名或密码错误。');
			}
			
	    }
        //载入视图文件
		require('./application/admin/view/admin_login.html');
}

	/**
	 * 添加验证码
	 */

	public function captchaAction(){
		$captcha = new captcha();
		$captcha->generate();
}

	/**
	 * 退出方法
	 */
	public function logoutAction(){
		$_SESSION = null;
		session_destroy();
		//跳转
		$this->jump('index.php?p=admin');
	}
}
