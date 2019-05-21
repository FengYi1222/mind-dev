<?php

/**
 * 根据客户端传递过来的ID修改对应数据
 */

require_once '../../functions.php';

if (empty($_POST['tr'])) {
  exit('缺少必要参数');
}
// 帖子id

// 帖子评论人id
$prid = $_POST['prid'];

$prname = $_POST['prname'];
// 帖子评论创建时间名
$time = $_POST['time'];
// 帖子评论内容
$tr = $_POST['tr'];
// 喜欢人数

// 所评论帖子的id
$tzid = $_POST['tzid'];



$rows = xiu_execute("insert into tzpinglun (content,tiezi_id,user_id,likes) values ('{$tr}','{$tzid}','{$prid}',0);");

if(!$rows){
	echo "数据库写入失败";
}




// // if ($rows > 0) {}
// // http 中的 referer 用来标识当前请求的来源
// header('Location: /admin/comments.php');
header('Content-Type: application/json');

echo json_encode($rows > 0);

