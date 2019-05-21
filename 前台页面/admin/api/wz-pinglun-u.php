<?php

/**
 * 根据客户端传递过来的ID修改对应数据
 */

require_once '../../functions.php';

if (empty($_POST['tr'])) {
  exit('缺少必要参数');
}
// 文章id

// 文章评论人名
$prname = $_POST['prname'];
// 文章评论创建时间名
$time = $_POST['time'];
// 文章评论内容
$tr = $_POST['tr'];
// 喜欢人数

// 文章评论状态

// 所评论文章的id
$wzid = $_POST['wzid'];
// 文章评论人id
$prid = $_POST['prid'];


$rows = xiu_execute("insert into comments (author,content,post_id,parent_id,likes,status) values ('{$prname}','{$tr}','{$wzid}','{$prid}',0,'approved');");

if(!$rows){
	echo "数据库写入失败";
}




// // if ($rows > 0) {}
// // http 中的 referer 用来标识当前请求的来源
// header('Location: /admin/comments.php');
header('Content-Type: application/json');

echo json_encode($rows > 0);

