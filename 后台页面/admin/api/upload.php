<?php

// var_dump($_FILES['avatar']);
// 接受文件
// 保存文件
// 返回这个文件的访问 	URL


if(empty($_FILES['avatar'])) {
	exit('必须上传文件');
}


$avatar = $_FILES['avatar'];

if ($avatar['error'] !== UPLOAD_ERR_OK){
	exit('上传失败');
}

// 校验类型大小


$ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);

// 移动文件到网站范围之内
$target = '../../static/uploads/img-' . uniqid() . '.' . $ext;
// var_dump($avatar['tmp_name']);
// echo 'hehehe';
// var_dump($target);
if(!move_uploaded_file($avatar['tmp_name'], $target)) {
	exit('上传成功');
}

// 上传成功
echo substr($target, 3);