<?php
/**
 * comment模型类
 */
class commentModel extends model{
	/**
	 * 留言列表
	 */
	public function getAll($limit){
		//拼接SQL
		$sql = "select `id`,`poster`,`comment`,`date`,`reply`,`mail`,`ip` from `comment` order by id desc limit $limit";
		//查询结果
		$data = $this->db->fetchAll($sql);
		return $data;
	}
	/**
	 * 留言总数
	 */
	public function getNumber(){
		$data = $this->db->fetchRow("select count(*) from `comment`");
		return $data['count(*)'];
	}
	/**
	 * 取得指定ID记录
	 */
	public function getById(){
		$id = (int)$_GET['id'];
		$sql = "select `poster`,`comment`,`reply`,`mail` from `comment` where id=$id";
		$data = $this->db->fetchRow($sql);
		//处理换行符
		if($data!=false){
			$data['comment'] = str_replace('<br />','',$data['comment']);
			$data['reply'] = str_replace('<br />','',$data['reply']);
		}
		return $data;
	}
	/**
	 * 更新记录
	 */
	public function save(){
		//输入过滤
		$this->filter(array('id'),'intval');
		$this->filter(array('poster','mail','comment','reply'),'htmlspecialchars');
		$this->filter(array('comment','reply'),'nl2br');
		//接收输入变量
		$id = $_POST['id'];
		$data['poster'] = $_POST['poster'];
		$data['mail'] = $_POST['mail'];
		$data['comment'] = $_POST['comment'];
		$data['reply'] = $_POST['reply'];
		//拼接sql语句
		$sql = "update `comment` set ";
		foreach($data as $k=>$v){
			$sql .= "`$k`=:$k,";
		}
		$sql = rtrim($sql,',');//去掉最右边的逗号
		$sql .= " where id=$id";
		//通过预处理执行SQL
		$this->db->execute($sql,$data,$flag);
		//返回是否执行成功
		return $flag;
	}
	/**
	 * 删除指定ID记录
	 */
	public function deleteById(){
		$id = (int)$_GET['id'];
		$sql = "delete from `comment` where id=:id";
		//通过预处理执行SQL
		$this->db->execute($sql,array(':id'=>$id),$flag);
		//返回是否执行成功
		return $flag;
	}
}
