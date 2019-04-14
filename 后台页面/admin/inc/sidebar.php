<!-- 也可以使用 $_SERVER['PHP_SELF'] 取代 $current_page -->
<?php

// 因为这个 sidebar.php 是被 index.php 载入执行，所以 这里的相对路径 是相对于 index.php
// 如果希望根治这个问题，可以采用物理路径解决
require_once '../functions.php';
$current_page = isset($current_page) ? $current_page : '';
$current_user = xiu_get_current_user();

?>
<div class="aside">
  <div class="profile">
    <img class="avatar" src="<?php echo $current_user['avatar']; ?>">
    <h3 class="name"><?php echo $current_user['nickname']; ?></h3>
  </div>
  <ul class="nav">
    <li<?php echo $current_page === 'index' ? ' class="active"' : '' ?>>
      <a href="/后台页面/admin/index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
    </li>
    <?php $menu_posts = array('posts', 'post-add', 'categories','comments'); ?>
    <li<?php echo in_array($current_page, $menu_posts) ? ' class="active"' : '' ?>>
      <a href="#menu-posts"<?php echo in_array($current_page, $menu_posts) ? '' : ' class="collapsed"' ?> data-toggle="collapse">
        <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
      </a>
      <ul id="menu-posts" class="collapse<?php echo in_array($current_page, $menu_posts) ? ' in' : '' ?>">
        <li<?php echo $current_page === 'posts' ? ' class="active"' : '' ?>><a href="/后台页面/admin/posts.php">所有文章</a></li>
        <li<?php echo $current_page === 'comments' ? ' class="active"' : '' ?>>
      <a href="/后台页面/admin/comments.php">文章评论</a>
    </li>
        <li<?php echo $current_page === 'post-add' ? ' class="active"' : '' ?>><a href="/后台页面/admin/post-add.php">写文章</a></li>
        <!-- 分类目录的设置 -->
  <!--   <li<?php //echo $current_page === 'categories' ? ' class="active"' : '' ?>><a href="/后台页面/admin/categories.php">分类目录</a></li> -->
      </ul>
    </li>



<?php $menu_tiezi = array('tiezi', 'tzpinglun'); ?>
    <li<?php echo in_array($current_page, $menu_tiezi) ? ' class="active"' : '' ?>>
      <a href="#menu-tiezi"<?php echo in_array($current_page, $menu_tiezi) ? '' : ' class="collapsed"' ?> data-toggle="collapse">
        <i class="fa fa-comments"></i></i>帖子<i class="fa fa-angle-right"></i>
      </a>
      <ul id="menu-tiezi" class="collapse<?php echo in_array($current_page, $menu_tiezi) ? ' in' : '' ?>">
       
       <!-- 帖子部分 -->
    <li<?php echo $current_page === 'tiezi' ? ' class="active"' : '' ?>>
      <a href="/后台页面/admin/tiezi.php">所有帖子</a>
    </li>
    <!-- 帖子部分结束 -->
     <li<?php echo $current_page === 'tzpinglun' ? ' class="active"' : '' ?>>
      <a href="/后台页面/admin/tzpinglun.php">帖子评论</a>
    </li>
      </ul>
    </li>
    <!-- 用户栏目 -->
<!--     
    <li<?php// echo $current_page === 'users' ? ' class="active"' : '' ?>>
      <a href="/后台页面/admin/users.php"><i class="fa fa-users"></i>用户</a>
    </li> -->
    <?php $menu_settings = array('nav-menus', 'slides', 'settings'); ?>
    <li<?php echo in_array($current_page, $menu_settings) ? ' class="active"' : '' ?>>
      <a href="#menu-settings"<?php echo in_array($current_page, $menu_settings) ? '' : ' class="collapsed"' ?> data-toggle="collapse">
        <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
      </a>
      <ul id="menu-settings" class="collapse<?php echo in_array($current_page, $menu_settings) ? ' in' : '' ?>">
        <li<?php echo $current_page === 'nav-menus' ? ' class="active"' : '' ?>><a href="/后台页面/admin/music.php">音乐添加</a></li>
        <li<?php echo $current_page === 'slides' ? ' class="active"' : '' ?>><a href="/后台页面/admin/slides.php">图片轮播</a></li>
        <!-- 网站的设置 -->
        <!-- <li<?//php echo $current_page === 'settings' ? ' class="active"' : '' ?>><a href="/后台页面/admin/settings.php">网站设置</a></li> -->
      </ul>
    </li>
    <li<?php echo $current_page === 'douban' ? ' class="active"' : '' ?>>
      <a href="/后台页面/admin/douban.php"><i class="fa fa-list-alt"></i>电影榜单</a>
    </li>
  </ul>
</div>
