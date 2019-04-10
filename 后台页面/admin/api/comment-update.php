<?php

/**
 * 根据客户端传递过来的ID修改对应数据
 */

require_once '../../functions.php';

if (empty($_GET['id'])) {
  exit('缺少必要参数');
}

// $id = (int)$_GET['id'];
$id = $_GET['id'];
// => '1 or 1 = 1'
// sql 注入
// 1,2,3,4
if (xiu_execute('select created from comments where status = "approved" and id = ' . $id .';')) {
	$rows = xiu_execute('update comments set status = "rejected" where id = ' . $id .';');
}else {
	$rows = xiu_execute('update comments set status = "approved" where id = ' . $id .';');
}


// // if ($rows > 0) {}
// // http 中的 referer 用来标识当前请求的来源
// header('Location: /admin/comments.php');
header('Content-Type: application/json');

echo json_encode($rows > 0);

