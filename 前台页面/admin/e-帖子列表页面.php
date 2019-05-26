<?php 
require_once '../functions.php';


if(empty($_SESSION['current_login_user'])){
	$current_user = null;
}else {
	$current_user = $_SESSION['current_login_user'];
	// $GLOBALS['user_id'] = $current_user['id'];
	// $GLOBALS['user_email'] = $current_user['email'];
	// $GLOBALS['user_nickname'] = $current_user['nickname'];
	// $GLOBALS['user_avatar'] = $current_user['avatar'];
	// $GLOBALS['user_content'] = $current_user['content'];
	// $GLOBALS['user_status'] = $current_user['status'];
	// $GLOBALS['user_power'] = $current_user['power'];
}
// $GLOBALS['userid'] =  $current_user['id'];

// TODO: 获取帖子内容
$tiezi = xiu_fetch_all("select
* from tiezi order by tiezi.id desc;"
);


// TODO: 拿到对应的用户的信息  渲染到右边

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>心里问答</title>
	<link rel="stylesheet" href="../static/assets/css/base.css">
	<link rel="stylesheet" href="../static/assets/css/main.css">
	<script src="../static/assets/vendors/jquery/jquery.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="../static/assets/css/tzliebiao.css">
    <script src="../static/assets/js/base.js" type="text/javascript"></script>
</head>
<body>
	<?php $current_page = 'six'; ?>
	<?php include 'inc/nav.php'; ?>
	<div class="content clearfix">
			<div class="main">
		<div class="fl">
			<?php foreach ($tiezi as $item): ?>
				<div class="pinglun">
					<div class="pl-tupian"><img src="../img/gu.jpeg" alt=""></div>
					<a href="/前台页面/admin/f-观看帖子.php?id=<?php echo $item['id'];?>"><div class="pl-biaoti"><?php echo $item['title'];?></div></a>
					<div><p><?php echo $item['created'];?></p></div>
					<div class="pl-neirong">
						<?php echo $item['content'];?>
					</div>
					<div class="pl-pinglun"><?php echo $item['replies']?> 评论数</div>
					<div class="pl-guankan"><?php echo $item['views']?> 观看数</div>
				</div>
			<?php endforeach;?>
		</div>
		     <!-- 右边 -->
            <div class="fr">
                <div class="fr-top">
                    <div class="fr-t-t">
                        <div class="fr-t-tl"><p><?php echo $current_user['tzct']?></p><p>提问数</p></div>
                        <div class="fr-t-tr"><p><?php echo $current_user['tzch']?></p>
                            <p>回答数</p></div>
                    </div>
                    <div class="fr-t-b">
                        <a href="/前台页面/admin/g-帖子发表页面.php"><div class="fr-t-bl">我要提问</div></a>
<!--                         <a href=""><div class="fr-t-br">我的回答</div></a> -->
                    </div>
                </div>
                <div class="fr-bottom"></div>
            </div>		
	</div>
	</div>
</body>
</html>