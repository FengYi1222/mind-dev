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
if (xiu_execute('select created from tiezi where status = "published" and id = ' . $id .';')) {
	$rows = xiu_execute('update tiezi set status = "drafted" where id = ' . $id .';');
	$val1 = "待审核";
	$val2 = "通过";
}else {
	$rows = xiu_execute('update tiezi set status = "published" where id = ' . $id .';');
	$val1 = "发布";
	$val2 = "待定";
}


// // if ($rows > 0) {}
// // http 中的 referer 用来标识当前请求的来源
// header('Location: /admin/comments.php');
header('Content-Type: application/json');

echo $json = json_encode(array(
	'val1' => $val1,
	'val2' => $val2
));


