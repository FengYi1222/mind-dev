<?php 
require_once '../functions.php';


 $id = $_GET['id'];
// 获取帖子数据
$tiezi = xiu_fetch_all("select
* from tiezi  where id = ".$id.";"
);

// var_dump($tiezi);

// TODO 获取帖子评论数据
$tz_pinglun = xiu_fetch_all("select
* from tzpinglun  where tiezi_id = ".$id.";"
);

// TODO  获取用户关于帖子的数据


?>
<!DOCTYPE html>
<html lang="en">

<head> 
    <meta charset="UTF-8">
    <title>心理问答</title>
    <link rel="stylesheet" href="../static/assets/css/base.css">
    <link rel="stylesheet" href="../static/assets/css/main.css">
    <script src="../static/assets/vendors/jquery/jquery.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../static/assets/css/gktiezi.css">
</head>

<body>
    <?php $current_page = 'six'; ?>
    <?php include 'inc/nav.php'; ?>
    <div class="content clearfix">
        <div class="main">
            <div class="fl">
                <div class="fl-master">
                    <div class="fl-t">

                        <div class="fl-ti"><img src="" alt=""></div>
                            <div class="fl-tt"><?php echo $tiezi[0]['title'];?></div>
                            <div class="fl-ta"><?php echo $tiezi[0]['replies'];?>个回答</div>
                        </div>
                        <p class="fl-xinxi">
                            <span class="fl-xxt"><?php echo $tiezi[0]['created'];?></span>
                            <span class="fl-xxr"><?php echo $tiezi[0]['views'];?> 阅读</span>
                        </p>
                        <div class="fl-m"><?php echo $tiezi[0]['content'];?></div>
                        <div class="fl-b"></div>
                    </div>
                    <div class="fl-select">
                        <div class="fl-select1">
                            <img src="../img/拥抱.png" alt="">
                            <a href="#"><span>给TA抱抱</span></a>
                            <span><?php echo $tiezi[0]['likes'];?>个抱抱</span></div>
                        <div class="fl-select2">
                            <img src="../img/收藏.png" alt="">
                            <a href="#"><span>收藏问题</span></a>
                            <span>15个收藏</span></div>
                        <div class="fl-select3">
                            <img src="../img/大回答.png" alt="">
                            <a href="#"><span>我来回答</span></a>
                            <span><?php echo $tiezi[0]['replies'];?>个回答</span></div>
                    </div>
                    <?php if($tz_pinglun):?>
                    <?php foreach ($tz_pinglun as $item): ?>
                    <div class="fl-huida">
                        <div class="fl-hdt">
                            <div class="fl-ti"></div>
                            <div class="fl-tn">白猫医心</div>
                        </div>
                        <div class="fl-hdb">
                            <?php echo $item['content'];?>
                        </div>
                        <div class="fl-hdx">
                            <div class="fl-hdtime"><?php echo $item['created'];?></div>
                            <div class="fl-hddz"><span> <?php echo $item['likes'];?></span>有用</div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <?php else:?>
                        <div>没有回复</div>
                <?php endif;?>
                </div>
                <!-- 右边 -->
                <div class="fr">
                    <div class="fr-top">
                        <div class="fr-t-t">
                            <div class="fr-t-tl">
                                <p>0</p>
                                <p>回答数</p>
                            </div>
                            <div class="fr-t-tr">
                                <p>0</p>
                                <p>提问数</p>
                            </div>
                        </div>
                        <div class="fr-t-b">
                            <a href="">
                            <div class="fr-t-bl">我要提问</div></a>
                            <a href="">
                            <div class="fr-t-br">我的回答</div></a>
                        </div>
                    </div>
                    <div class="fr-bottom"></div>
                </div>
            </div>
        </div>
</body>

</html>