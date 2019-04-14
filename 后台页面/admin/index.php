<?php

// // 校验数据当前访问用户的 箱子（session）有没有登录的登录标识
// session_start();

// if (empty($_SESSION['current_login_user'])) {
//   // 没有当前登录用户信息，意味着没有登录
//   header('Location: /admin/login.php');
// }
 
require_once '../functions.php';

// 判断用户是否登录一定是最先去做
xiu_get_current_user();

// 获取界面所需要的数据
// 重复的操作一定封装起来
$posts_count = xiu_fetch_one('select count(1) as num from posts;')['num'];

$tiezi_count = xiu_fetch_one('select count(1) as num from tiezi;')['num'];

$comments_count = xiu_fetch_one('select count(1) as num from comments;')['num'];
$tzpinglun_count = xiu_fetch_one('select count(1) as num from tzpinglun;')['num'];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="/后台页面/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/后台页面/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/后台页面/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/后台页面/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>

    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1 style='color: #0b8bff'>欢迎~</h1>
        <p>一切都是为了给用户更好的体验~~</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $posts_count; ?></strong>篇文章</li>
              <li class="list-group-item"><strong><?php echo $tiezi_count; ?></strong>个帖子</li>
              <li class="list-group-item"><strong><?php echo $comments_count; ?></strong>条文章评论</li>
               <li class="list-group-item"><strong><?php echo $tzpinglun_count; ?></strong>条帖子评论</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <canvas id="chart"></canvas>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <?php $current_page = 'index'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/后台页面/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/后台页面/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/后台页面/static/assets/vendors/chart/Chart.js"></script>
  <script>
    var ctx = document.getElementById('chart').getContext('2d')
    new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [
          {
            data: [<?php echo $posts_count; ?>, <?php echo $tiezi_count; ?>,<?php echo $comments_count; ?>, <?php echo $tzpinglun_count; ?>],
            backgroundColor: [
              'hotpink',
              'pink',
              'deeppink',
              '#ffccaa',
            ]
          },
          {
            data: [<?php echo $posts_count; ?>, <?php echo $tiezi_count; ?>, <?php echo $comments_count; ?>, <?php echo $tzpinglun_count; ?>],
            backgroundColor: [
              'hotpink',
              'pink',
              'deeppink',
              '#ffccaa',
            ]
          }
        ],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
          '文章',
          '分类',
          '文章评论',
          '帖子评论',
        ]
      }
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
