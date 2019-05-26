<?php 
require_once '../functions.php';

if(empty($_SESSION['current_login_user'])){
  $current_user = null;
}else {
  $current_user = $_SESSION['current_login_user'];
}
// var_dump($current_user);
$id = $_GET['id'];
$posts = xiu_fetch_all("select * from posts right join users on posts.`user_id` = users.`id` where posts.`id` = ".$id.";");

// TODO: 根据所选文章来获取对应文章评论内容
$pinglun = xiu_fetch_all("select *,comments.id as c_id from comments right join users on comments.parent_id = users.id where post_id = ".$id." and comments.`status`
= 'approved' order by comments.`id`
desc;");

// TODO: 拿到对应的用户的信息  渲染到右边

// var_dump($pinglun);
// 刷新文章阅读数
$row = xiu_execute("update posts set views = views + 1 where id = '{$id}';");

// echo $current_user['nickname'];
// echo $current_user[wzch];

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
    <script src="../static/assets/js/base.js" type="text/javascript"></script>
</head>

<body>
    <?php if($posts[0]['category_id']=='1'){
        $current_page = 'two';
        }; ?>
    <?php if($posts[0]['category_id']=='2'){
        $current_page = 'tree';
        }; ?>
    <?php if($posts[0]['category_id']=='3'){
        $current_page = 'four';
        }; ?>
    <?php if($posts[0]['category_id']=='4'){
        $current_page = 'five';
        }; ?>
    <?php include 'inc/nav.php'; ?>
    <div class="content clearfix mb30">
        <div class="main">
            <div class="left">
                <div class="left-a">
                    <div class="l-top">
                        <h3><?php echo $posts[0]['title'];?> </h3>
                        <div class="l-tip">  
                            <?php if($posts[0]['category_id']=='1'){
                                echo "<span>情感交流</span>";
                            }; ?>
                            <?php if($posts[0]['category_id']=='2'){
                                echo "<span>人际交往</span>";
                            }; ?>
                            <?php if($posts[0]['category_id']=='3'){
                                echo "<span>自我提升</span>";
                            }; ?>
                            <?php if($posts[0]['category_id']=='4'){
                                echo "<span>幸福生活</span>";
                            }; ?>
                        </div>
                        <div class="l-xinxi"><span class="biaoshi"><?php echo $posts[0]['created'];?></span>
                            <span class="biaoshi"><span class="dianzan-val"><?php echo $posts[0]['likes'];?></span>赞</span>
                            <span class="biaoshi"><span class="db-pl" id="db-pl"><?php echo $posts[0]['replies']?></span>评论</span>
                            <span class="biaoshi"><span><?php echo $posts[0]['views']?> </span>阅读</span></div>
                    </div>
                    <div class="l-m">
                        <?php echo $posts[0]['content']?>
                    </div>
                    <div class="l-b">
                        <div class="dianzan">
                            <div class="dadianzan"></div><span id="dianzan" class="dianzan-val"><?php echo $posts[0]['likes']?></span></div>
                        <a href=""><div class="shoucang">收藏</div></a>
                    </div>
                </div>
                <div class="left-h">
                    <h2>回复</h2>
                        <div class="l-h-shuru">
                            <img src="<?php echo $current_user['avatar']?>" alt="">
                            <textarea name="neirong" id="shuchu" cols="30" rows="10" class="shuchu" placeholder="请输入评论内容"></textarea>
                            <button class="l-btn">提交回复</button>
                        </div>
                    <?php if(isset($pinglun)):?>
                    <?php foreach ($pinglun as $item): ?>
                        <div class="l-h-huifu">
                            <div class="l-hf-content">
                                <img src="<?php echo $item['avatar']?>" alt="">
                                <div class="l-top-left"><span><?php echo $item['author']?></span>：<span><?php echo $item['content']?></span></div>
                                <div class="l-top-right">
                                    <span class="db-yh-zan"><?php echo $item['likes']?>
                                    <div class="com-id" hidden><?php echo $item['c_id']?></div>
                                    <div class="yh-id" hidden><?php echo $item['id']?></div></span>
                                </div>
                                <div class="l-bottom-left">
                                    <span><?php echo $item['created']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                </div>
            </div>
            <div class="right">
                <div class="r-touxiang">
                    <img src="<?php echo $current_user['avatar']?>" alt="">
                    <p><?php echo $current_user['nickname']?></p>
                </div>
                <div class="r-fenlei">
                    <span><?php echo $current_user['wzch']?>回答</span>
                    <span><?php echo $current_user['wzcz']?>获赞</span>
                </div>
            </div>
        </div>
    </div>

<script>
    $('body').on('click','.l-btn',function () {
   
        var $tr = $("#shuchu").val();
        if(!$tr.length) {
          alert("请输入内容")
          return;
        }
        // TODO：获取当前文章id
        var $wzid = <?php echo $id;?>;

        // TODO：获取评论人id
        var $prid = <?php echo $current_user['id']?>;

        // TODO：获取当前时间
        function getLocalTime(nS) {     
           return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');    
        }
        var $time = Math.round(new Date() / 1000);
        var $time = getLocalTime($time);

            
        // TODO：获取评论人(当前用户名字)姓名
        var $prname = "<?php echo $current_user['nickname']?>";

        // TODO: 获取评论人的头像
        var $avatar = "<?php echo $current_user['avatar']?>"



         // 2. 发送AJAX请求
         // TODO:将所有的数据更新到数据库
        $.post('/前台页面/admin/api/wz-pinglun-u.php', { tr: $tr, wzid: $wzid, avatar: $avatar, prid: $prid, time: $time, prname: $prname }, function(res){
          if(!res) console.log("effect")
          // 3.渲染当前页面
          // TODO：将刚刚更新到数据库中的数据渲染到当前页面
          // 检测是否存在这个元素
          // 评论数量的更新
          var val = $("#db-pl").text();
          val = parseInt(val) + 1;
          $(".db-pl").html(val);

          // 清空输入框
          $("#shuchu").html("");

          // 评论数据的更新
          var pinglun = $(".l-h-huifu:first").length;
          if(pinglun){
             $(".l-h-huifu:first").before('<div class="l-h-huifu"><div class="l-hf-content"><img src="<?php echo $current_user['avatar']?>" alt=""><div class="l-top-left"><span>'+$prname+'</span>：<span>'+$tr+'</span></div><div class="l-top-right"><span>0赞</span></div><div class="l-bottom-left"><span>'+$time+'</span></div></div></div>')
           }else {
            $(".l-h-shuru").after('<div class="l-h-huifu"><div class="l-hf-content"><img src="<?php echo $current_user['avatar']?>" alt=""><div class="l-top-left"><span>'+$prname+'</span>：<span>'+$tr+'</span></div><div class="l-top-right"><span>0赞</span></div><div class="l-bottom-left"><span>'+$time+'</span></div></div></div>')
           } 

       })
    })

    $('body').on('click','.dianzan',function () {
      // console.log("enen")
        var $prid = <?php echo $current_user['id']?>;
        var $wzid = <?php echo $id;?>;
        $.post('/前台页面/admin/api/wz-dianzan.php', { wzid: $wzid, prid: $prid}, function(res){
          if(!res) console.log("effect")
          // 点赞数量的更新
          var val = $("#dianzan").text();
          val = parseInt(val) + 1;
          $(".dianzan-val").html(val);
        })
    })

    $('body').on('click','.db-yh-zan',function () {
      // console.log("enen")
        console.log("en");
        // 帖子id

        // 用户id
        var $yhid = $(this).children(".yh-id").text();

        // 对应评论id
        var $comid = $(this).children(".com-id").text();
        console.log($comid)
        // console.log($comid);

        var that = this;
        $.post('/前台页面/admin/api/wz-yh-pl.php', { yhid: $yhid, comid: $comid}, function(res){
          if(!res) console.log("effect")
          // 点赞数量的更新
          var val = $(that).text();
          // console.log(val);
          val = parseInt(val) + 1;
          $(that).html(val);
        })
    })
  </script>

</body>

</html>