<?php
/**
 * 留言模块控制器类
 */
class commentController extends platformController{
	/**
	 * 留言列表
	 */
	public function listAction(){
		//实例化comment模型
		$commentModel = new commentModel();
		//取得留言总数
		$num = $commentModel->getNumber();
		//实例化分页类
		$page = new page($num,$GLOBALS['config'][PLATFORM]['pagesize']);
		//取得所有留言数据
		$data = $commentModel->getAll($page->getLimit());
		//取得分页导航链接
		$pageList = $page->getPageList();
		//载入视图文件
		require './application/admin/view/comment_list.html';
	}
	/**
	 * 回复/修改
	 */
	public function replyAction(){
		if(!isset($_GET['id'])){
			return false;
		}
		//实例化comment模型
		$commentModel = new commentModel();
		//取得指定ID的记录
		$data = $commentModel->getById();
		if($data==false){
			die('找不到这条记录。');
		}
		//载入视图文件
		require './application/admin/view/comment_reply.html';
	}
	/**
	 * 更新留言
	 */
	public function updateAction(){
		if(empty($_POST)){
			return false;
		}
		//实例化comment模型
		$commentModel = new commentModel();
		//更新记录
		if( $commentModel->save() ){
			$this->jump('index.php?p=admin&c=comment&a=list');
		}else{
			die('更新记录失败。');
		}
	}
	/**
	 * 删除留言
	 */
	public function deleteAction(){
		if(!isset($_GET['id'])){
			return false;
		}
		//实例化comment模型
		$commentModel = new commentModel();
		//删除指定ID记录
		if( $commentModel->deleteById() ){
			//完成后跳转
			$this->jump('index.php?p=admin&c=comment&a=list');
		}else{
			die('删除留言失败。');
		}
	}
}
