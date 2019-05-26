<?php 
require_once '../functions.php';


if(empty($_SESSION['current_login_user'])){
  $current_user = null;
}else {
  $current_user = $_SESSION['current_login_user'];
}

$id = $_GET['id'];

// 获取帖子数据
$tiezi = xiu_fetch_all("select * from tiezi right join users on tiezi.`user_id` = users.`id` where tiezi.`id` = ".$id.";");
// var_dump($tiezi);
 // echo $tiezi['replies'];
// TODO 获取用户和帖子评论数据
$tz_pinglun = xiu_fetch_all("select *,tzpinglun.id as c_id from tzpinglun right join users on tzpinglun.`user_id` = users.`id` where tzpinglun.tiezi_id = ".$id." order by tzpinglun.id desc;");
// var_dump($tz_pinglun);
// 刷新帖子观看数
$row = xiu_execute("update tiezi set views = views + 1 where id = '{$id}';");



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
    <script src="../static/assets/js/base.js" type="text/javascript"></script>
</head>

<body>
    <?php $current_page = 'six'; ?>
    <?php include 'inc/nav.php'; ?>
    <div class="content clearfix gktiezi">
        <div class="main">
            <div class="fl">
                <div class="fl-master">
                    <div class="fl-t">
                            <img src="<?php echo $tiezi[0]['avatar'];?>" alt="" class="fl-ti">
                            <div class="fl-tt"><?php echo $tiezi[0]['title'];?></div>
                            <div class="fl-ta"><span class="db-pl" id="db-pl"><?php echo $tiezi[0]['replies'];?></span>个回答</div>
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
                            <a href="javascript:;"></a><span class="baobao dianzan">给TA抱抱</span>
                            <span class="dianzan-val" id="dianzan"><?php echo $tiezi[0]['likes'];?>个抱抱</span></div>
                        <div class="fl-select2">
                            <img src="../img/收藏.png" alt="">
                            <a href="#"><span class="shoucang">收藏问题</span></a>
                            <span>15个收藏</span></div>
                        <div class="fl-select3">
                            <img src="../img/大回答.png" alt="">
                            <a href="javascript:;" ><span class="huida">我来回答</span></a>
                            <span><span class="db-pl"><?php echo $tiezi[0]['replies'];?></span>个回答</span></div>
                    </div>
                     <div class="l-h-shuru">
                            <textarea name="neirong" id="shuchu" cols="30" rows="10" class="shuchu" placeholder="请输入评论内容"></textarea>
                            <button class="l-btn">提交回答</button>
                    </div>
                    <?php if($tz_pinglun):?>
                    <?php foreach ($tz_pinglun as $item): ?>
                    <div class="fl-huida">
                      <div class="yh-id" hidden><?php echo $item['id']?></div>
                        <div class="fl-hdt">
                            <img src="<?php echo $item['avatar'];?>" alt="" class="fl-ti">
                            <div class="fl-tn"><?php echo $item['nickname'];?></div>
                        </div>
                        <div class="fl-hdb">
                            <?php echo $item['content'];?>
                        </div>
                        <div class="fl-hdx">
                            <div class="fl-hdtime"><?php echo $item['created'];?></div>
                            <div><span class="fl-hddz db-yh-zan"><?php echo $item['likes'];?>
                            <div class="com-id" hidden><?php echo $item['c_id'];2?></div>
                            </span></div>
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
                                <p><?php echo $current_user['tzct']?></p>
                                <p>提问数</p>
                            </div>
                            <div class="fr-t-tr">
                                <p><?php echo $current_user['tzch']?></p>
                                <p>回答数</p>
                            </div>
                        </div>
                        <div class="fr-t-b">
                            <a href="/前台页面/admin/g-帖子发表页面.php">
                            <div class="fr-t-bl">我要提问</div></a>
<!--                             <a href="">
                            <div class="fr-t-br">我的回答</div></a> -->
                        </div>
                    </div>
                    <div class="fr-bottom"></div>
                </div>
            </div>
        </div>

<script>
    $('body').on('click','.l-btn',function () {
      var $tr = $("#shuchu").val();
      // console.log($tr)
      if(!$tr.length) {
        alert("请输入内容")
        return;
      }
      // TODO：获取当前帖子id
      var $tzid = <?php echo $id;?>;

      // TODO：获取评论人id
      var $prid = <?php echo $current_user['id']?>;

      // TODO：获取当前时间
      function getLocalTime(nS) {     
         return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');    
      }
      var $time = Math.round(new Date() / 1000);
      var $time = getLocalTime($time);
                
      // TODO：获取评论人(当前用户名字)姓名
      var $prname = <?php echo $current_user['nickname']?>;

      // TODO: 获取评论人的头像
      var $avatar = "<?php echo $current_user['avatar']?>"
      console.log($prid)

       // 2. 发送AJAX请求
       // TODO:将所有的数据更新到数据库
      $.post('/前台页面/admin/api/tz-pinglun-u.php', { tr: $tr, tzid: $tzid, prid: $prid,time: $time, prname: $prname }, function(res){
        if(!res) console.log("effect")
        // 3.渲染当前页面
        // TODO：将刚刚更新到数据库中的数据渲染到当前页面
        // 检测是否存在这个元素

        // TODO: 评论数的更新
        var val = $("#db-pl").text();
        val = parseInt(val) + 1;
        $(".db-pl").html(val);

        // 清空输出框
        $("#shuchu").html("");

        // TODO: 评论列表的更新
        var pinglun = $(".fl-huida:first").length;
        if(pinglun){
           $(".fl-huida:first").before('<div class="fl-huida"><div class="fl-hdt"><img src="'+$avatar+'" class="fl-ti"><div class="fl-tn">'+$prname+'</div></div><div class="fl-hdb">'+$tr+'</div><div class="fl-hdx"><div class="fl-hdtime">'+$time+'</div><div class="fl-hddz"><span>0</span>有用</div></div></div>')
         }else {
          $(".l-h-shuru").after('<div class="fl-huida"><div class="fl-hdt"><img src="'+$avatar+'" class="fl-ti"><div class="fl-tn">'+$prname+'</div></div><div class="fl-hdb">'+$tr+'</div><div class="fl-hdx"><div class="fl-hdtime">'+$time+'</div><div class="fl-hddz"><span>0</span>有用</div></div></div>')
         } 
       })
    })


    $('body').on('click','.dianzan',function () {
      // console.log("enen")
        var $tzid = <?php echo $id;?>;
        $.post('/前台页面/admin/api/tz-dianzan.php', { tzid: $tzid}, function(res){
          if(!res) console.log("effect")
          // 点赞数量的更新
          var val = $("#dianzan").text();
          val = parseInt(val) + 1;
          $(".dianzan-val").html(val+"个抱抱");
        })
    })

    $('body').on('click','.db-yh-zan',function () {
      // console.log("enen")
        console.log("en");
        // 帖子id

        // 用户id
        var $yhid = $(".yh-id").text();
        // console.log($yhid)

        // 对应评论id
        var $comid = $(this).children(".com-id").text();
        console.log($comid)
        // console.log($comid);

        var that = this;
        $.post('/前台页面/admin/api/tz-yh-pl.php', { yhid: $yhid, comid: $comid}, function(res){
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