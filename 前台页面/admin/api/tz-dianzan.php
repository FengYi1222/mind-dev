<?php

/**
 * 根据客户端传递过来的ID修改对应数据
 */

require_once '../../functions.php';

if (empty($_POST['tzid'])) {
  exit('缺少必要参数');
}
// 所评论文章的id
$tzid = $_POST['tzid'];

// 更新点赞数

$rows = xiu_execute("update tiezi set likes = likes + 1 where id = {$tzid};");
	if(!$rows){
    	echo "数据库写入失败";
    }


// // if ($rows > 0) {}
// // http 中的 referer 用来标识当前请求的来源
// header('Location: /admin/comments.php');
header('Content-Type: application/json');

echo json_encode($rows > 0);

