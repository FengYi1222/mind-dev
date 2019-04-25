<?php

require_once '../functions.php';

// xiu_get_current_user();
// 第一步：
// 1.1 拿到文章的数据
$posts_qinggan = xiu_fetch_all("select
* from posts where category_id = 1 limit 8;"
);

$posts_renji = xiu_fetch_all("select
* from posts where category_id = 2 limit 8;"
);

$posts_tisheng = xiu_fetch_all("select
* from posts where category_id = 3 limit 8;"
);


$posts_shenghuo = xiu_fetch_all("select
* from posts where category_id = 4 limit 8;"
);
// 1.2 TODO: 拿到对应文章的用户的头像

// 第二步
// 2.1 拿到评论的数据
$tiezi = xiu_fetch_all("select
* from tiezi limit 6;")

// 2.2 TODO: 拿到对应帖子用户的头像




// TODO: 将下面的链接全部布置好跳转到对应的文章或者 帖子的页面   后面使用 通过上面PHP拿到的id值  也添加过去，  那边接受对应ID值  将对应的数据库渲染出来

// TODO: 拿到的数据  是以什么为标准排序的  时间还是什么

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>心理栈</title>
<!-- 	<link rel="stylesheet" href=../static/assets/vendors/bootstrap/css/bootstrap.css"> -->
	<link rel="stylesheet" href="../static/assets/css/base.css">
	<link rel="stylesheet" href="../static/assets/css/main.css">
	<script src="../static/assets/vendors/jquery/jquery.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="../static/assets/css/zhuyemian.css">
<!--   <script src="../static/assets/vendors/bootstrap/css/bootstrap.css"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>l -->
	
</head>
<body>
<!-- TODO: 上面放一张图片 -->


<!-- TODO: tab栏切换效果实现 -->
<main class="zym">
	<!-- 热文推荐部分 -->
	<div class="rewen">
			<p>热文推荐:</p>
			<div class="rewen-nav">
				<div>情感交流</div>
				<div>人际交往</div>
				<div>自我提升</div>
				<div>幸福生活</div>
			</div>
			<div class="rewen-tupian">
        <?php foreach ($posts_qinggan as $item): ?>
  				<div class="rewen-dange">
  					<div class="rewen-touxiang"><img src="../img/3.jpg" alt=""></div>
  					<a href="#"><div class="rewen-biaoti"><?php echo $item['title']; ?></div></a>
  					<div class="rewen-neirong"><p><?php echo $item['content'] ?></p></div>
  				</div>
        <?php endforeach; ?>
			</div>
	</div>

	<div class="luntan">
			<p>心灵互诉:</p>
			<div class="luntan-neirong">
        <?php foreach ($tiezi as $item):?>
				<div class="neirong-w">
					<div class="neirong-l">
						<div class="neirong-tupian"><img src="../img/gu.jpeg" alt=""></div>
						<a href="#"><div class="nr-biaoti"><?php echo $item['title']?></div></a>
						<div class="nr-neirong"><?php echo $item['content']?></div>
					</div>
					<div class="neirong-r">
						<div class="nr-huida">
							<?php echo $item['replies'];?>个回答
						</div>
					</div>
				</div>
      <?php endforeach;?>
			</div>
	</div>

	<div class="music">
			<p>幻想城堡(音乐列表)</p>
			<a href="#"><div class="music-l">舒缓人心情的音乐</div></a>
			<a href=""><div class="music-r">激动人心的音乐</div></a>
			<div class="music-b">下面的部分</div>
	</div>

</main>
<div class="wel-footer">
	<script type="">
    	$('.wel-footer').load('inc/footer.html')
    </script>
</div>
<!-- 轮播图 实现 -->
</body>
</html>