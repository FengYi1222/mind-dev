<?php 

require_once '../functions.php';

if(empty($_SESSION['current_login_user'])){
    $current_user = null;
}else {
    $current_user = $_SESSION['current_login_user'];
}

// xiu_get_current_user();
// 第一步：
// 1.1 拿到文章的数据 根据不同条件
$posts_hour = xiu_fetch_all("select
* from posts where category_id = 4 limit 5;"
);
$posts = xiu_fetch_all("select
* from posts where category_id = 4;"
);
// 1.2 TODO: 拿到对应文章的用户的头像


// TODO: 文章列表的懒加载 效果实现

// TODO： 复制这三个页面

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>心理杂志</title>
    <link rel="stylesheet" href="../static/assets/css/base.css">
    <link rel="stylesheet" href="../static/assets/css/main.css">
    <script src="../static/assets/vendors/jquery/jquery.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../static/assets/css/wenzhang.css">
    <script src="../static/assets/js/base.js" type="text/javascript"></script>

</head>

<body>
    <?php $current_page = 'five'; ?>
    <?php include 'inc/nav.php'; ?>
    <div class="content clearfix">
        <div class="main">
        <!-- 这个尝试使用瀑布流 -->
        <div class="wz-l">
            <p>发布时间排序的文章</p>
            <?php foreach ($posts as $item): ?>            
            <div class="wz-xianshi">
                <div class="wz-touxiang"><img src="../img/gu.jpeg" alt=""></div>
                    <a href="/前台页面/admin/d-阅读文章页面.php?id=<?php echo $item['id'];?>"><div class="wz-biaoti"><?php echo $item['title']; ?></div></a>
                    <div class="wz-neirong"><?php echo $item['content']; ?></p>
                    </div>
                    <div class="wz-guankan"><?php echo $item['views']; ?> 观看数</div>
                    <div class="wz-pinglun"><?php echo $item['replies']; ?> 评论数</div>
            </div>
            <?php endforeach; ?>
        </div>

            <div class="wz-r">
                <p>好文共赏</p>
                <div class="wzl-btn">
                    <div class="wzl-btn1">过去24小时</div>
                    <div class="wzl-btn2">过去7天</div>
                    <div class="wzl-btn3">过去1月</div>
                </div>
                <?php foreach ($posts_hour as $item): ?>
                <div class="wzl-xianshi">
                    <div class="wzl-touxiang"><img src="../img/gu.jpeg" alt=""></div>
                    <a href="/前台页面/admin/d-阅读文章页面.php?id=<?php echo $item['id'];?>"><div class="wzl-biaoti"><?php echo $item['title'] ?></div></a>
                    <div class="wzl-neirong"><?php echo $item['content']?></div>
                </div>
                <?php endforeach;?>

                 
            <div class="lianjie">
                <a href="#"><div class="lt-lianjie">论坛栏目链接</div></a>
                <a href="#"><div class="yy-lianjie">音乐栏目链接</div></a>
                <a href="#"><div class="tg-lianjie">自己投稿</div></a>
            </div>
            </div>


        </div>

    </div>
</body>

</html>