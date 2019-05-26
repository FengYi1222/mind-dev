<?php 

if(empty($_SESSION['current_login_user'])){
    $current_user = null;
}else {
    $current_user = $_SESSION['current_login_user'];
    $GLOBALS['user_id'] = $current_user['id'];
    $GLOBALS['user_email'] = $current_user['email'];
    $GLOBALS['user_nickname'] = $current_user['nickname'];
    $GLOBALS['user_avatar'] = $current_user['avatar'];
    $GLOBALS['user_content'] = $current_user['content'];
    $GLOBALS['user_status'] = $current_user['status'];
    $GLOBALS['user_power'] = $current_user['power'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../static/assets/css/base.css">
    <link rel="stylesheet" href="../static/assets/css/main.css">
    <script src="../static/assets/vendors/jquery/jquery.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../static/assets/css/yinyue.css">
    <script src="../static/assets/js/base.js" type="text/javascript"></script>
</head>

<body>
    <?php $current_page = 'seven'; ?>
    <?php include 'inc/nav.php'; ?>
    <div class="yinyue clearfix">
        <div class="xiangce">
            <div class="bg-yi">
                <div class="bg-yi-li"></div>
            </div>
            <div class="bg-er">
                <div class="bg-er-li"></div>
            </div>
            <div class="bg-san">
                <div class="bg-san-li"></div>
            </div>
            <div class="bg-si">
                <div class="bg-si-li"></div>
            </div>
        </div>
        <div class="bofangqi">
        	
        </div>
        <div class="yinyueliebiao">
        	<div class="liebiao-content">
        		<div class="lb-ct-content">
        			<ul>
        				<li>音乐列表</li>
        				<li>音乐1</li>
        				<li>音乐1</li>
        				<li>音乐1</li>
        				<li>音乐1</li>
        				<li>音乐1</li>
        			</ul>	
        		</div>
        		
        	</div>
        </div>
        <div class="yinyuedianshi">
        	<div class="dianshi-buju">
        		<div class="dianshi-content">
        			视屏
        		</div>
        	</div>
        </div>
    </div>
</body>

</html>