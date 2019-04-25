<?php 
require_once '../functions.php';


// TODO: 获取文章内容
$posts = xiu_fetch_all("select
* from posts  where id = 18;"
);
// TODO: 根据所选文章来获取对应文章评论内容
$pinglun = xiu_fetch_all("select
* from tzpinglun;"
);

// TODO: 拿到对应的用户的信息  渲染到右边

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>心理杂志</title>
    <link rel="stylesheet" href="../static/assets/css/base.css">
    <link rel="stylesheet" href="../static/assets/css/main.css">
    <script src="../static/assets/vendors/jquery/jquery.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../static/assets/css/yueduwz.css">
</head>

<body>

    <div class="content clearfix mb30">
        <div class="main">
            <div class="left">
                <div class="left-a">
                    <div class="l-top">
                        <h3>我是文章标题</h3>
                        <div class="l-tip">
                            <span>活动日签</span>
                        </div>
                        <div class="l-xinxi"><span><?php echo $posts[0]['created'];?></span>
                            <span><?php echo $posts[0]['likes'];?> 赞</span>
                            <span><?php echo $posts[0]['replies']?> 评论</span>
                            <span><?php echo $posts[0]['views']?> 阅读</span></div>
                    </div>
                    <div class="l-m">
                        <?php echo $posts[0]['content']?>
                    </div>
                    <div class="l-b">
                        <a href=""><div class="dianzan">
                            <div class="dadianzan"></div><span><?php echo $posts[0]['likes']?></span></div></a>
                        <a href=""><div class="shoucang">收藏</div></a>
                    </div>
                </div>
                <div class="left-h">
                    <h2>回复</h2>
                    <div class="l-h-shuru">
                        <img src="../img/gu.jpeg" alt="">
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                        <div class="l-btn">提交回复</div>
                    </div>
                    <?php foreach ($pinglun as $item): ?>
                        <div class="l-h-huifu">
                            <div class="l-hf-content">
                                <img src="../img/gu.jpeg" alt="">
                                <div class="l-top-left"><span>用户名字</span>：<span><?php echo $item['content']?></span></div>
                                <div class="l-top-right">
                                    <span><?php echo $item['likes']?> 赞</span>
                                </div>
                                <div class="l-bottom-left">
                                    <span><?php echo $item['created']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="right">
                <div class="r-touxiang">
                    <img src="../img/gu.jpeg" alt="">
                    <p>我的名字</p>
                </div>
                <div class="r-fenlei">
                    <span>1文章</span>
                    <span>1问答</span>
                    <span>1获赞</span>
                </div>
            </div>
        </div>
    </div>

</body>

</html>