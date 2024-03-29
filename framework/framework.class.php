<?php
/**
 * 框架基础类
 */
class framework{
	public function runApp(){
		$this->loadConfig();        //加载配置
		$this->registerAutoLoad();  //注册自动加载方法
		$this->getRequestParams();  //获得请求参数
		$this->dispatch();          //请求分发
	}
	/**
	 * 注册自动加载方法　，加载类里的方法可以用数组　array($this,'user_autoload')
	 */
	private function registerAutoLoad(){
		spl_autoload_register(array($this,'user_autoload'));
	}
	/**
	 * 自动加载方法
	 * $param $class_name string 类名
	 */
	public function user_autoload($class_name){
		//定义基础类列表
		$base_classes = array(
			//类名 => 所在位置	
			'model'		=> './framework/model.class.php',
			'MySQLPDO'	=> './framework/MySQLPDO.class.php',
			'page'		=> './framework/page.class.php',
			'captcha'   => './framework/captcha.class.php',
		);
		//依次判断 基础类、模型类、控制器类
		if (isset($base_classes[$class_name])){
			require $base_classes[$class_name];
		}elseif (substr($class_name,-5) == 'Model'){
			require './application/'.PLATFORM."/model/{$class_name}.class.php";
		}elseif (substr($class_name, -10) == 'Controller'){
			require './application/'.PLATFORM."/controller/{$class_name}.class.php";
		}
	}
	/**
	 * 载入配置文件
	 */
	private function loadConfig(){
		//使用全局变量保存配置
		$GLOBALS['config'] = require './application/config/app.conf.php';
	}
	/**
	 * 获取请求参数，p=平台 c=控制器 a=方法
     * 平台就是：　admin   home
     * 控制器：admin=>adminController commentControler platformControler 输出只输小写部分
     * action:具体方法，如admin中的 login logout
     * http://127.0.0.1/2-19/index.php?p=admin&c=admin&a=login
	 */
	private function getRequestParams(){
		//当前平台　　$GLOBALS['config']['app']['default_platform']);多维数组的访问方法
		define('PLATFORM', isset($_GET['p']) ? $_GET['p'] : $GLOBALS['config']['app']['default_platform']);
		//得到当前控制器名
		define('CONTROLLER', isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config'][PLATFORM]['default_controller']);
		//当前方法名
		define('ACTION', isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config'][PLATFORM]['default_action']);
	}
	/**
	 * 请求分发
	 */
	private function dispatch(){
		//实例化控制器
		$controller_name = CONTROLLER.'Controller';
		$controller = new $controller_name;
		//调用当前方法
		$action_name = ACTION . 'Action';
		$controller->$action_name();
	}

	
}
