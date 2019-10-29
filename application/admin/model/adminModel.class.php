<?php
/**
 * admin模型类
 */
class adminModel extends model{
	/**
	 * 验证登录
	 */
	public function checkByLogin(){
		//过滤输入数据
		$this->filter(array('username','password'),'trim');  //系统函数function trim ($str, $charlist = " \t\n\r\0\x0B") {}
		//接收输入数据
		$username = $_POST['username'];
		$password = $_POST['password'];
		//通过用户名查询密码信息
		$sql = 'select `password`,`salt` from `admin` where `username`=:username';
		$data = $this->db->fetchRow($sql,array(':username'=>$username));
		//判断用户名和密码
		if(!$data){
			//用户名不存在
			return false;
		}
		//返回密码比较结果
		return md5($password.$data['salt']) == $data['password'];
	}
}
