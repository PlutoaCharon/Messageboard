<?php
/**
 * author：许浩翰
 */

header('Content-Type:text/html; charset=utf8');
require './framework/framework.class.php';
$app = new framework;
$app->runApp();


// localhost/Messageboard/index.php?p=admin&c=admin&a=login
// 在管理员登陆页面实现了验证码登陆

?>